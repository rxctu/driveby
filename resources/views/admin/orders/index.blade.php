@extends('layouts.admin')

@section('title', 'Commandes')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-semibold text-gray-800">Liste des commandes</h3>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-lg shadow mb-6 p-4">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="flex flex-wrap gap-4 items-end">
            <div class="min-w-[180px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500">
                    <option value="">Tous les statuts</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>En attente</option>
                    <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmee</option>
                    <option value="preparing" {{ request('status') === 'preparing' ? 'selected' : '' }}>En preparation</option>
                    <option value="delivering" {{ request('status') === 'delivering' ? 'selected' : '' }}>En livraison</option>
                    <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Livree</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Annulee</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date debut</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}"
                       class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date fin</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}"
                       class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500">
            </div>
            <div>
                <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg text-sm transition">
                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg> Filtrer
                </button>
            </div>
            @if(request()->hasAny(['status', 'date_from', 'date_to']))
                <div>
                    <a href="{{ route('admin.orders.index') }}" class="text-sm text-gray-500 hover:text-gray-700 underline">
                        Reinitialiser
                    </a>
                </div>
            @endif
        </form>
    </div>

    {{-- Orders Table --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">N° Commande</th>
                        <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Client</th>
                        <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Telephone</th>
                        <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Statut</th>
                        <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="text-right px-6 py-3 text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($orders ?? [] as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-800">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:underline">
                                    #{{ $order->order_number }}
                                </a>
                            </td>
                            <td class="px-6 py-4">{{ $order->customer_name }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $order->customer_phone }}</td>
                            <td class="px-6 py-4 font-medium">{{ number_format($order->total, 2, ',', ' ') }} &euro;</td>
                            <td class="px-6 py-4">
                                @include('admin.orders._status-badge', ['status' => $order->status])
                            </td>
                            <td class="px-6 py-4 text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:text-blue-800" title="Voir">
                                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-400">Aucune commande trouvee</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($orders ?? collect(), 'links'))
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $orders->withQueryString()->links() }}
            </div>
        @endif
    </div>
@endsection
