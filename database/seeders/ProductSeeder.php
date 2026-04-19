<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'product_name' => '100 ',
                'product_type' => 'coins',
                'price' => 1000,
                'description' => 'Paket Starter: Dapatkan 100 koin untuk belanja in-game.',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_name' => '300',
                'product_type' => 'coins',
                'price' => 3000,
                'description' => 'Paket Hemat: Dapatkan 300 koin lebih cepat.',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_name' => '500',
                'product_type' => 'coins',
                'price' => 5000,
                'description' => 'Paket Populer: Koin cukup untuk beli item langka.',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_name' => '1000',
                'product_type' => 'coins',
                'price' => 10000,
                'description' => 'Paket Pro: 1.000 koin untuk kebutuhan besar.',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_name' => '5000',
                'product_type' => 'coins',
                'price' => 50000,
                'description' => 'Paket Whale: Dapatkan 5.000 koin sekaligus!',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_name' => '10000',
                'product_type' => 'coins',
                'price' => 100000,
                'description' => 'Paket Sultan: Koleksi 10.000 koin untuk dominasi server.',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Memasukkan data ke tabel products
        DB::table('products')->insert($products);
    }
}