<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generate an XML sitemap with all categories and products.
     */
    public function index(): Response
    {
        $categories = Category::active()->sorted()->get();
        $products = Product::where('is_active', true)
            ->with('category')
            ->get();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // Homepage
        $xml .= '<url>';
        $xml .= '<loc>' . url('/') . '</loc>';
        $xml .= '<changefreq>daily</changefreq>';
        $xml .= '<priority>1.0</priority>';
        $xml .= '</url>';

        // Catalog index
        $xml .= '<url>';
        $xml .= '<loc>' . route('catalog.index') . '</loc>';
        $xml .= '<changefreq>daily</changefreq>';
        $xml .= '<priority>0.9</priority>';
        $xml .= '</url>';

        // Categories
        foreach ($categories as $category) {
            $xml .= '<url>';
            $xml .= '<loc>' . route('catalog.category', $category->slug) . '</loc>';
            $xml .= '<lastmod>' . $category->updated_at->toW3cString() . '</lastmod>';
            $xml .= '<changefreq>weekly</changefreq>';
            $xml .= '<priority>0.8</priority>';
            $xml .= '</url>';
        }

        // Products
        foreach ($products as $product) {
            if ($product->category) {
                $xml .= '<url>';
                $xml .= '<loc>' . route('catalog.product', [$product->category->slug, $product->slug]) . '</loc>';
                $xml .= '<lastmod>' . $product->updated_at->toW3cString() . '</lastmod>';
                $xml .= '<changefreq>weekly</changefreq>';
                $xml .= '<priority>0.7</priority>';
                $xml .= '</url>';
            }
        }

        $xml .= '</urlset>';

        return response($xml, 200, [
            'Content-Type' => 'application/xml',
        ]);
    }
}
