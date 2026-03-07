<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliverySlot;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DeliveryController extends Controller
{
    public function index(): View
    {
        $slots = DeliverySlot::orderBy('day_of_week')
            ->orderBy('start_time')
            ->get();

        $settings = (object) [
            'base_delivery_price' => Setting::getValue('base_delivery_price', 4.99),
            'price_per_km' => Setting::getValue('price_per_km', 3),
            'max_distance_km' => Setting::getValue('max_distance_km', 20),
        ];

        return view('admin.delivery.index', compact('slots', 'settings'));
    }

    public function updatePricing(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'base_delivery_price' => 'required|numeric|min:0|max:100',
            'price_per_km' => 'required|numeric|min:0|max:100',
            'max_distance_km' => 'required|numeric|min:0|max:200',
        ]);

        foreach ($validated as $key => $value) {
            Setting::setValue($key, $value);
        }

        return back()->with('success', 'Tarifs de livraison mis a jour.');
    }

    public function storeSlot(Request $request): RedirectResponse
    {
        $dayMap = [
            'dimanche' => 0, 'lundi' => 1, 'mardi' => 2, 'mercredi' => 3,
            'jeudi' => 4, 'vendredi' => 5, 'samedi' => 6,
        ];

        $validated = $request->validate([
            'day' => 'required|string|in:'.implode(',', array_keys($dayMap)),
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'max_orders' => 'required|integer|min:1|max:200',
            'is_active' => 'nullable',
        ]);

        DeliverySlot::create([
            'day_of_week' => $dayMap[$validated['day']],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'max_orders' => $validated['max_orders'],
            'is_active' => $request->boolean('is_active', true),
        ]);

        return back()->with('success', 'Creneau ajoute avec succes.');
    }

    public function toggleSlot(DeliverySlot $slot): RedirectResponse
    {
        $slot->update(['is_active' => ! $slot->is_active]);

        return back()->with('success', 'Statut du creneau mis a jour.');
    }

    public function deleteSlot(DeliverySlot $slot): RedirectResponse
    {
        $slot->delete();

        return back()->with('success', 'Creneau supprime.');
    }
}
