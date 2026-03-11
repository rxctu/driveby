@extends('layouts.admin')

@section('title', 'Tableau de bord')
@section('page_title', 'Tableau de bord')

@section('content')
    <div x-data="dashboardLive()" x-init="init()">
    {{-- Stats Cards Row 1 --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Commandes aujourd'hui</span>
                <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900" x-text="ordersToday">{{ $ordersToday }}</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">CA aujourd'hui</span>
                <div class="w-10 h-10 bg-emerald-50 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900" x-text="formatPrice(revenueToday)">{{ number_format($revenueToday, 2, ',', ' ') }} &euro;</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">CA ce mois</span>
                <div class="w-10 h-10 bg-amber-50 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ number_format($revenueMonth, 2, ',', ' ') }} &euro;</p>
            <p class="text-xs text-gray-400 mt-1">dont {{ number_format($revenuePaidMonth, 2, ',', ' ') }} &euro; encaisse</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Produits</span>
                <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ $totalProducts }}</p>
            @if($lowStockProducts > 0 || $outOfStockProducts > 0)
                <p class="text-xs mt-1">
                    @if($outOfStockProducts > 0)<span class="text-red-500 font-medium">{{ $outOfStockProducts }} rupture</span>@endif
                    @if($outOfStockProducts > 0 && $lowStockProducts > 0) &middot; @endif
                    @if($lowStockProducts > 0)<span class="text-amber-500 font-medium">{{ $lowStockProducts }} stock bas</span>@endif
                </p>
            @endif
        </div>
    </div>

    {{-- Pipeline commandes --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 hover:border-amber-300 transition group">
            <div class="flex items-center space-x-3">
                <div class="w-3 h-3 rounded-full bg-amber-400"></div>
                <span class="text-sm font-medium text-gray-600 group-hover:text-amber-600">En attente</span>
            </div>
            <p class="text-2xl font-bold text-gray-900 mt-2" x-text="pendingOrders">{{ $pendingOrders }}</p>
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'confirmed']) }}" class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 hover:border-blue-300 transition group">
            <div class="flex items-center space-x-3">
                <div class="w-3 h-3 rounded-full bg-blue-400"></div>
                <span class="text-sm font-medium text-gray-600 group-hover:text-blue-600">Confirmees</span>
            </div>
            <p class="text-2xl font-bold text-gray-900 mt-2" x-text="confirmedOrders">{{ $confirmedOrders }}</p>
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'preparing']) }}" class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 hover:border-indigo-300 transition group">
            <div class="flex items-center space-x-3">
                <div class="w-3 h-3 rounded-full bg-indigo-400"></div>
                <span class="text-sm font-medium text-gray-600 group-hover:text-indigo-600">En preparation</span>
            </div>
            <p class="text-2xl font-bold text-gray-900 mt-2" x-text="preparingOrders">{{ $preparingOrders }}</p>
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'delivered']) }}" class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 hover:border-emerald-300 transition group">
            <div class="flex items-center space-x-3">
                <div class="w-3 h-3 rounded-full bg-emerald-400"></div>
                <span class="text-sm font-medium text-gray-600 group-hover:text-emerald-600">Livrees</span>
            </div>
            <p class="text-2xl font-bold text-gray-900 mt-2" x-text="deliveredOrders">{{ $deliveredOrders }}</p>
        </a>
    </div>

    {{-- New order notification banner (hidden by default) --}}
    <div x-show="newOrderAlert" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-cloak
         class="mb-6 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-xl p-4 shadow-lg shadow-emerald-200/50 flex items-center justify-between">
        <div class="flex items-center space-x-3 text-white">
            <span class="text-2xl animate-bounce">🔔</span>
            <div>
                <p class="font-bold">Nouvelle commande !</p>
                <p class="text-sm text-emerald-100" x-text="'#' + newOrderNumber + ' - ' + newOrderCustomer + ' - ' + newOrderTotal"></p>
            </div>
        </div>
        <button @click="newOrderAlert = false" class="text-white/70 hover:text-white text-xl ml-4">&times;</button>
    </div>

    </div>{{-- /dashboardLive --}}

    {{-- Stock Alerts --}}
    <div class="mb-6" x-data="stockAlerts()" x-init="init()">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-base font-semibold text-gray-800 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                    Alertes stock
                    <span x-show="totalAlerts > 0" class="ml-2 text-xs bg-red-100 text-red-700 px-2 py-0.5 rounded-full font-bold" x-text="totalAlerts + ' produit(s)'"></span>
                </h3>
                <a href="{{ route('admin.products.index') }}" class="text-xs font-medium text-emerald-600 hover:text-emerald-700">Gerer les stocks &rarr;</a>
            </div>

            {{-- Empty state --}}
            <div x-show="totalAlerts === 0" class="p-6 text-center">
                <svg class="w-10 h-10 mx-auto mb-2 text-emerald-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-sm font-medium text-gray-500">Tous les stocks sont OK</p>
                <p class="text-xs text-gray-400 mt-1">Aucun produit en stock bas ou en rupture</p>
            </div>

            {{-- Alerts list --}}
            <div x-show="totalAlerts > 0" class="divide-y divide-gray-50">
                <template x-for="product in products" :key="product.id">
                    <div class="flex items-center justify-between px-4 py-3 hover:bg-gray-50 transition"
                         :class="product.stock === 0 ? 'bg-red-50/50' : ''">
                        <div class="flex items-center min-w-0">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 flex-shrink-0"
                                 :class="product.stock === 0 ? 'bg-red-100' : 'bg-amber-100'">
                                <span class="text-xs font-bold" :class="product.stock === 0 ? 'text-red-700' : 'text-amber-700'" x-text="product.stock"></span>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-gray-800 truncate" x-text="product.name"></p>
                                <p class="text-xs text-gray-400" x-text="parseFloat(product.price).toFixed(2).replace('.', ',') + ' \u20AC'"></p>
                            </div>
                        </div>
                        <span class="text-xs font-bold px-2 py-1 rounded-full flex-shrink-0 ml-2"
                              :class="product.stock === 0 ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700'"
                              x-text="product.stock === 0 ? 'Rupture' : 'Stock bas'"></span>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <script>
    function stockAlerts() {
        return {
            products: @json($stockAlerts),
            totalAlerts: {{ $stockAlerts->count() }},

            init() {
                // Fallback polling every 30s when Echo is not available
                if (!window.Echo) {
                    setInterval(() => {
                        fetch('{{ route("admin.stock-alerts") }}')
                            .then(r => r.json())
                            .then(data => {
                                this.products = data.products;
                                this.totalAlerts = data.products.length;
                            })
                            .catch(() => {});
                    }, 30000);
                    return;
                }

                window.Echo.channel('admin-stock')
                    .listen('StockUpdated', (e) => {
                        const idx = this.products.findIndex(p => p.id === e.product_id);

                        if (e.stock <= 5) {
                            if (idx >= 0) {
                                this.products[idx].stock = e.stock;
                            } else {
                                this.products.push({
                                    id: e.product_id,
                                    name: e.product_name,
                                    stock: e.stock,
                                    price: 0
                                });
                            }
                        } else if (idx >= 0) {
                            this.products.splice(idx, 1);
                        }

                        this.products.sort((a, b) => a.stock - b.stock);
                        this.totalAlerts = this.products.length;
                    });
            }
        };
    }
    </script>

    <script>
    function dashboardLive() {
        return {
            ordersToday: {{ $ordersToday }},
            revenueToday: {{ $revenueToday }},
            pendingOrders: {{ $pendingOrders }},
            confirmedOrders: {{ $confirmedOrders }},
            preparingOrders: {{ $preparingOrders }},
            deliveredOrders: {{ $deliveredOrders ?? 0 }},
            newOrderAlert: false,
            newOrderNumber: '',
            newOrderCustomer: '',
            newOrderTotal: '',

            formatPrice(val) {
                return parseFloat(val).toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, ' ') + ' \u20AC';
            },

            init() {
                if (!window.Echo) return;

                window.Echo.channel('admin-orders')
                    .listen('OrderCreated', (e) => {
                        this.ordersToday++;
                        this.revenueToday += parseFloat(e.total || 0);
                        this.pendingOrders++;

                        this.newOrderNumber = e.order_number;
                        this.newOrderCustomer = e.customer_name;
                        this.newOrderTotal = this.formatPrice(e.total);
                        this.newOrderAlert = true;

                        // Play notification sound
                        try { new Audio('/sounds/notification.mp3').play(); } catch(err) {}

                        // Auto-hide after 15s
                        setTimeout(() => { this.newOrderAlert = false; }, 15000);
                    })
                    .listen('OrderStatusUpdated', (e) => {
                        const statusMap = { pending: 'pendingOrders', confirmed: 'confirmedOrders', preparing: 'preparingOrders', delivered: 'deliveredOrders' };

                        // Decrement old status
                        const oldKey = statusMap[e.old_status];
                        if (oldKey && this[oldKey] > 0) this[oldKey]--;

                        // Increment new status
                        const newKey = statusMap[e.status];
                        if (newKey) this[newKey]++;
                    });
            }
        };
    }
    </script>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Recent Orders --}}
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-base font-semibold text-gray-800">Commandes recentes</h3>
                <a href="{{ route('admin.orders.index') }}" class="text-xs font-medium text-emerald-600 hover:text-emerald-700">Voir tout &rarr;</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th class="text-left px-5 py-3 text-xs font-medium text-gray-400 uppercase">Commande</th>
                            <th class="text-left px-5 py-3 text-xs font-medium text-gray-400 uppercase">Client</th>
                            <th class="text-right px-5 py-3 text-xs font-medium text-gray-400 uppercase">Total</th>
                            <th class="text-left px-5 py-3 text-xs font-medium text-gray-400 uppercase">Statut</th>
                            <th class="text-left px-5 py-3 text-xs font-medium text-gray-400 uppercase">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($recentOrders as $order)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-5 py-3.5">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="text-emerald-600 hover:text-emerald-700 font-medium">
                                        #{{ $order->order_number }}
                                    </a>
                                </td>
                                <td class="px-5 py-3.5 text-gray-600">{{ $order->customer_name }}</td>
                                <td class="px-5 py-3.5 text-right font-semibold text-gray-800">{{ number_format($order->total, 2, ',', ' ') }} &euro;</td>
                                <td class="px-5 py-3.5">
                                    @include('admin.orders._status-badge', ['status' => $order->status])
                                </td>
                                <td class="px-5 py-3.5 text-gray-400 text-xs">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-8 text-center text-gray-400">Aucune commande recente</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Quick Links --}}
        <div class="space-y-4">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="text-base font-semibold text-gray-800 mb-4">Acces rapide</h3>
                <div class="space-y-2">
                    <a href="{{ route('admin.products.create') }}" class="flex items-center p-3 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 transition text-sm font-medium">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        Ajouter un produit
                    </a>
                    <a href="{{ route('admin.categories.create') }}" class="flex items-center p-3 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 transition text-sm font-medium">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        Ajouter une categorie
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="flex items-center p-3 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-700 transition text-sm font-medium">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        Voir les commandes
                    </a>
                    <a href="{{ route('admin.settings.index') }}" class="flex items-center p-3 rounded-lg bg-gray-50 hover:bg-gray-100 text-gray-700 transition text-sm font-medium">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Parametres
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="text-base font-semibold text-gray-800 mb-3">Clients</h3>
                <div class="flex items-baseline space-x-2">
                    <span class="text-2xl font-bold text-gray-900">{{ $totalCustomers }}</span>
                    <span class="text-sm text-gray-400">inscrits</span>
                </div>
                @if($newCustomersToday > 0)
                    <p class="text-xs text-emerald-600 font-medium mt-1">+{{ $newCustomersToday }} aujourd'hui</p>
                @endif
            </div>
        </div>
    </div>
@endsection
