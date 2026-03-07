<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        $cart = session('cart', []);
        $cartItems = [];
        $total = 0;

        if (! empty($cart)) {
            $products = Product::whereIn('id', array_keys($cart))
                ->where('is_active', true)
                ->get()
                ->keyBy('id');

            foreach ($cart as $productId => $quantity) {
                if ($products->has($productId)) {
                    $product = $products->get($productId);
                    $subtotal = $product->price * $quantity;
                    $cartItems[] = [
                        'product' => $product,
                        'quantity' => $quantity,
                        'subtotal' => $subtotal,
                    ];
                    $total += $subtotal;
                }
            }
        }

        $itemCount = array_sum($cart);

        return view('cart.index', compact('cartItems', 'total', 'itemCount'));
    }

    public function add(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'sometimes|integer|min:1|max:99',
        ]);

        $product = Product::where('is_active', true)
            ->findOrFail($request->input('product_id'));

        $cart = session('cart', []);
        $productId = $product->id;
        $requestedQuantity = $request->input('quantity', 1);
        $currentQuantity = $cart[$productId] ?? 0;
        $newQuantity = $currentQuantity + $requestedQuantity;

        if ($product->stock !== null && $newQuantity > $product->stock) {
            $msg = 'Stock insuffisant. Seulement '.$product->stock.' article(s) disponible(s).';
            if ($request->expectsJson()) {
                return response()->json(['error' => $msg], 422);
            }

            return back()->with('error', $msg);
        }

        $cart[$productId] = $newQuantity;
        session(['cart' => $cart]);

        $msg = $product->name.' ajoute au panier.';
        if ($request->expectsJson()) {
            return response()->json(['success' => $msg, 'cart_count' => array_sum($cart)]);
        }

        return back()->with('success', $msg);
    }

    public function update(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:0|max:99',
        ]);

        $cart = session('cart', []);
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        if ($quantity <= 0) {
            unset($cart[$productId]);
        } else {
            $product = Product::where('is_active', true)->findOrFail($productId);
            if ($product->stock !== null && $quantity > $product->stock) {
                $msg = 'Stock insuffisant.';
                if ($request->expectsJson()) {
                    return response()->json(['error' => $msg], 422);
                }

                return back()->with('error', $msg);
            }
            $cart[$productId] = $quantity;
        }

        session(['cart' => $cart]);

        if ($request->expectsJson()) {
            return response()->json(['success' => 'Panier mis a jour.', 'cart_count' => array_sum($cart)]);
        }

        return back()->with('success', 'Panier mis a jour.');
    }

    public function remove(int $productId): JsonResponse|RedirectResponse
    {
        $cart = session('cart', []);
        unset($cart[$productId]);
        session(['cart' => $cart]);

        if (request()->expectsJson()) {
            return response()->json(['success' => 'Produit retire.', 'cart_count' => array_sum($cart)]);
        }

        return back()->with('success', 'Produit retire du panier.');
    }
}
