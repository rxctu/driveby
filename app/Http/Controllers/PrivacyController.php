<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\SharedList;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PrivacyController extends Controller
{
    /**
     * Show user's personal data page (RGPD right of access).
     */
    public function myData(): View
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->with('items')->get();
        $lists = SharedList::where('user_id', $user->id)->get();

        return view('account.privacy', compact('user', 'orders', 'lists'));
    }

    /**
     * Export all user data as JSON (RGPD right of portability).
     */
    public function exportData(): StreamedResponse
    {
        $user = Auth::user();

        $data = [
            'informations_personnelles' => [
                'nom' => $user->name,
                'email' => $user->email,
                'telephone' => $user->phone,
                'adresse' => $user->address,
                'date_inscription' => $user->created_at->toIso8601String(),
            ],
            'commandes' => Order::where('user_id', $user->id)
                ->with('items')
                ->get()
                ->map(fn ($order) => [
                    'numero' => $order->order_number,
                    'date' => $order->created_at->toIso8601String(),
                    'statut' => $order->status,
                    'total' => $order->total,
                    'adresse_livraison' => $order->customer_address,
                    'articles' => $order->items->map(fn ($item) => [
                        'produit' => $item->product_name,
                        'quantite' => $item->quantity,
                        'prix_unitaire' => $item->unit_price,
                    ]),
                ]),
            'listes_partagees' => SharedList::where('user_id', $user->id)
                ->with('items')
                ->get()
                ->map(fn ($list) => [
                    'titre' => $list->title,
                    'description' => $list->description,
                    'date_creation' => $list->created_at->toIso8601String(),
                ]),
            'export_date' => now()->toIso8601String(),
        ];

        $filename = 'epidrive-donnees-' . $user->id . '-' . now()->format('Y-m-d') . '.json';

        return response()->streamDownload(function () use ($data) {
            echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }, $filename, [
            'Content-Type' => 'application/json',
        ]);
    }

    /**
     * Delete user account and anonymize data (RGPD right to erasure).
     */
    public function deleteAccount(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => 'required|string',
            'confirm_delete' => 'accepted',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->input('password'), $user->password)) {
            return back()->with('error', 'Mot de passe incorrect.');
        }

        // Anonymize orders (keep for accounting but remove PII)
        Order::where('user_id', $user->id)->update([
            'customer_name' => 'Utilisateur supprime',
            'customer_phone' => '0000000000',
            'customer_address' => 'Adresse supprimee',
            'delivery_instructions' => null,
            'user_id' => null,
        ]);

        // Delete shared lists
        SharedList::where('user_id', $user->id)->delete();

        // Delete user
        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Votre compte et vos donnees personnelles ont ete supprimes.');
    }
}
