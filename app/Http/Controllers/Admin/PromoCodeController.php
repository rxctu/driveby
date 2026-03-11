<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PromoCodeController extends Controller
{
    public function index(): View
    {
        $promoCodes = PromoCode::latest()->get();

        $banner = (object) [
            'enabled' => Setting::getValue('promo_enabled', '1'),
            'badge_emoji' => Setting::getValue('promo_badge_emoji', "\u{1F381}"),
            'badge_text' => Setting::getValue('promo_badge_text', 'Offre speciale'),
            'title' => Setting::getValue('promo_title', 'Premiere commande ?'),
            'button_text' => Setting::getValue('promo_button_text', 'En profiter maintenant'),
            'button_emoji' => Setting::getValue('promo_button_emoji', "\u{1F389}"),
        ];

        $bannerTexts = json_decode(Setting::getValue('banner_texts', ''), true) ?: [
            ['emoji' => "\u{1F680}", 'text' => 'Livraison en 30min dans votre quartier'],
            ['emoji' => "\u{26A1}", 'text' => 'Livraison GRATUITE des 25EUR d\'achat'],
            ['emoji' => "\u{1F6D2}", 'text' => '+ de 2000 produits disponibles'],
        ];

        return view('admin.promo-codes.index', compact('promoCodes', 'banner', 'bannerTexts'));
    }

    public function updateBanner(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'promo_enabled' => 'nullable|boolean',
            'promo_badge_emoji' => 'nullable|string|max:10',
            'promo_badge_text' => 'nullable|string|max:100',
            'promo_title' => 'nullable|string|max:200',
            'promo_button_text' => 'nullable|string|max:100',
            'promo_button_emoji' => 'nullable|string|max:10',
            'banner_texts' => 'nullable|array',
        ]);

        Setting::setValue('promo_enabled', ($validated['promo_enabled'] ?? '0') ? '1' : '0');
        Setting::setValue('promo_badge_emoji', $validated['promo_badge_emoji'] ?? "\u{1F381}");
        Setting::setValue('promo_badge_text', $validated['promo_badge_text'] ?? '');
        Setting::setValue('promo_title', $validated['promo_title'] ?? '');
        Setting::setValue('promo_button_text', $validated['promo_button_text'] ?? '');
        Setting::setValue('promo_button_emoji', $validated['promo_button_emoji'] ?? "\u{1F389}");

        if (isset($validated['banner_texts'])) {
            Setting::setValue('banner_texts', json_encode(array_values($validated['banner_texts'])));
        }

        return back()->with('success', 'Parametres promotionnels mis a jour.');
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:promo_codes,code',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0.01',
            'min_order' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['code'] = strtoupper(trim($validated['code']));
        $validated['is_active'] = $request->boolean('is_active', true);

        $promo = PromoCode::create($validated);

        return response()->json(['status' => 'created', 'promo' => $promo]);
    }

    public function toggle(PromoCode $promoCode): JsonResponse
    {
        $promoCode->update(['is_active' => ! $promoCode->is_active]);

        return response()->json(['status' => 'toggled', 'is_active' => $promoCode->is_active]);
    }

    public function destroy(PromoCode $promoCode): JsonResponse
    {
        $promoCode->delete();

        return response()->json(['status' => 'deleted']);
    }
}
