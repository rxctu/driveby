<?php

namespace Database\Seeders;

use App\Models\Partner;
use App\Models\Product;
use App\Models\SharedList;
use App\Models\SharedListComment;
use App\Models\SharedListItem;
use App\Models\SharedListVote;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CommunitySeeder extends Seeder
{
    public function run(): void
    {
        $this->seedUsers();
        $this->seedCommunityLists();
        $this->seedPartners();
    }

    private function seedUsers(): void
    {
        $users = [
            ['name' => 'Marie Dupont', 'email' => 'marie@example.com'],
            ['name' => 'Lucas Martin', 'email' => 'lucas@example.com'],
            ['name' => 'Sophie Bernard', 'email' => 'sophie@example.com'],
            ['name' => 'Thomas Petit', 'email' => 'thomas@example.com'],
            ['name' => 'Camille Leroy', 'email' => 'camille@example.com'],
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                array_merge($userData, ['password' => 'password123'])
            );
        }
    }

    private function seedCommunityLists(): void
    {
        $products = Product::all();
        if ($products->isEmpty()) {
            return;
        }

        $users = User::whereIn('email', [
            'marie@example.com',
            'lucas@example.com',
            'sophie@example.com',
            'thomas@example.com',
            'camille@example.com',
        ])->get();

        if ($users->isEmpty()) {
            return;
        }

        $lists = [
            [
                'user_email' => 'marie@example.com',
                'title' => 'Soiree film a la maison',
                'description' => 'Tout ce qu\'il faut pour une bonne soiree cinema : snacks, boissons et petits plaisirs !',
                'tags' => 'Budget,Rapide',
                'likes_count' => 12,
                'dislikes_count' => 1,
                'copies_count' => 8,
                'views_count' => 45,
                'created_at' => now()->subDays(5),
            ],
            [
                'user_email' => 'lucas@example.com',
                'title' => 'Repas etudiant de la semaine',
                'description' => 'Menu complet pour la semaine a moins de 20 euros. Pates, riz, conserves et les basics.',
                'tags' => 'Etudiant,Budget',
                'likes_count' => 24,
                'dislikes_count' => 2,
                'copies_count' => 15,
                'views_count' => 120,
                'created_at' => now()->subDays(3),
            ],
            [
                'user_email' => 'sophie@example.com',
                'title' => 'Gouter d\'anniversaire enfants',
                'description' => 'Pour un anniversaire reussi avec les copains : biscuits, bonbons, jus de fruits et surprises.',
                'tags' => 'Famille,Fetes',
                'likes_count' => 8,
                'dislikes_count' => 0,
                'copies_count' => 5,
                'views_count' => 32,
                'created_at' => now()->subDays(7),
            ],
            [
                'user_email' => 'thomas@example.com',
                'title' => 'BBQ entre potes',
                'description' => 'La liste ultime pour un barbecue entre amis. Chips, sauces, boissons et tout le necessaire.',
                'tags' => 'Apero,Fetes',
                'likes_count' => 18,
                'dislikes_count' => 3,
                'copies_count' => 11,
                'views_count' => 78,
                'created_at' => now()->subDays(1),
            ],
            [
                'user_email' => 'camille@example.com',
                'title' => 'Essentiels menage du mois',
                'description' => 'Tout ce qu\'il faut pour un mois de proprete : produits menagers, eponges, sacs poubelle.',
                'tags' => 'Budget,Rapide',
                'likes_count' => 6,
                'dislikes_count' => 1,
                'copies_count' => 4,
                'views_count' => 25,
                'created_at' => now()->subDays(10),
            ],
            [
                'user_email' => 'marie@example.com',
                'title' => 'Petit-dejeuner gourmand',
                'description' => 'Pour des matins qui commencent bien : cafe, jus, Nutella et petits biscuits.',
                'tags' => 'Famille,Rapide',
                'likes_count' => 15,
                'dislikes_count' => 0,
                'copies_count' => 9,
                'views_count' => 55,
                'created_at' => now()->subDays(2),
            ],
            [
                'user_email' => 'lucas@example.com',
                'title' => 'Apero du vendredi',
                'description' => 'Cacahuetes, chips, olives et boissons fraiches. Le combo parfait pour decompresser !',
                'tags' => 'Apero,Budget',
                'likes_count' => 30,
                'dislikes_count' => 1,
                'copies_count' => 22,
                'views_count' => 150,
                'created_at' => now()->subHours(12),
            ],
            [
                'user_email' => 'thomas@example.com',
                'title' => 'Survivaliste semaine de partiels',
                'description' => 'Cafe en masse, snacks rapides et plats en conserve. Pour survivre aux revisions.',
                'tags' => 'Etudiant,Rapide',
                'likes_count' => 20,
                'dislikes_count' => 4,
                'copies_count' => 13,
                'views_count' => 95,
                'created_at' => now()->subDays(4),
            ],
        ];

        foreach ($lists as $listData) {
            $user = $users->firstWhere('email', $listData['user_email']);
            if (! $user) {
                continue;
            }

            $slug = Str::slug($listData['title']);
            if (SharedList::where('slug', $slug)->exists()) {
                continue;
            }

            $list = SharedList::create([
                'user_id' => $user->id,
                'title' => $listData['title'],
                'slug' => $slug,
                'description' => $listData['description'],
                'tags' => $listData['tags'],
                'is_public' => true,
                'likes_count' => $listData['likes_count'],
                'dislikes_count' => $listData['dislikes_count'],
                'copies_count' => $listData['copies_count'],
                'views_count' => $listData['views_count'],
                'created_at' => $listData['created_at'],
                'updated_at' => $listData['created_at'],
            ]);

            // Add 3-6 random products
            $randomProducts = $products->random(rand(3, 6));
            foreach ($randomProducts as $product) {
                SharedListItem::create([
                    'shared_list_id' => $list->id,
                    'product_id' => $product->id,
                    'quantity' => rand(1, 4),
                ]);
            }
        }

        // Add votes from different users
        $allLists = SharedList::all();
        foreach ($allLists as $list) {
            $voters = $users->where('id', '!=', $list->user_id)->random(min(3, $users->count() - 1));
            foreach ($voters as $voter) {
                if (SharedListVote::where('shared_list_id', $list->id)->where('user_id', $voter->id)->exists()) {
                    continue;
                }
                SharedListVote::create([
                    'shared_list_id' => $list->id,
                    'user_id' => $voter->id,
                    'vote' => rand(0, 4) > 0 ? 1 : -1, // 80% likes
                ]);
            }
        }

        // Add comments
        $comments = [
            'Super liste, merci pour le partage !',
            'J\'ai teste, c\'est top pour le prix.',
            'Il manque peut-etre du fromage mais sinon parfait.',
            'Genial, je copie direct dans mon panier !',
            'Bonne idee, je n\'y aurais pas pense.',
            'Exactement ce qu\'il me fallait, merci !',
            'Un peu cher pour moi mais la qualite est la.',
            'Je recommande a 100%, teste et approuve.',
        ];

        foreach ($allLists->random(min(6, $allLists->count())) as $list) {
            $commenters = $users->where('id', '!=', $list->user_id)->random(rand(1, 3));
            foreach ($commenters as $commenter) {
                SharedListComment::create([
                    'shared_list_id' => $list->id,
                    'user_id' => $commenter->id,
                    'content' => $comments[array_rand($comments)],
                    'created_at' => $list->created_at->addHours(rand(1, 48)),
                ]);
            }
        }
    }

    private function seedPartners(): void
    {
        $partners = [
            [
                'name' => 'Kebab Royal',
                'slug' => 'kebab-royal',
                'type' => 'kebab',
                'description' => 'Le meilleur kebab d\'Ambert ! Viandes fraiches grillees, sauces maison et galettes croustillantes.',
                'address' => 'Rue du Commerce, 63600 Ambert',
                'phone' => '04 73 XX XX XX',
                'sort_order' => 1,
            ],
            [
                'name' => 'Pizza Bella',
                'slug' => 'pizza-bella',
                'type' => 'pizza',
                'description' => 'Pizzas artisanales cuites au feu de bois. Large choix de pizzas classiques et originales.',
                'address' => 'Place du Pontel, 63600 Ambert',
                'phone' => '04 73 XX XX XX',
                'sort_order' => 2,
            ],
            [
                'name' => 'Boulangerie du Livradois',
                'slug' => 'boulangerie-livradois',
                'type' => 'boulangerie',
                'description' => 'Pain artisanal, viennoiseries et patisseries. Farine locale et savoir-faire traditionnel.',
                'address' => 'Boulevard Henri IV, 63600 Ambert',
                'phone' => '04 73 XX XX XX',
                'sort_order' => 3,
            ],
        ];

        foreach ($partners as $data) {
            Partner::firstOrCreate(
                ['slug' => $data['slug']],
                array_merge($data, ['is_active' => true])
            );
        }
    }
}
