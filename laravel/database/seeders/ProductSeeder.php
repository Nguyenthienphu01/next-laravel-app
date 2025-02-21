<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [];
        
        for ($i = 1; $i <= 5; $i++) {
            $name = "Product " . $i;
            $price = rand(10, 1000);
            $sale_price = rand(5, $price);
            
            $products[] = [
                'name' => $name,
                'description' => "Description for " . $name,
                'sku' => 'SKU-' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'slug' => Str::slug($name),
                'price' => $price,
                'sale_price' => $sale_price,
                'stock_quantity' => rand(0, 100),
                'is_in_stock' => rand(0, 1),
                'meta_title' => $name . ' | Your Store',
                'meta_description' => "Meta description for " . $name,
                'meta_keywords' => "keyword1, keyword2, keyword" . $i,
                'status' => rand(0, 1),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        DB::table('products')->insert($products);
    }
}