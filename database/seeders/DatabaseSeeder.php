<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\DeliverySlot;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->seedCategories();
        $this->seedProducts();
        $this->seedDeliverySlots();
        $this->seedSettings();
    }

    /**
     * Seed the categories.
     */
    private function seedCategories(): void
    {
        $categories = [
            ['name' => 'Boissons', 'slug' => 'boissons', 'description' => 'Eaux, jus, sodas et boissons chaudes', 'sort_order' => 1],
            ['name' => 'Conserves', 'slug' => 'conserves', 'description' => 'Conserves de legumes, fruits et plats prepares', 'sort_order' => 2],
            ['name' => 'Pates & Riz', 'slug' => 'pates-riz', 'description' => 'Pates, riz, semoule et cereales', 'sort_order' => 3],
            ['name' => 'Snacks', 'slug' => 'snacks', 'description' => 'Chips, biscuits, confiseries et encas', 'sort_order' => 4],
            ['name' => 'Produits du quotidien', 'slug' => 'produits-du-quotidien', 'description' => 'Produits menagers, hygiene et essentiels', 'sort_order' => 5],
        ];

        foreach ($categories as $category) {
            Category::create(array_merge($category, ['is_active' => true]));
        }
    }

    /**
     * Seed sample products for each category.
     */
    private function seedProducts(): void
    {
        $products = [
            // Boissons
            ['name' => 'Eau minerale Evian 1.5L', 'price' => 1.29, 'stock' => 100, 'category' => 'boissons'],
            ['name' => 'Coca-Cola 1.5L', 'price' => 2.15, 'stock' => 80, 'category' => 'boissons'],
            ['name' => 'Jus d\'orange Tropicana 1L', 'price' => 3.49, 'stock' => 60, 'category' => 'boissons'],
            ['name' => 'Cafe moulu Carte Noire 250g', 'price' => 4.99, 'stock' => 50, 'category' => 'boissons'],
            ['name' => 'The vert Lipton 25 sachets', 'price' => 2.89, 'stock' => 40, 'category' => 'boissons'],

            // Conserves
            ['name' => 'Haricots verts extra-fins 800g', 'price' => 1.89, 'stock' => 70, 'category' => 'conserves'],
            ['name' => 'Tomates pelees entières 400g', 'price' => 1.15, 'stock' => 90, 'category' => 'conserves'],
            ['name' => 'Mais doux en grains 300g', 'price' => 1.45, 'stock' => 65, 'category' => 'conserves'],
            ['name' => 'Raviolis pur boeuf 800g', 'price' => 2.99, 'stock' => 55, 'category' => 'conserves'],
            ['name' => 'Thon entier huile olive 160g', 'price' => 3.29, 'stock' => 45, 'category' => 'conserves'],

            // Pates & Riz
            ['name' => 'Penne rigate Barilla 500g', 'price' => 1.69, 'stock' => 120, 'category' => 'pates-riz'],
            ['name' => 'Spaghetti n5 Barilla 500g', 'price' => 1.69, 'stock' => 110, 'category' => 'pates-riz'],
            ['name' => 'Riz basmati Uncle Ben\'s 500g', 'price' => 2.49, 'stock' => 85, 'category' => 'pates-riz'],
            ['name' => 'Semoule fine 500g', 'price' => 1.29, 'stock' => 75, 'category' => 'pates-riz'],
            ['name' => 'Coquillettes 500g', 'price' => 0.99, 'stock' => 130, 'category' => 'pates-riz'],

            // Snacks
            ['name' => 'Chips Nature Lay\'s 150g', 'price' => 2.49, 'stock' => 60, 'category' => 'snacks'],
            ['name' => 'BN Chocolat x12', 'price' => 2.19, 'stock' => 50, 'category' => 'snacks'],
            ['name' => 'Nutella 400g', 'price' => 3.99, 'stock' => 70, 'category' => 'snacks'],
            ['name' => 'Barre Kinder Bueno x3', 'price' => 2.79, 'stock' => 45, 'category' => 'snacks'],
            ['name' => 'Cacahuetes grillees salees 250g', 'price' => 1.99, 'stock' => 55, 'category' => 'snacks'],

            // Produits du quotidien
            ['name' => 'Liquide vaisselle Paic 750ml', 'price' => 2.29, 'stock' => 40, 'category' => 'produits-du-quotidien'],
            ['name' => 'Papier toilette Lotus x6', 'price' => 3.49, 'stock' => 60, 'category' => 'produits-du-quotidien'],
            ['name' => 'Lessive liquide Skip 1.7L', 'price' => 8.99, 'stock' => 35, 'category' => 'produits-du-quotidien'],
            ['name' => 'Sacs poubelle 50L x20', 'price' => 2.99, 'stock' => 50, 'category' => 'produits-du-quotidien'],
            ['name' => 'Eponges grattantes x3', 'price' => 1.49, 'stock' => 80, 'category' => 'produits-du-quotidien'],
        ];

        foreach ($products as $productData) {
            $category = Category::where('slug', $productData['category'])->first();

            Product::create([
                'name' => $productData['name'],
                'slug' => Str::slug($productData['name']),
                'description' => null,
                'price' => $productData['price'],
                'image' => null,
                'stock' => $productData['stock'],
                'is_active' => true,
                'category_id' => $category->id,
            ]);
        }
    }

    /**
     * Seed the delivery slots (Monday to Saturday, morning and afternoon).
     */
    private function seedDeliverySlots(): void
    {
        // Monday (1) to Saturday (6)
        for ($day = 1; $day <= 6; $day++) {
            // Morning slot: 9:00 - 12:00
            DeliverySlot::create([
                'day_of_week' => $day,
                'start_time' => '09:00:00',
                'end_time' => '12:00:00',
                'is_active' => true,
                'max_orders' => 10,
            ]);

            // Afternoon slot: 14:00 - 18:00
            DeliverySlot::create([
                'day_of_week' => $day,
                'start_time' => '14:00:00',
                'end_time' => '18:00:00',
                'is_active' => true,
                'max_orders' => 10,
            ]);
        }
    }

    /**
     * Seed default application settings.
     */
    private function seedSettings(): void
    {
        $settings = [
            'site_name' => 'EpiDrive',
            'site_description' => 'Votre supermarche en ligne - Livraison a domicile',
            'delivery_fee' => '3.99',
            'free_delivery_threshold' => '35.00',
            'min_order_amount' => '10.00',
            'contact_email' => 'contact@epidrive.fr',
            'contact_phone' => '01 23 45 67 89',
            'store_address' => '123 Rue du Commerce, 75015 Paris',
            'stripe_enabled' => 'true',
            'paypal_enabled' => 'false',
            'cash_enabled' => 'true',
            'maintenance_mode' => 'false',
        ];

        foreach ($settings as $key => $value) {
            Setting::create(['key' => $key, 'value' => $value]);
        }
    }
}
