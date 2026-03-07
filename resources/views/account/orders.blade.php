@extends('layouts.app')

@section('title', 'Mes commandes - EpiDrive')
@section('meta_description', 'Consultez l\'historique de toutes vos commandes EpiDrive.')

@section('content')

    {{-- Header with gradient --}}
    <div class="bg-gradient-to-r from-emerald-700 via-emerald-600 to-teal-500 relative overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute -top-16 -right-16 w-64 h-64 bg-white/5 rounded-full"></div>
            <div class="absolute -bottom-20 -left-20 w-80 h-80 bg-white/5 rounded-full"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14 relative z-10">
            <nav class="text-sm text-emerald-200 mb-4">
                <ol class="flex items-center space-x-2">
                    <li><a href="{{ route('home') }}" class="hover:text-white transition">Accueil</a></li>
                    <li><span class="text-emerald-300/50">/</span></li>
                    <li><a href="{{ route('account.index') }}" class="hover:text-white transition">Mon compte</a></li>
                    <li><span class="text-emerald-300/50">/</span></li>
                    <li class="text-white font-medium">Mes commandes</li>
                </ol>
            </nav>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white">Mes commandes</h1>
            <p class="text-emerald-100 mt-1">Retrouvez l'historique de toutes vos commandes</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 relative z-20 pb-12">

        @if(isset($orders) && $orders->count() > 0)

            @php
                $statusColors = [
                    'pending' => 'bg-amber-100 text-amber-700 ring-amber-200',
                    'confirmed' => 'bg-blue-100 text-blue-700 ring-blue-200',
                    'processing' => 'bg-orange-100 text-orange-700 ring-orange-200',
                    'shipped' => 'bg-purple-100 text-purple-700 ring-purple-200',
                    'delivered' => 'bg-emerald-100 text-emerald-700 ring-emerald-200',
                    'cancelled' => 'bg-red-100 text-red-700 ring-red-200',
                ];
                $statusLabels = [
                    'pending' => 'En attente',
                    'confirmed' => 'Confirmee',
                    'processing' => 'En preparation',
                    'shipped' => 'En livraison',
                    'delivered' => 'Livree',
                    'cancelled' => 'Annulee',
                ];
            @endphp

            {{-- Desktop Table --}}
            <div class="hidden sm:block bg-white rounded-2xl shadow-lg shadow-gray-200/50 border border-gray-100 overflow-hidden">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-gray-50 to-gray-50/50 border-b border-gray-200">
                            <th class="text-left text-xs font-bold text-gray-500 uppercase tracking-wider px-6 py-4">Commande</th>
                            <th class="text-left text-xs font-bold text-gray-500 uppercase tracking-wider px-6 py-4">Date</th>
                            <th class="text-left text-xs font-bold text-gray-500 uppercase tracking-wider px-6 py-4">Statut</th>
                            <th class="text-right text-xs font-bold text-gray-500 uppercase tracking-wider px-6 py-4">Total</th>
                            <th class="px-6 py-4"><span class="sr-only">Voir</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($orders as $order)
                            <tr class="hover:bg-gradient-to-r hover:from-emerald-50/50 hover:to-transparent transition-all duration-200 group cursor-pointer"
                                onclick="window.location='{{ route('account.order.detail', $order->order_number) }}'">
                                <td class="px-6 py-5">
                                    <span class="font-bold text-gray-800 group-hover:text-emerald-700 transition">#{{ $order->order_number }}</span>
                                </td>
                                <td class="px-6 py-5 text-sm text-gray-500">
                                    {{ $order->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-5">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold ring-1 {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-700 ring-gray-200' }}">
                                        {{ $statusLabels[$order->status] ?? $order->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-right font-extrabold text-gray-900">
                                    {{ number_format($order->total, 2, ',', ' ') }} &euro;
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <a href="{{ route('account.order.detail', $order->order_number) }}"
                                       class="inline-flex items-center space-x-1 text-emerald-600 hover:text-emerald-700 text-sm font-bold transition">
                                        <span>Voir</span>
                                        <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Mobile Cards --}}
            <div class="sm:hidden space-y-4">
                @foreach($orders as $index => $order)
                    <a href="{{ route('account.order.detail', $order->order_number) }}"
                       class="block bg-white rounded-2xl shadow-lg shadow-gray-200/50 border border-gray-100 p-5 hover:shadow-xl hover:border-emerald-200 transition-all duration-300 active:scale-[0.98]"
                       x-data x-init="setTimeout(() => $el.classList.remove('opacity-0', 'translate-y-2'), {{ $index * 100 }})"
                       style="animation: slide-up 0.4s ease-out {{ $index * 0.1 }}s both;">
                        <div class="flex items-center justify-between mb-3">
                            <span class="font-bold text-gray-800 text-base">#{{ $order->order_number }}</span>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold ring-1 {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-700 ring-gray-200' }}">
                                {{ $statusLabels[$order->status] ?? $order->status }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-400">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                            <span class="font-extrabold text-gray-900 text-lg">{{ number_format($order->total, 2, ',', ' ') }} &euro;</span>
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($orders->hasPages())
                <div class="mt-8">
                    {{ $orders->links() }}
                </div>
            @endif

        @else
            <div class="bg-white rounded-2xl shadow-lg shadow-gray-200/50 border border-gray-100 p-12 sm:p-16 text-center">
                <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-50 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-extrabold text-gray-800 mb-2">Aucune commande</h2>
                <p class="text-gray-500 mb-8 max-w-sm mx-auto">Vous n'avez pas encore passe de commande. Decouvrez nos produits frais et de qualite !</p>
                <a href="{{ route('catalog.index') }}"
                   class="inline-flex items-center space-x-2 bg-gradient-to-r from-emerald-700 to-emerald-600 text-white font-bold px-8 py-3.5 rounded-xl hover:from-emerald-800 hover:to-emerald-700 transition-all shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 active:scale-[0.98]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.15c0 .415.336.75.75.75z"/>
                    </svg>
                    <span>Decouvrir nos produits</span>
                </a>
            </div>
        @endif
    </div>

    <style>
        @keyframes slide-up {
            from { opacity: 0; transform: translateY(0.5rem); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

@endsection
