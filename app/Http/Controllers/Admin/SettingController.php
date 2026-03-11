<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(): View
    {
        $settings = (object) [
            'store_name' => Setting::getValue('store_name', 'EpiDrive'),
            'phone' => Setting::getValue('contact_phone', ''),
            'email' => Setting::getValue('contact_email', ''),
            'address' => Setting::getValue('contact_address', ''),
            'opening_hours' => json_decode(Setting::getValue('opening_hours', '{}'), true) ?: [],
            'banner_texts' => json_decode(Setting::getValue('banner_texts', ''), true) ?: [
                ['emoji' => "\u{1F680}", 'text' => 'Livraison en 30min dans votre quartier'],
                ['emoji' => "\u{26A1}", 'text' => 'Livraison GRATUITE dès 25€ d\'achat'],
                ['emoji' => "\u{1F389}", 'text' => '-20% sur votre 1ère commande avec le code BIENVENUE'],
                ['emoji' => "\u{1F6D2}", 'text' => '+ de 2000 produits disponibles'],
            ],
            'online_payments_enabled' => Setting::getValue('online_payments_enabled', '1'),
            'partner_cta_enabled' => Setting::getValue('partner_cta_enabled', '1'),
            'promo_enabled' => Setting::getValue('promo_enabled', '1'),
            'promo_badge_emoji' => Setting::getValue('promo_badge_emoji', '🎁'),
            'promo_badge_text' => Setting::getValue('promo_badge_text', 'Offre spéciale'),
            'promo_title' => Setting::getValue('promo_title', 'Première commande ?'),
            'promo_text' => Setting::getValue('promo_text', '-20% avec le code BIENVENUE'),
            'promo_button_text' => Setting::getValue('promo_button_text', 'En profiter maintenant'),
            'promo_button_emoji' => Setting::getValue('promo_button_emoji', '🎉'),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'store_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
            'opening_hours' => 'nullable|array',
            'banner_texts' => 'nullable|array',
            'online_payments_enabled' => 'nullable|boolean',
            'partner_cta_enabled' => 'nullable|boolean',
            'promo_enabled' => 'nullable|boolean',
            'promo_badge_emoji' => 'nullable|string|max:10',
            'promo_badge_text' => 'nullable|string|max:100',
            'promo_title' => 'nullable|string|max:200',
            'promo_text' => 'nullable|string|max:300',
            'promo_button_text' => 'nullable|string|max:100',
            'promo_button_emoji' => 'nullable|string|max:10',
        ]);

        Setting::setValue('store_name', $validated['store_name']);
        Setting::setValue('contact_phone', $validated['phone'] ?? '');
        Setting::setValue('contact_email', $validated['email'] ?? '');
        Setting::setValue('contact_address', $validated['address'] ?? '');

        if (isset($validated['opening_hours'])) {
            Setting::setValue('opening_hours', json_encode($validated['opening_hours']));
        }

        if (isset($validated['banner_texts'])) {
            Setting::setValue('banner_texts', json_encode(array_values($validated['banner_texts'])));
        }

        Setting::setValue('online_payments_enabled', ($validated['online_payments_enabled'] ?? '0') ? '1' : '0');
        Setting::setValue('partner_cta_enabled', ($validated['partner_cta_enabled'] ?? '0') ? '1' : '0');

        Setting::setValue('promo_enabled', ($validated['promo_enabled'] ?? '0') ? '1' : '0');
        Setting::setValue('promo_badge_emoji', $validated['promo_badge_emoji'] ?? '🎁');
        Setting::setValue('promo_badge_text', $validated['promo_badge_text'] ?? '');
        Setting::setValue('promo_title', $validated['promo_title'] ?? '');
        Setting::setValue('promo_text', $validated['promo_text'] ?? '');
        Setting::setValue('promo_button_text', $validated['promo_button_text'] ?? '');
        Setting::setValue('promo_button_emoji', $validated['promo_button_emoji'] ?? '🎉');

        return back()->with('success', 'Parametres mis a jour avec succes.');
    }
}
