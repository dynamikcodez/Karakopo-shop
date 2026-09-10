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
        // 1. Create Admin User
        User::firstOrCreate(
            ['email' => 'admin@karakopo.com'],
            [
                'name' => 'Karakopo Admin',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        // 2. Create Categories
        $kitchenCat = Category::firstOrCreate([
            'slug' => 'kitchen-essentials'
        ], [
            'name' => 'Kitchen Essentials',
            'description' => 'Premium, durable, and beautiful utilities for your kitchen.',
            'image' => 'categories/kitchen.png',
            'is_published' => true,
        ]);

        $homeDecorCat = Category::firstOrCreate([
            'slug' => 'home-decor'
        ], [
            'name' => 'Home Decor',
            'description' => 'Elevate your living space with our curated decor pieces.',
            'image' => 'categories/home_decor.png',
            'is_published' => true,
        ]);

        // 3. Create Products & Images
        
        $plates = Product::firstOrCreate([
            'sku' => 'KAR-KIT-001'
        ], [
            'category_id' => $kitchenCat->id,
            'name' => 'Premium Ceramic Dining Plates (Set of 4)',
            'slug' => 'premium-ceramic-dining-plates-set-of-4',
            'short_description' => 'Sleek, modern premium ceramic plates set.',
            'description' => 'Elevate your dining experience with this beautiful set of 4 premium ceramic plates. Hand-finished with a minimalist warm tone perfect for the modern Nigerian home. Microwave and dishwasher safe.',
            'price' => 25000,
            'sale_price' => null,
            'stock' => 50,
            'is_published' => true,
            'is_featured' => true,
        ]);

        if ($plates->images()->count() === 0) {
            $plates->images()->create([
                'image_path' => 'products/premium_plates.png',
                'is_primary' => true,
            ]);
        }

        $board = Product::firstOrCreate([
            'sku' => 'KAR-KIT-002'
        ], [
            'category_id' => $kitchenCat->id,
            'name' => 'Luxury Bamboo Cutting Board',
            'slug' => 'luxury-bamboo-cutting-board',
            'short_description' => 'High-end, durable bamboo cutting board.',
            'description' => 'A heavy-duty, high-end bamboo cutting board that is as beautiful as it is functional. Naturally antibacterial and easy on your knives. A must-have for any serious kitchen.',
            'price' => 15000,
            'sale_price' => 12500,
            'stock' => 30,
            'is_published' => true,
            'is_featured' => true,
        ]);

        if ($board->images()->count() === 0) {
            $board->images()->create([
                'image_path' => 'products/bamboo_board.png',
                'is_primary' => true,
            ]);
        }
    }
}
