<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create or Update Admin User
        User::updateOrCreate(
            ['email' => 'admin@karakopo.com'],
            [
                'name' => 'Karakopo Admin',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        // 2. Categories
        $categories = [
            'kitchen-essentials' => [
                'name' => 'Kitchen Essentials',
                'description' => 'Premium cookware, tools, and durable food storage for modern culinary spaces.',
                'image' => 'https://images.unsplash.com/photo-1556911220-e15b29be8c8f?q=80&w=1000&auto=format&fit=crop',
                'is_published' => true,
            ],
            'home-decor' => [
                'name' => 'Home Decor & Living',
                'description' => 'Aesthetic accents, artisanal vessels, and statement pieces to elevate every room.',
                'image' => 'https://images.unsplash.com/photo-1513519245088-0e12902e5a38?q=80&w=1000&auto=format&fit=crop',
                'is_published' => true,
            ],
            'tableware-dining' => [
                'name' => 'Tableware & Dining',
                'description' => 'Handcrafted stoneware, drinkware sets, and cutlery designed for memorable hosting.',
                'image' => 'https://images.unsplash.com/photo-1610701596007-11502861dcfa?q=80&w=1000&auto=format&fit=crop',
                'is_published' => true,
            ],
            'gifts-souvenirs' => [
                'name' => 'Gifts & Souvenirs',
                'description' => 'Thoughtfully packaged souvenir sets, scented candles, and curated gift hampers.',
                'image' => 'https://images.unsplash.com/photo-1549465220-1a8b9238cd48?q=80&w=1000&auto=format&fit=crop',
                'is_published' => true,
            ],
            'bathroom-organization' => [
                'name' => 'Bathroom & Organization',
                'description' => 'Plush bamboo towels, woven storage solutions, and spa-grade organization accessories.',
                'image' => 'https://images.unsplash.com/photo-1616627547584-bf28cee262db?q=80&w=1000&auto=format&fit=crop',
                'is_published' => true,
            ],
        ];

        $catModels = [];
        foreach ($categories as $slug => $data) {
            $catModels[$slug] = Category::updateOrCreate(
                ['slug' => $slug],
                $data
            );
        }

        // 3. Products
        $products = [
            [
                'sku' => 'KAR-TAB-001',
                'category_id' => $catModels['tableware-dining']->id,
                'name' => 'Premium Ceramic Dining Plates (Set of 4)',
                'slug' => 'premium-ceramic-dining-plates-set-of-4',
                'short_description' => 'Sleek, modern minimalist ceramic dinner plates set.',
                'description' => "Elevate your dining experience with this beautiful set of 4 premium ceramic plates. Hand-finished with a minimalist warm tone perfect for the modern home. Highly durable, microwave-safe, and dishwasher-friendly.",
                'price' => 28000,
                'sale_price' => 25000,
                'stock' => 45,
                'is_published' => true,
                'is_featured' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1610701596007-11502861dcfa?q=80&w=1000&auto=format&fit=crop',
                    'products/premium_plates.png',
                ],
            ],
            [
                'sku' => 'KAR-KIT-002',
                'category_id' => $catModels['kitchen-essentials']->id,
                'name' => 'Luxury Bamboo Cutting & Serving Board',
                'slug' => 'luxury-bamboo-cutting-serving-board',
                'short_description' => 'High-density organic bamboo board with juice groove.',
                'description' => "A heavy-duty, high-end bamboo cutting board that is as beautiful as it is functional. Naturally antibacterial, knife-friendly, and features deep juice grooves to keep counters clean.",
                'price' => 15000,
                'sale_price' => 12500,
                'stock' => 35,
                'is_published' => true,
                'is_featured' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1544816155-12df9643f363?q=80&w=1000&auto=format&fit=crop',
                    'products/bamboo_board.png',
                ],
            ],
            [
                'sku' => 'KAR-DEC-003',
                'category_id' => $catModels['home-decor']->id,
                'name' => 'Nordic Doughnut Matte Ceramic Vase',
                'slug' => 'nordic-doughnut-matte-ceramic-vase',
                'short_description' => 'Contemporary minimalist hollow doughnut ceramic vase.',
                'description' => "Add an architectural focal point to your console table, mantle, or dining room. Textured off-white matte glaze designed for dried florals, pampas grass, or standalone aesthetic display.",
                'price' => 12000,
                'sale_price' => 8500,
                'stock' => 28,
                'is_published' => true,
                'is_featured' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1512149177596-f817c7ef5d4c?q=80&w=1000&auto=format&fit=crop',
                ],
            ],
            [
                'sku' => 'KAR-DEC-004',
                'category_id' => $catModels['home-decor']->id,
                'name' => 'Handwoven Natural Rattan Storage Basket',
                'slug' => 'handwoven-natural-rattan-storage-basket',
                'short_description' => 'Artisanal woven basket with integrated carrying handles.',
                'description' => "Crafted from 100% natural rattan fibers. Versatile utility for organizing cozy throws, reading materials, children's toys, or bathroom essentials with organic warmth.",
                'price' => 17500,
                'sale_price' => 14000,
                'stock' => 22,
                'is_published' => true,
                'is_featured' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1581783342308-f792dbdd27c5?q=80&w=1000&auto=format&fit=crop',
                ],
            ],
            [
                'sku' => 'KAR-KIT-005',
                'category_id' => $catModels['kitchen-essentials']->id,
                'name' => 'Double-Wall Stainless Steel Thermal Flask (1000ml)',
                'slug' => 'double-wall-stainless-steel-thermal-flask-1000ml',
                'short_description' => 'Vacuum-insulated flask keeps beverages hot 12hrs / cold 24hrs.',
                'description' => "Engineered from premium food-grade 18/8 stainless steel. Features sweat-free exterior, leak-proof screw cap, and easy-pour spout. Perfect for busy workdays, road trips, and home tea service.",
                'price' => 12000,
                'sale_price' => 9500,
                'stock' => 40,
                'is_published' => true,
                'is_featured' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1602143407151-7111542de6e8?q=80&w=1000&auto=format&fit=crop',
                ],
            ],
            [
                'sku' => 'KAR-GFT-006',
                'category_id' => $catModels['gifts-souvenirs']->id,
                'name' => 'Luxury Scented Soy Candle in Amber Glass (Vanilla & Sandalwood)',
                'slug' => 'luxury-scented-soy-candle-amber-glass',
                'short_description' => 'Hand-poured 100% natural soy wax candle with 45hr clean burn.',
                'description' => "Formulated with premium botanical fragrance oils and lead-free cotton wicks. Notes of creamy Madagascar vanilla, warm amber, and Australian sandalwood fill your sanctuary.",
                'price' => 9000,
                'sale_price' => 7500,
                'stock' => 50,
                'is_published' => true,
                'is_featured' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1603006905003-be475563bc59?q=80&w=1000&auto=format&fit=crop',
                ],
            ],
            [
                'sku' => 'KAR-KIT-007',
                'category_id' => $catModels['kitchen-essentials']->id,
                'name' => 'Airtight Borosilicate Glass Spice Jars with Bamboo Lids (Set of 6)',
                'slug' => 'airtight-glass-spice-jars-bamboo-lids-set-of-6',
                'short_description' => 'Crystal-clear food storage containers with silicone airtight seal.',
                'description' => "Transform your pantry and spice rack into an aesthetic haven. High borosilicate glass withstands thermal shocks, while natural bamboo lids preserve peak freshness and aroma.",
                'price' => 13500,
                'sale_price' => 11000,
                'stock' => 30,
                'is_published' => true,
                'is_featured' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1584269600464-37b1b58a9fe7?q=80&w=1000&auto=format&fit=crop',
                ],
            ],
            [
                'sku' => 'KAR-TAB-008',
                'category_id' => $catModels['tableware-dining']->id,
                'name' => 'Heavy-Base Crystal Cut Drinkware Tumblers (Set of 6)',
                'slug' => 'heavy-base-crystal-cut-drinkware-tumblers-set-of-6',
                'short_description' => 'Vintage diamond-cut crystal glass tumblers for entertaining.',
                'description' => "Substantial weight in hand with brilliant light refraction. Ideal for refreshing iced teas, fresh fruit juices, and classic dinner cocktails. Dishwasher-safe and lead-free.",
                'price' => 20000,
                'sale_price' => 16500,
                'stock' => 25,
                'is_published' => true,
                'is_featured' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1577741314755-048d8525d31e?q=80&w=1000&auto=format&fit=crop',
                ],
            ],
            [
                'sku' => 'KAR-BTH-009',
                'category_id' => $catModels['bathroom-organization']->id,
                'name' => 'Ultra-Soft Bamboo Fiber Bath Towel Set (2 Pieces)',
                'slug' => 'ultra-soft-bamboo-fiber-bath-towel-set-2-pieces',
                'short_description' => '600 GSM hypoallergenic, quick-drying luxury bathroom towels.',
                'description' => "Experience hotel-grade comfort at home. Woven from 70% organic bamboo and 30% combed cotton for unbelievable absorbency, antimicrobial freshness, and silky softness against sensitive skin.",
                'price' => 22000,
                'sale_price' => 18000,
                'stock' => 30,
                'is_published' => true,
                'is_featured' => false,
                'images' => [
                    'https://images.unsplash.com/photo-1616627547584-bf28cee262db?q=80&w=1000&auto=format&fit=crop',
                ],
            ],
            [
                'sku' => 'KAR-TAB-010',
                'category_id' => $catModels['tableware-dining']->id,
                'name' => 'Modern Matte Black Stainless Steel Cutlery Set (16 Pieces)',
                'slug' => 'modern-matte-black-cutlery-set-16-pieces',
                'short_description' => '4-person silverware set: dinner forks, knives, spoons & teaspoons.',
                'description' => "Make every meal a statement with electroplated matte black cutlery. Ergonomic contours, scratch-resistant finish, and balanced weighting ensure long-lasting luxury dining.",
                'price' => 26000,
                'sale_price' => 22000,
                'stock' => 20,
                'is_published' => true,
                'is_featured' => false,
                'images' => [
                    'https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?q=80&w=1000&auto=format&fit=crop',
                ],
            ],
            [
                'sku' => 'KAR-GFT-011',
                'category_id' => $catModels['gifts-souvenirs']->id,
                'name' => 'Luxury Gift Presentation Hamper Box with Silk Ribbon',
                'slug' => 'luxury-gift-presentation-hamper-box-with-silk-ribbon',
                'short_description' => 'Hardboard magnetic closure gift box with shredded raffia paper.',
                'description' => "The premier choice for corporate souvenirs, wedding favors, and birthday gifts. Heavy-gauge rigid board with satin ribbon bow and concealed magnetic snap closure.",
                'price' => 17000,
                'sale_price' => 14500,
                'stock' => 40,
                'is_published' => true,
                'is_featured' => false,
                'images' => [
                    'https://images.unsplash.com/photo-1549465220-1a8b9238cd48?q=80&w=1000&auto=format&fit=crop',
                ],
            ],
            [
                'sku' => 'KAR-KIT-012',
                'category_id' => $catModels['kitchen-essentials']->id,
                'name' => 'Automatic Gravity Salt & Pepper Grinder Mill Pair',
                'slug' => 'automatic-gravity-salt-pepper-grinder-mill-pair',
                'short_description' => 'Battery operated one-hand tilt mills with adjustable ceramic burr.',
                'description' => "Simply tilt upside down to activate automatic grinding. Features a soft blue LED light illuminates food, with adjustable ceramic grinding coarseness from fine powder to coarse cracked pepper.",
                'price' => 24000,
                'sale_price' => 19500,
                'stock' => 25,
                'is_published' => true,
                'is_featured' => false,
                'images' => [
                    'https://images.unsplash.com/photo-1590794056226-79ef3a8147e1?q=80&w=1000&auto=format&fit=crop',
                ],
            ],
        ];

        foreach ($products as $pData) {
            $images = $pData['images'];
            unset($pData['images']);

            $product = Product::where('sku', $pData['sku'])->orWhere('slug', $pData['slug'])->first();
            if ($product) {
                $product->update($pData);
            } else {
                $product = Product::create($pData);
            }

            // Seed images
            $product->images()->delete(); // refresh clean image association
            foreach ($images as $index => $imgPath) {
                $product->images()->create([
                    'image_path' => $imgPath,
                    'is_primary' => $index === 0,
                ]);
            }
        }
    }
}
