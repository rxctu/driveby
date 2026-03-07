@extends('layouts.admin')

@section('title', 'Commande #' . $order->order_number)

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.orders.index') }}" class="text-sm text-gray-600 hover:text-gray-800">
            <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg> Retour aux commandes
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left Column --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Order Header --}}
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Commande #{{ $order->order_number }}</h3>
                        <p class="text-sm text-gray-500 mt-1">Passee le {{ $order->created_at->format('d/m/Y a H:i') }}</p>
                    </div>
                    @include('admin.orders._status-badge', ['status' => $order->status])
                </div>

                {{-- Status Update --}}
                <form method="POST" action="{{ route('admin.orders.update-status', $order) }}" class="flex items-center gap-3 pt-4 border-t border-gray-200">
                    @csrf
                    @method('PATCH')
                    <label class="text-sm font-medium text-gray-700">Changer le statut :</label>
                    <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Confirmee</option>
                        <option value="preparing" {{ $order->status === 'preparing' ? 'selected' : '' }}>En preparation</option>
                        <option value="delivering" {{ $order->status === 'delivering' ? 'selected' : '' }}>En livraison</option>
                        <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Livree</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Annulee</option>
                    </select>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                        Mettre a jour
                    </button>
                </form>
            </div>

            {{-- Order Items --}}
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h4 class="text-lg font-semibold text-gray-800">Articles commandes</h4>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Produit</th>
                                <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Prix unitaire</th>
                                <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Quantite</th>
                                <th class="text-right px-6 py-3 text-xs font-medium text-gray-500 uppercase">Sous-total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($order->items ?? [] as $item)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            @if($item->product && $item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" class="w-10 h-10 object-cover rounded mr-3">
                                            @endif
                                            <span class="font-medium text-gray-800">{{ $item->product_name ?? $item->product->name ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">{{ number_format($item->unit_price, 2, ',', ' ') }} &euro;</td>
                                    <td class="px-6 py-4">{{ $item->quantity }}</td>
                                    <td class="px-6 py-4 text-right font-medium">{{ number_format($item->unit_price * $item->quantity, 2, ',', ' ') }} &euro;</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-600">Sous-total</td>
                                <td class="px-6 py-3 text-right font-medium">{{ number_format($order->subtotal ?? 0, 2, ',', ' ') }} &euro;</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-600">Frais de livraison</td>
                                <td class="px-6 py-3 text-right font-medium">{{ number_format($order->delivery_fee ?? 0, 2, ',', ' ') }} &euro;</td>
                            </tr>
                            <tr class="border-t-2 border-gray-300">
                                <td colspan="3" class="px-6 py-3 text-right text-sm font-bold text-gray-800">Total</td>
                                <td class="px-6 py-3 text-right font-bold text-lg text-green-700">{{ number_format($order->total, 2, ',', ' ') }} &euro;</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        {{-- Right Column --}}
        <div class="space-y-6">
            {{-- Customer Info --}}
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h4 class="text-lg font-semibold text-gray-800">Informations client</h4>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-medium">Nom</p>
                        <p class="text-sm text-gray-800 mt-1">{{ $order->customer_name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-medium">Telephone</p>
                        <p class="text-sm text-gray-800 mt-1">
                            <a href="tel:{{ $order->customer_phone }}" class="text-blue-600 hover:underline">
                                {{ $order->customer_phone }}
                            </a>
                        </p>
                    </div>
                    @if($order->customer_email)
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-medium">Email</p>
                            <p class="text-sm text-gray-800 mt-1">{{ $order->customer_email }}</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Delivery Info --}}
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h4 class="text-lg font-semibold text-gray-800">Livraison</h4>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-medium">Adresse</p>
                        <p class="text-sm text-gray-800 mt-1">{{ $order->delivery_address }}</p>
                    </div>
                    @if($order->delivery_slot)
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-medium">Creneau</p>
                            <p class="text-sm text-gray-800 mt-1">{{ $order->delivery_slot }}</p>
                        </div>
                    @endif
                    @if($order->delivery_notes)
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-medium">Notes</p>
                            <p class="text-sm text-gray-800 mt-1">{{ $order->delivery_notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Payment Info --}}
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h4 class="text-lg font-semibold text-gray-800">Paiement</h4>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-medium">Methode</p>
                        <p class="text-sm text-gray-800 mt-1">{{ $order->payment_method ?? 'A la livraison' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-medium">Statut du paiement</p>
                        <p class="text-sm mt-1">
                            @if(($order->payment_status ?? 'pending') === 'paid')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Paye</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">En attente</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
