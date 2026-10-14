<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $cat = [];
        foreach (['Dog Food', 'Cat Food', 'Fish Supplies', 'Bird Supplies', 'Toys', 'Grooming', 'Health & Medicine', 'Accessories'] as $name) {
            $cat[$name] = Category::firstOrCreate(['name' => $name]);
        }

        $brand = [];
        foreach (['Royal Canin', 'Pedigree', 'Whiskas', 'Kong', 'Tetra', 'Vitapet'] as $name) {
            $brand[$name] = Brand::firstOrCreate(['name' => $name]);
        }

        $sup = [
            'PetPro Distributors' => Supplier::firstOrCreate(['name' => 'PetPro Distributors'], [
                'contact_person' => 'Maria Santos', 'email' => 'orders@petpro.example', 'phone' => '0917 000 1111', 'address' => 'Quezon City',
            ]),
            'AquaWorld Trading' => Supplier::firstOrCreate(['name' => 'AquaWorld Trading'], [
                'contact_person' => 'Jose Reyes', 'email' => 'sales@aquaworld.example', 'phone' => '0917 000 2222', 'address' => 'Makati City',
            ]),
        ];

        $products = [
            ['DOG-RC-2KG',  'Royal Canin Adult Dog Food 2kg', 'Dog Food', 'Royal Canin', 'PetPro Distributors', 'dog',  900, 1150, 24, 6, '+8 months'],
            ['DOG-PD-1KG',  'Pedigree Beef Dry Dog Food 1kg', 'Dog Food', 'Pedigree',    'PetPro Distributors', 'dog',  250,  330, 3,  8, '+20 days'],
            ['CAT-WH-1KG',  'Whiskas Tuna Adult Cat Food 1kg', 'Cat Food', 'Whiskas',    'PetPro Distributors', 'cat',  280,  360, 18, 6, '+10 months'],
            ['DOG-KG-M',    'Kong Classic Chew Toy (M)',       'Toys',     'Kong',       'PetPro Distributors', 'dog',  420,  560, 10, 4, null],
            ['FISH-TT-100', 'Tetra Fish Flakes 100g',          'Fish Supplies', 'Tetra', 'AquaWorld Trading',   'fish', 150,  210, 2,  5, '+5 months'],
            ['ALL-VP-VIT',  'Vitapet Multivitamin Syrup 120ml', 'Health & Medicine', 'Vitapet', 'PetPro Distributors', 'all', 180, 260, 15, 5, '+25 days'],
        ];

        foreach ($products as [$sku, $name, $c, $b, $s, $pet, $cost, $price, $stock, $reorder, $expiry]) {
            Product::firstOrCreate(['sku' => $sku], [
                'name' => $name,
                'category_id' => $cat[$c]->id,
                'brand_id' => $brand[$b]->id,
                'supplier_id' => $sup[$s]->id,
                'pet_type' => $pet,
                'cost_price' => $cost,
                'price' => $price,
                'stock' => $stock,
                'reorder_level' => $reorder,
                'expiry_date' => $expiry ? now()->modify($expiry)->toDateString() : null,
            ]);
        }
    }
}
