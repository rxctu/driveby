@extends('layouts.admin')

@section('title', 'Commandes')

@section('content')
    {{-- New orders notification bar (WebSocket via Echo) --}}
    <div x-data="ordersLive()" x-cloak>
        <div x-show="showNotif"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="mb-4 px-4 py-3 bg-green-50 border border-green-300 rounded-lg flex items-center justify-between animate-pulse-once">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <span class="text-sm font-semibold text-green-800" x-text="newOrders.length + ' nouvelle(s) commande(s)'"></span>
            </div>
            <button @click="refreshPage()"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-600 text-white text-xs font-semibold rounded-lg hover:bg-green-700 transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Actualiser
            </button>
        </div>
    </div>

    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-semibold text-gray-800">Liste des commandes</h3>
        {{-- QR Code Scan Button --}}
        <div x-data="{ open: false, code: '', scanning: false, result: null }">
            <button @click="open = !open" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm font-semibold hover:bg-emerald-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                Scanner retrait
            </button>
            <div x-show="open" x-cloak x-transition class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl border border-gray-200 p-4 z-50 space-y-3">
                <h4 class="text-sm font-bold text-gray-800">Valider un retrait</h4>
                <form @submit.prevent="
                    if (!code) return;
                    scanning = true;
                    result = null;
                    fetch('{{ route('admin.orders.validate-pickup') }}', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
                        body: JSON.stringify({ validation_code: code })
                    }).then(r => r.json()).then(data => {
                        scanning = false;
                        result = data;
                        if (data.success) { code = ''; setTimeout(() => { result = null; }, 4000); }
                    }).catch(() => { scanning = false; result = { success: false, message: 'Erreur reseau.' }; });
                ">
                    <div class="flex gap-2">
                        <input type="text" x-model="code" maxlength="8" placeholder="Code 8 caracteres"
                               class="flex-1 px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 font-mono uppercase tracking-wider text-center" autofocus>
                        <button type="submit" :disabled="scanning || !code"
                                class="px-4 py-2 bg-emerald-600 text-white rounded-lg font-bold text-sm hover:bg-emerald-700 transition disabled:opacity-50">OK</button>
                    </div>
                </form>
                <div x-show="result" x-cloak>
                    <div x-show="result && result.success" class="p-2.5 bg-emerald-50 border border-emerald-200 rounded-lg text-sm text-center">
                        <p class="font-bold text-emerald-700" x-text="result?.message"></p>
                        <p class="text-xs text-emerald-600 mt-1" x-text="result?.customer_name + ' - ' + result?.total"></p>
                    </div>
                    <div x-show="result && !result.success" class="p-2.5 bg-red-50 border border-red-200 rounded-lg text-sm font-semibold text-red-700 text-center" x-text="result?.message"></div>
                </div>
            </div>
        </div>
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
                            <td class="px-6 py-4">
                                {{ $order->customer_name }}
                                @if($order->user)
                                    <span class="ml-1 inline-flex items-center px-1.5 py-0.5 rounded-full text-[10px] font-bold {{ $order->user->trustColor() }}">
                                        {{ $order->user->trustBadge() }}
                                    </span>
                                    @if($order->user->is_verified)
                                        <svg class="w-3.5 h-3.5 inline text-emerald-500 ml-0.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    @endif
                                @endif
                            </td>
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
    <style>
        [x-cloak] { display: none !important; }
        @keyframes pulse-once {
            0%, 100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
            50% { box-shadow: 0 0 0 6px rgba(34, 197, 94, 0.3); }
        }
        .animate-pulse-once { animation: pulse-once 1.5s ease-in-out 3; }
    </style>

    <script>
        function ordersLive() {
            return {
                newOrders: [],
                showNotif: false,

                init() {
                    if (!window.Echo) return;

                    window.Echo.channel('admin-orders')
                        .listen('OrderCreated', (e) => {
                            this.newOrders.push(e);
                            this.showNotif = true;
                            // Vibrate on mobile
                            if (navigator.vibrate) navigator.vibrate([200, 100, 200]);
                            // Sound notification
                            try {
                                const ctx = new (window.AudioContext || window.webkitAudioContext)();
                                const osc = ctx.createOscillator();
                                const gain = ctx.createGain();
                                osc.connect(gain);
                                gain.connect(ctx.destination);
                                osc.frequency.value = 880;
                                gain.gain.value = 0.1;
                                osc.start();
                                osc.stop(ctx.currentTime + 0.15);
                            } catch(e) {}
                        })
                        .listen('OrderStatusUpdated', (e) => {
                            // Update status badge if order is visible on current page
                            const row = document.querySelector(`[data-order-id="${e.id}"]`);
                            if (row) {
                                // Reload to show updated status
                                window.location.reload();
                            }
                        });
                },

                refreshPage() {
                    window.location.reload();
                }
            };
        }
    </script>
@endsection
