<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class CatalogController extends Controller
{
    /**
     * List all active categories with product count.
     */
    public function index(): View
    {
        $categories = Category::active()
            ->sorted()
            ->withCount(['products' => function ($query) {
                $query->where('is_active', true);
            }])
            ->get();

        $metaTitle = 'Nos Rayons - EpiDrive';
        $metaDescription = 'Parcourez tous nos rayons et trouvez vos produits preferes. Large selection de produits frais, epicerie, boissons et plus encore.';

        return view('catalog.index', compact('categories', 'metaTitle', 'metaDescription'));
    }

    /**
     * Show products in a given category with pagination.
     */
    public function category(string $slug): View
    {
        $category = Category::active()
            ->bySlug($slug)
            ->firstOrFail();

        $products = Product::where('category_id', $category->id)
            ->where('is_active', true)
            ->orderBy('name')
            ->paginate(24);

        $metaTitle = $category->name . ' - EpiDrive';
        $metaDescription = $category->description ?? 'Decouvrez notre selection de ' . $category->name . ' disponible en livraison a domicile.';

        return view('catalog.category', compact('category', 'products', 'metaTitle', 'metaDescription'));
    }

    /**
     * Show a single product detail page.
     */
    public function show(string $categorySlug, string $productSlug): View
    {
        $category = Category::active()
            ->bySlug($categorySlug)
            ->firstOrFail();

        $product = Product::where('category_id', $category->id)
            ->where('slug', $productSlug)
            ->where('is_active', true)
            ->firstOrFail();

        $relatedProducts = Product::where('category_id', $category->id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->inRandomOrder()
            ->take(4)
            ->get();

        $metaTitle = $product->name . ' - ' . $category->name . ' - EpiDrive';
        $metaDescription = $product->description
            ? \Illuminate\Support\Str::limit(strip_tags($product->description), 160)
            : 'Achetez ' . $product->name . ' en ligne sur EpiDrive. Livraison rapide a domicile.';

        return view('catalog.product', compact('category', 'product', 'relatedProducts', 'metaTitle', 'metaDescription'));
    }
}
