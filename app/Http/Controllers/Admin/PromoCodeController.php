<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PromoCodeController extends Controller
{
    public function index(): View
    {
        $promoCodes = PromoCode::latest()->get();

        return view('admin.promo-codes.index', compact('promoCodes'));
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
