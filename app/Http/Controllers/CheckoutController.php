<?php

namespace App\Http\Controllers;

use App\Events\OrderCreated;
use App\Http\Requests\CheckoutRequest;
use App\Models\DeliverySlot;
use App\Models\Order;
use App\Models\Product;
use App\Models\PromoCode;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    /**
     * Show the checkout form with cart summary, delivery form, and slot selection.
     */
    public function index(): View|RedirectResponse
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        $products = Product::whereIn('id', array_keys($cart))
            ->where('is_active', true)
            ->get()
            ->keyBy('id');

        $cartItems = [];
        $subtotal = 0;

        foreach ($cart as $productId => $quantity) {
            if ($products->has($productId)) {
                $product = $products->get($productId);
                $lineTotal = $product->price * $quantity;
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'subtotal' => $lineTotal,
                ];
                $subtotal += $lineTotal;
            }
        }

        $deliverySlots = DeliverySlot::where('is_active', true)
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get();

        $freeDeliveryThreshold = (float) Setting::getValue('free_delivery_threshold', 50);
        $baseDeliveryPrice = (float) Setting::getValue('base_delivery_price', 4.99);
        $deliveryFee = $subtotal >= $freeDeliveryThreshold ? 0 : $baseDeliveryPrice;
        $total = $subtotal + $deliveryFee;

        $storeLat = Setting::getValue('store_lat', '45.5495');
        $storeLng = Setting::getValue('store_lng', '3.7428');
        $onlinePaymentsEnabled = Setting::getValue('online_payments_enabled', '1') === '1';

        $user = Auth::user();

        return view('checkout.index', compact(
            'cartItems',
            'subtotal',
            'deliveryFee',
            'total',
            'deliverySlots',
            'freeDeliveryThreshold',
            'storeLat',
            'storeLng',
            'onlinePaymentsEnabled',
            'user'
        ));
    }

    /**
     * Process the checkout: validate, create order, handle payment.
     */
    public function store(CheckoutRequest $request): RedirectResponse
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        $validated = $request->validated();

        $products = Product::whereIn('id', array_keys($cart))
            ->where('is_active', true)
            ->get()
            ->keyBy('id');

        // Verify stock and calculate totals
        $subtotal = 0;
        $orderItems = [];

        foreach ($cart as $productId => $quantity) {
            if (! $products->has($productId)) {
                return back()->with('error', 'Un produit de votre panier n\'est plus disponible.');
            }

            $product = $products->get($productId);

            if ($product->stock !== null && $quantity > $product->stock) {
                return back()->with('error', 'Stock insuffisant pour '.$product->name.'.');
            }

            $lineTotal = $product->price * $quantity;
            $subtotal += $lineTotal;

            $orderItems[] = [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'quantity' => $quantity,
                'unit_price' => $product->price,
                'total_price' => $lineTotal,
            ];
        }

        // Validate postal code is in department 63
        if (! str_starts_with($validated['delivery_postal_code'], '63')) {
            return back()->withInput()->with('error', 'Nous livrons uniquement dans le departement 63 (Puy-de-Dome).');
        }

        // Calculate delivery fee based on distance
        $customerAddress = $validated['delivery_address'].', '.$validated['delivery_postal_code'].' '.$validated['delivery_city'].', France';
        $coords = $this->geocodeAddress($customerAddress);

        $storeLat = (float) Setting::getValue('store_lat', '45.5495');
        $storeLng = (float) Setting::getValue('store_lng', '3.7428');
        $deliveryDistance = null;

        $basePrice = (float) Setting::getValue('base_delivery_price', 4.99);
        $pricePerKm = (float) Setting::getValue('price_per_km', 0.50);
        $maxDistanceKm = (float) Setting::getValue('max_distance_km', 20);
        $freeDeliveryThreshold = (float) Setting::getValue('free_delivery_threshold', 50);

        if ($coords) {
            $deliveryDistance = round($this->haversineDistance($storeLat, $storeLng, $coords['lat'], $coords['lng']), 2);

            if ($deliveryDistance > $maxDistanceKm) {
                return back()->with('error', 'Adresse hors zone de livraison ('.round($deliveryDistance, 1).' km, max '.$maxDistanceKm.' km).');
            }

            $deliveryFee = round($basePrice + ($deliveryDistance * $pricePerKm), 2);
        } else {
            $deliveryFee = $basePrice;
        }

        if ($subtotal >= $freeDeliveryThreshold) {
            $deliveryFee = 0;
        }

        // Apply promo code discount
        $promoDiscount = 0;
        $promoCodeApplied = $request->input('promo_code_applied');
        if ($promoCodeApplied) {
            $promo = PromoCode::where('code', strtoupper(trim($promoCodeApplied)))->first();
            if ($promo) {
                $validation = $promo->isValid($subtotal);
                if ($validation['valid']) {
                    $promoDiscount = $promo->calculateDiscount($subtotal);
                    $promo->increment('used_count');
                }
            }
        }

        $total = max(0, $subtotal - $promoDiscount) + $deliveryFee;

        // Create order within a transaction
        $order = DB::transaction(function () use ($validated, $subtotal, $deliveryFee, $deliveryDistance, $promoDiscount, $promoCodeApplied, $total, $orderItems) {
            // Map form fields to actual database columns
            $deliverySlot = null;
            if (! empty($validated['delivery_slot_id'])) {
                $slot = DeliverySlot::find($validated['delivery_slot_id']);
                if ($slot) {
                    $dayNames = [1 => 'Lundi', 2 => 'Mardi', 3 => 'Mercredi', 4 => 'Jeudi', 5 => 'Vendredi', 6 => 'Samedi', 7 => 'Dimanche'];
                    $dayLabel = $dayNames[$slot->day_of_week] ?? $slot->day_of_week;
                    $start = substr($slot->start_time, 0, 5);
                    $end = substr($slot->end_time, 0, 5);
                    $deliverySlot = $dayLabel.' '.$start.'-'.$end;
                }
            }

            $order = Order::create([
                'order_number' => 'EPI-'.strtoupper(Str::random(8)),
                'user_id' => Auth::id(),
                'status' => 'pending',
                'validation_code' => Order::generateValidationCode(),
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'pending',
                'subtotal' => $subtotal,
                'delivery_fee' => $deliveryFee,
                'delivery_distance' => $deliveryDistance,
                'promo_code' => $promoCodeApplied ?: null,
                'promo_discount' => $promoDiscount,
                'total' => $total,
                'customer_name' => $validated['delivery_name'],
                'customer_phone' => $validated['delivery_phone'],
                'customer_address' => $validated['delivery_address'].', '.$validated['delivery_postal_code'].' '.$validated['delivery_city'],
                'delivery_instructions' => $validated['notes'] ?? null,
                'delivery_slot' => $deliverySlot,
            ]);

            foreach ($orderItems as $item) {
                $order->items()->create($item);

                // Decrement stock with pessimistic locking to prevent race conditions
                $product = Product::lockForUpdate()->find($item['product_id']);
                if ($product && $product->stock !== null) {
                    if ($product->stock < $item['quantity']) {
                        throw new \RuntimeException('Stock insuffisant pour '.$product->name);
                    }
                    $product->decrement('stock', $item['quantity']);
                    $product->refresh();

                    // Broadcast stock alert if low
                    if ($product->stock <= 5) {
                        event(new \App\Events\StockUpdated($product->id, $product->name, $product->stock));
                    }
                }
            }

            // Track delivery slot usage (no capacity column in current schema)
            // Future: decrement capacity if column exists

            return $order;
        });

        // Broadcast new order event for real-time admin notifications
        event(new OrderCreated($order));

        // Clear the cart
        session()->forget(['cart', 'cart_count']);

        return redirect()->route('checkout.success', $order->order_number)
            ->with('success', 'Votre commande a ete enregistree avec succes !');
    }

    /**
     * AJAX endpoint to validate and calculate promo code discount.
     */
    public function applyPromo(Request $request): JsonResponse
    {
        $request->validate([
            'code' => 'required|string|max:50',
            'subtotal' => 'required|numeric|min:0',
        ]);

        $promo = PromoCode::where('code', strtoupper(trim($request->code)))->first();

        if (!$promo) {
            return response()->json([
                'valid' => false,
                'message' => 'Code promo introuvable.',
            ]);
        }

        $validation = $promo->isValid($request->subtotal);

        if (!$validation['valid']) {
            return response()->json($validation);
        }

        $discount = $promo->calculateDiscount($request->subtotal);

        return response()->json([
            'valid' => true,
            'discount' => round($discount, 2),
            'label' => $promo->getLabel(),
            'message' => 'Code promo applique !',
        ]);
    }

    /**
     * AJAX endpoint to calculate delivery price from address using distance.
     */
    public function calculateDelivery(Request $request): JsonResponse
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|size:5',
        ]);

        $fullAddress = $request->input('address').', '.$request->input('postal_code').' '.$request->input('city').', France';

        // Geocode customer address via Nominatim
        $coords = $this->geocodeAddress($fullAddress);

        if (! $coords) {
            return response()->json([
                'available' => false,
                'message' => 'Impossible de localiser cette adresse. Verifiez l\'adresse saisie.',
            ]);
        }

        // Store coordinates
        $storeLat = (float) Setting::getValue('store_lat', '45.5495');
        $storeLng = (float) Setting::getValue('store_lng', '3.7428');

        // Calculate distance
        $distanceKm = $this->haversineDistance($storeLat, $storeLng, $coords['lat'], $coords['lng']);

        // Check max distance
        $maxDistanceKm = (float) Setting::getValue('max_distance_km', 20);
        if ($distanceKm > $maxDistanceKm) {
            return response()->json([
                'available' => false,
                'distance_km' => round($distanceKm, 1),
                'max_distance_km' => $maxDistanceKm,
                'message' => 'Adresse hors zone de livraison ('.round($distanceKm, 1).' km, max '.$maxDistanceKm.' km).',
            ]);
        }

        // Calculate delivery fee based on distance
        $basePrice = (float) Setting::getValue('base_delivery_price', 4.99);
        $pricePerKm = (float) Setting::getValue('price_per_km', 0.50);
        $deliveryFee = round($basePrice + ($distanceKm * $pricePerKm), 2);

        // Check free delivery threshold
        $cart = session('cart', []);
        $subtotal = 0;
        if (! empty($cart)) {
            $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');
            foreach ($cart as $productId => $quantity) {
                if ($products->has($productId)) {
                    $subtotal += $products->get($productId)->price * $quantity;
                }
            }
        }

        $freeDeliveryThreshold = (float) Setting::getValue('free_delivery_threshold', 50);
        if ($subtotal >= $freeDeliveryThreshold) {
            $deliveryFee = 0;
        }

        return response()->json([
            'available' => true,
            'delivery_fee' => $deliveryFee,
            'distance_km' => round($distanceKm, 1),
            'customer_lat' => $coords['lat'],
            'customer_lng' => $coords['lng'],
            'free_delivery_threshold' => $freeDeliveryThreshold,
            'subtotal' => $subtotal,
            'total' => max(0, $subtotal) + $deliveryFee,
            'message' => $deliveryFee == 0
                ? 'Livraison gratuite !'
                : number_format($deliveryFee, 2, ',', ' ').' EUR ('.round($distanceKm, 1).' km)',
        ]);
    }

    /**
     * AJAX endpoint: reverse geocode GPS coordinates into an address.
     */
    public function reverseGeocode(Request $request): JsonResponse
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        $url = 'https://nominatim.openstreetmap.org/reverse?'.http_build_query([
            'lat' => $request->input('lat'),
            'lon' => $request->input('lng'),
            'format' => 'json',
            'addressdetails' => 1,
        ]);

        $context = stream_context_create([
            'http' => [
                'header' => "User-Agent: EpiDrive/1.0\r\n",
                'timeout' => 5,
            ],
        ]);

        $response = @file_get_contents($url, false, $context);

        if ($response === false) {
            return response()->json(['error' => 'Impossible de determiner l\'adresse.'], 500);
        }

        $data = json_decode($response, true);

        if (empty($data) || isset($data['error'])) {
            return response()->json(['error' => 'Aucune adresse trouvee pour cette position.'], 404);
        }

        $addr = $data['address'] ?? [];

        $road = $addr['road'] ?? $addr['pedestrian'] ?? $addr['footway'] ?? '';
        $houseNumber = $addr['house_number'] ?? '';
        $streetAddress = trim($houseNumber.' '.$road);

        $city = $addr['city'] ?? $addr['town'] ?? $addr['village'] ?? $addr['municipality'] ?? '';
        $postalCode = $addr['postcode'] ?? '';

        return response()->json([
            'address' => $streetAddress,
            'city' => $city,
            'postal_code' => $postalCode,
            'display_name' => $data['display_name'] ?? '',
        ]);
    }

    /**
     * Geocode an address using Nominatim (OpenStreetMap).
     */
    private function geocodeAddress(string $address): ?array
    {
        $url = 'https://nominatim.openstreetmap.org/search?'.http_build_query([
            'q' => $address,
            'format' => 'json',
            'limit' => 1,
            'countrycodes' => 'fr',
        ]);

        $context = stream_context_create([
            'http' => [
                'header' => "User-Agent: EpiDrive/1.0\r\n",
                'timeout' => 5,
            ],
        ]);

        $response = @file_get_contents($url, false, $context);

        if ($response === false) {
            return null;
        }

        $data = json_decode($response, true);

        if (empty($data) || ! isset($data[0]['lat'], $data[0]['lon'])) {
            return null;
        }

        return [
            'lat' => (float) $data[0]['lat'],
            'lng' => (float) $data[0]['lon'],
        ];
    }

    /**
     * Calculate distance between two coordinates using Haversine formula.
     */
    private function haversineDistance(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $earthRadius = 6371; // km

        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) * sin($dLat / 2)
            + cos(deg2rad($lat1)) * cos(deg2rad($lat2))
            * sin($dLng / 2) * sin($dLng / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    /**
     * AJAX endpoint: poll for live order status updates.
     */
    public function pollOrderStatus(string $orderNumber): JsonResponse
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        // Ensure the user can only poll their own order
        if (Auth::check() && $order->user_id !== Auth::id()) {
            abort(403);
        }

        return response()->json([
            'status' => $order->status,
            'payment_status' => $order->payment_status,
            'updated_at' => $order->updated_at->toISOString(),
        ]);
    }

    /**
     * Show the order confirmation page.
     */
    public function success(string $orderNumber): View
    {
        $order = Order::where('order_number', $orderNumber)
            ->with('items')
            ->firstOrFail();

        // Ensure the user can only see their own order (or guest order from session)
        if (Auth::check() && $order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('checkout.success', compact('order'));
    }
}
