@props(['category'])

@php
    $categoryEmojis = ['🥤', '🥫', '🍝', '🍿', '🧴', '🥬', '🧀', '🥖', '🍫', '🥩', '🍎', '🥚'];
    $categoryColors = [
        'from-blue-100 to-blue-50',
        'from-orange-100 to-orange-50',
        'from-yellow-100 to-yellow-50',
        'from-pink-100 to-pink-50',
        'from-purple-100 to-purple-50',
        'from-green-100 to-green-50',
        'from-amber-100 to-amber-50',
        'from-rose-100 to-rose-50',
        'from-indigo-100 to-indigo-50',
        'from-red-100 to-red-50',
        'from-lime-100 to-lime-50',
        'from-cyan-100 to-cyan-50',
    ];

    $index = isset($loop) ? $loop->index : crc32($category->slug) % count($categoryColors);
    $bgColor = $categoryColors[$index % count($categoryColors)];
    $emoji = $categoryEmojis[$index % count($categoryEmojis)];
@endphp

<a href="{{ route('categorie', $category->slug) }}"
   class="category-card block bg-gradient-to-br {{ $bgColor }} rounded-2xl overflow-hidden p-6 text-center group">

    {{-- Emoji icon --}}
    <div class="emoji-icon text-center mb-3">
        {{ $emoji }}
    </div>

    {{-- Category name --}}
    <h3 class="text-sm font-bold text-gray-800 group-hover:text-emerald-700 transition-colors duration-200 truncate">
        {{ $category->name }}
    </h3>

    {{-- Product count badge --}}
    @if(isset($category->products_count))
        <span class="inline-block mt-2 text-xs bg-white/60 backdrop-blur-sm text-gray-600 px-3 py-0.5 rounded-full font-medium shadow-sm">
            {{ $category->products_count }} {{ $category->products_count > 1 ? 'produits' : 'produit' }}
        </span>
    @endif
</a>
