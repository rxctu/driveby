<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\SharedList;
use App\Models\SharedListComment;
use App\Models\SharedListVote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CommunityController extends Controller
{
    /**
     * Show the community feed with shared lists.
     */
    public function index(Request $request): View
    {
        $sort = $request->input('sort', 'recent');
        $tag = $request->input('tag');
        $search = $request->input('search');

        $query = SharedList::public()
            ->withCount('items')
            ->with('user');

        // Apply search filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'ilike', "%{$search}%")
                  ->orWhere('description', 'ilike', "%{$search}%")
                  ->orWhere('tags', 'ilike', "%{$search}%");
            });
        }

        // Apply tag filter
        if ($tag) {
            $query->where('tags', 'ilike', "%{$tag}%");
        }

        // Apply sorting
        match ($sort) {
            'popular' => $query->popular(),
            'trending' => $query->orderByDesc(
                DB::raw('likes_count + copies_count + views_count')
            ),
            default => $query->recent(),
        };

        $lists = $query->paginate(12)->withQueryString();

        // Get all unique tags for the filter sidebar
        $availableTags = SharedList::public()
            ->whereNotNull('tags')
            ->where('tags', '!=', '')
            ->pluck('tags')
            ->flatMap(fn (string $tags) => array_map('trim', explode(',', $tags)))
            ->filter()
            ->unique()
            ->sort()
            ->values();

        return view('community.index', compact('lists', 'sort', 'tag', 'search', 'availableTags'));
    }

    /**
     * Show a single shared list.
     */
    public function show(SharedList $list): View|RedirectResponse
    {
        // Only allow viewing public lists or own lists
        if (!$list->is_public && (!Auth::check() || Auth::id() !== $list->user_id)) {
            abort(404);
        }

        // Increment views count
        $list->increment('views_count');

        $list->load([
            'user',
            'items.product',
            'comments' => fn ($q) => $q->with('user')->orderByDesc('created_at'),
        ]);

        $userVote = null;
        if (Auth::check()) {
            $vote = SharedListVote::where('shared_list_id', $list->id)
                ->where('user_id', Auth::id())
                ->first();
            $userVote = $vote?->vote;
        }

        $totalPrice = $list->totalPrice();

        return view('community.show', compact('list', 'userVote', 'totalPrice'));
    }

    /**
     * Show the create list form.
     */
    public function create(): View
    {
        $categories = Category::active()
            ->sorted()
            ->with(['products' => fn ($q) => $q->active()->orderBy('name')])
            ->get();

        return view('community.create', compact('categories'));
    }

    /**
     * Store a new shared list.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'tags' => 'nullable|string',
            'is_public' => 'boolean',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.note' => 'nullable|string|max:255',
        ], [
            'title.required' => 'Le titre est obligatoire.',
            'title.max' => 'Le titre ne peut pas depasser 255 caracteres.',
            'description.max' => 'La description ne peut pas depasser 1000 caracteres.',
            'items.required' => 'Vous devez ajouter au moins un produit.',
            'items.min' => 'Vous devez ajouter au moins un produit.',
            'items.*.product_id.required' => 'Chaque article doit avoir un produit.',
            'items.*.product_id.exists' => 'Un des produits selectionnes est invalide.',
            'items.*.quantity.required' => 'La quantite est obligatoire.',
            'items.*.quantity.min' => 'La quantite doit etre d\'au moins 1.',
            'items.*.note.max' => 'La note ne peut pas depasser 255 caracteres.',
        ]);

        // Generate unique slug
        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;
        $counter = 1;
        while (SharedList::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $list = SharedList::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'tags' => $validated['tags'] ?? null,
            'is_public' => $validated['is_public'] ?? true,
        ]);

        foreach ($validated['items'] as $item) {
            $list->items()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'note' => $item['note'] ?? null,
            ]);
        }

        return redirect()
            ->route('community.show', $list)
            ->with('success', 'Votre liste a ete creee avec succes !');
    }

    /**
     * Toggle vote (like/dislike) on a shared list.
     */
    public function vote(Request $request, SharedList $list): JsonResponse
    {
        $request->validate([
            'vote' => 'required|in:1,-1',
        ]);

        $voteValue = (int) $request->input('vote');
        $userId = Auth::id();

        $existingVote = SharedListVote::where('shared_list_id', $list->id)
            ->where('user_id', $userId)
            ->first();

        if ($existingVote) {
            if ($existingVote->vote === $voteValue) {
                // Same vote: remove it
                $existingVote->delete();

                if ($voteValue === 1) {
                    $list->decrement('likes_count');
                } else {
                    $list->decrement('dislikes_count');
                }
            } else {
                // Different vote: switch it
                $oldVote = $existingVote->vote;
                $existingVote->update(['vote' => $voteValue]);

                if ($oldVote === 1) {
                    $list->decrement('likes_count');
                    $list->increment('dislikes_count');
                } else {
                    $list->decrement('dislikes_count');
                    $list->increment('likes_count');
                }
            }
        } else {
            // New vote
            SharedListVote::create([
                'shared_list_id' => $list->id,
                'user_id' => $userId,
                'vote' => $voteValue,
            ]);

            if ($voteValue === 1) {
                $list->increment('likes_count');
            } else {
                $list->increment('dislikes_count');
            }
        }

        $list->refresh();

        // Determine user's current vote
        $currentVote = SharedListVote::where('shared_list_id', $list->id)
            ->where('user_id', $userId)
            ->first();

        return response()->json([
            'likes_count' => $list->likes_count,
            'dislikes_count' => $list->dislikes_count,
            'user_vote' => $currentVote?->vote,
        ]);
    }

    /**
     * Add a comment to a shared list.
     */
    public function comment(Request $request, SharedList $list): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'content' => 'required|string|max:500',
        ], [
            'content.required' => 'Le commentaire ne peut pas etre vide.',
            'content.max' => 'Le commentaire ne peut pas depasser 500 caracteres.',
        ]);

        $comment = SharedListComment::create([
            'shared_list_id' => $list->id,
            'user_id' => Auth::id(),
            'content' => $validated['content'],
        ]);

        $comment->load('user');

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'comment' => [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'user_name' => $comment->user->name,
                    'user_initial' => mb_substr($comment->user->name, 0, 1),
                    'created_at' => $comment->created_at->diffForHumans(),
                ],
            ]);
        }

        return redirect()
            ->route('community.show', $list)
            ->with('success', 'Commentaire ajoute avec succes.');
    }

    /**
     * Copy all items from a shared list to the session cart.
     */
    public function copyToCart(SharedList $list): JsonResponse
    {
        $cart = session('cart', []);

        $list->load('items.product');

        $addedCount = 0;

        foreach ($list->items as $item) {
            if ($item->product && $item->product->is_active) {
                $productId = $item->product_id;
                $currentQty = $cart[$productId] ?? 0;
                $newQty = $currentQty + $item->quantity;

                // Respect stock limits
                if ($item->product->stock !== null && $newQty > $item->product->stock) {
                    $newQty = $item->product->stock;
                }

                if ($newQty > 0) {
                    $cart[$productId] = $newQty;
                    $addedCount++;
                }
            }
        }

        session(['cart' => $cart]);

        // Increment copies count
        $list->increment('copies_count');

        $cartCount = array_sum($cart);
        session(['cart_count' => $cartCount]);

        return response()->json([
            'cart_count' => $cartCount,
            'message' => $addedCount . ' produit(s) ajoute(s) au panier.',
        ]);
    }

    /**
     * Show the current user's shared lists.
     */
    public function myLists(): View
    {
        $lists = SharedList::where('user_id', Auth::id())
            ->withCount('items', 'comments')
            ->recent()
            ->paginate(12);

        return view('community.my-lists', compact('lists'));
    }

    /**
     * Delete a shared list (owner only).
     */
    public function destroy(SharedList $list): RedirectResponse
    {
        if ($list->user_id !== Auth::id()) {
            abort(403, 'Vous ne pouvez supprimer que vos propres listes.');
        }

        $list->delete();

        return redirect()
            ->route('community.my-lists')
            ->with('success', 'La liste a ete supprimee avec succes.');
    }
}
