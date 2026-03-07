@php
    $colors = [
        'pending'    => 'bg-yellow-100 text-yellow-800',
        'confirmed'  => 'bg-blue-100 text-blue-800',
        'preparing'  => 'bg-orange-100 text-orange-800',
        'delivering' => 'bg-purple-100 text-purple-800',
        'delivered'  => 'bg-green-100 text-green-800',
        'cancelled'  => 'bg-red-100 text-red-800',
    ];
    $labels = [
        'pending'    => 'En attente',
        'confirmed'  => 'Confirmee',
        'preparing'  => 'En preparation',
        'delivering' => 'En livraison',
        'delivered'  => 'Livree',
        'cancelled'  => 'Annulee',
    ];
@endphp
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colors[$status] ?? 'bg-gray-100 text-gray-800' }}">
    {{ $labels[$status] ?? ucfirst($status) }}
</span>
