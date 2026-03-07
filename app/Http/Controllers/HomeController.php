<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->withCount('products')
            ->get();

        $featuredProducts = Product::where('is_active', true)
            ->where('stock', '>', 0)
            ->with('category')
            ->latest()
            ->take(12)
            ->get();

        $metaTitle = 'EpiDrive - Votre epicerie de quartier, livree chez vous';
        $metaDescription = 'Commandez vos courses en ligne et recevez-les chez vous. Produits du quotidien, boissons, snacks. Livraison rapide dans votre quartier.';

        return view('home', compact(
            'categories',
            'featuredProducts',
            'metaTitle',
            'metaDescription'
        ));
    }
}
