<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Stripe\Webhook;

class PaymentController extends Controller
{
    /**
     * Create a Stripe PaymentIntent for the given order.
     */
    public function stripeIntent(Request $request): JsonResponse
    {
        $request->validate([
            'order_number' => 'required|string|exists:orders,order_number',
        ]);

        $order = Order::where('order_number', $request->input('order_number'))
            ->where('user_id', auth()->id())
            ->where('payment_status', '!=', 'paid')
            ->firstOrFail();

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => (int) round($order->total * 100),
                'currency' => 'eur',
                'metadata' => [
                    'order_number' => $order->order_number,
                    'order_id' => $order->id,
                ],
                'description' => 'Commande EpiDrive '.$order->order_number,
            ]);

            $order->update([
                'stripe_payment_intent_id' => $paymentIntent->id,
            ]);

            return response()->json([
                'clientSecret' => $paymentIntent->client_secret,
            ]);
        } catch (\Exception $e) {
            Log::error('Stripe PaymentIntent creation failed', [
                'order_number' => $order->order_number,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'error' => 'Impossible de creer le paiement. Veuillez reessayer.',
            ], 500);
        }
    }

    /**
     * Handle Stripe webhook events.
     */
    public function stripeWebhook(Request $request): JsonResponse
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (\UnexpectedValueException $e) {
            Log::warning('Stripe webhook: invalid payload');

            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            Log::warning('Stripe webhook: invalid signature');

            return response()->json(['error' => 'Invalid signature'], 400);
        }

        switch ($event->type) {
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object;
                $order = Order::where('stripe_payment_intent_id', $paymentIntent->id)->first();

                if ($order) {
                    $order->update([
                        'payment_status' => 'paid',
                        'status' => 'confirmed',
                        'paid_at' => now(),
                    ]);
                    Log::info('Stripe payment succeeded', ['order_number' => $order->order_number]);
                }
                break;

            case 'payment_intent.payment_failed':
                $paymentIntent = $event->data->object;
                $order = Order::where('stripe_payment_intent_id', $paymentIntent->id)->first();

                if ($order) {
                    $order->update(['payment_status' => 'failed']);
                    Log::warning('Stripe payment failed', ['order_number' => $order->order_number]);
                }
                break;

            default:
                Log::info('Stripe webhook: unhandled event type', ['type' => $event->type]);
        }

        return response()->json(['status' => 'ok']);
    }

    /**
     * Create a PayPal order for the given order.
     */
    public function paypalCreate(Request $request): JsonResponse
    {
        $request->validate([
            'order_number' => 'required|string|exists:orders,order_number',
        ]);

        $order = Order::where('order_number', $request->input('order_number'))
            ->where('user_id', auth()->id())
            ->where('payment_status', '!=', 'paid')
            ->firstOrFail();

        $clientId = config('services.paypal.client_id');
        $secret = config('services.paypal.secret');
        $baseUrl = config('services.paypal.mode') === 'sandbox'
            ? 'https://api-m.sandbox.paypal.com'
            : 'https://api-m.paypal.com';

        try {
            // Get access token
            $authResponse = \Illuminate\Support\Facades\Http::withBasicAuth($clientId, $secret)
                ->asForm()
                ->post($baseUrl.'/v1/oauth2/token', [
                    'grant_type' => 'client_credentials',
                ]);

            $accessToken = $authResponse->json('access_token');

            // Create PayPal order
            $paypalResponse = \Illuminate\Support\Facades\Http::withToken($accessToken)
                ->post($baseUrl.'/v2/checkout/orders', [
                    'intent' => 'CAPTURE',
                    'purchase_units' => [
                        [
                            'reference_id' => $order->order_number,
                            'description' => 'Commande EpiDrive '.$order->order_number,
                            'amount' => [
                                'currency_code' => 'EUR',
                                'value' => number_format($order->total, 2, '.', ''),
                                'breakdown' => [
                                    'item_total' => [
                                        'currency_code' => 'EUR',
                                        'value' => number_format($order->subtotal, 2, '.', ''),
                                    ],
                                    'shipping' => [
                                        'currency_code' => 'EUR',
                                        'value' => number_format($order->delivery_fee, 2, '.', ''),
                                    ],
                                ],
                            ],
                        ],
                    ],
                ]);

            $paypalOrder = $paypalResponse->json();

            $order->update([
                'paypal_order_id' => $paypalOrder['id'],
            ]);

            return response()->json([
                'id' => $paypalOrder['id'],
            ]);
        } catch (\Exception $e) {
            Log::error('PayPal order creation failed', [
                'order_number' => $order->order_number,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'error' => 'Impossible de creer le paiement PayPal. Veuillez reessayer.',
            ], 500);
        }
    }

    /**
     * Capture a PayPal payment after approval.
     */
    public function paypalCapture(Request $request): JsonResponse
    {
        $request->validate([
            'paypal_order_id' => 'required|string',
        ]);

        $paypalOrderId = $request->input('paypal_order_id');

        $order = Order::where('paypal_order_id', $paypalOrderId)
            ->where('payment_status', '!=', 'paid')
            ->firstOrFail();

        $clientId = config('services.paypal.client_id');
        $secret = config('services.paypal.secret');
        $baseUrl = config('services.paypal.mode') === 'sandbox'
            ? 'https://api-m.sandbox.paypal.com'
            : 'https://api-m.paypal.com';

        try {
            // Get access token
            $authResponse = \Illuminate\Support\Facades\Http::withBasicAuth($clientId, $secret)
                ->asForm()
                ->post($baseUrl.'/v1/oauth2/token', [
                    'grant_type' => 'client_credentials',
                ]);

            $accessToken = $authResponse->json('access_token');

            // Capture payment
            $captureResponse = \Illuminate\Support\Facades\Http::withToken($accessToken)
                ->post($baseUrl.'/v2/checkout/orders/'.$paypalOrderId.'/capture');

            $captureData = $captureResponse->json();

            if (($captureData['status'] ?? '') === 'COMPLETED') {
                $order->update([
                    'payment_status' => 'paid',
                    'status' => 'confirmed',
                    'paid_at' => now(),
                ]);

                Log::info('PayPal payment captured', ['order_number' => $order->order_number]);

                return response()->json([
                    'status' => 'success',
                    'redirect' => route('checkout.success', $order->order_number),
                ]);
            }

            return response()->json([
                'status' => 'error',
                'error' => 'Le paiement n\'a pas pu etre capture.',
            ], 400);
        } catch (\Exception $e) {
            Log::error('PayPal capture failed', [
                'order_number' => $order->order_number,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'error' => 'Erreur lors de la capture du paiement.',
            ], 500);
        }
    }
}
