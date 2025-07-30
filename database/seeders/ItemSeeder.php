<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            ['name' => 'Beras 5kg', 'description' => 'Beras pulen kualitas premium'],
            ['name' => 'Air Mineral', 'description' => 'Air mineral botol 600ml'],
            ['name' => 'Pulpen Hitam', 'description' => 'Pulpen tinta gel warna hitam'],
            ['name' => 'Sabun Mandi', 'description' => 'Sabun batang wangi segar'],
            ['name' => 'Rice Cooker', 'description' => 'Rice cooker 1.8L hemat listrik'],
            ['name' => 'Minyak Goreng', 'description' => 'Minyak goreng 1 liter'],
            ['name' => 'Notebook', 'description' => 'Buku catatan 40 lembar'],
            ['name' => 'Sapu Ijuk', 'description' => 'Sapu ijuk gagang panjang'],
            ['name' => 'Kipas Angin', 'description' => 'Kipas angin meja 12 inch'],
            ['name' => 'Teh Celup', 'description' => 'Teh celup isi 25 kantong']
        ];

        $categoryIds = Category::pluck('id')->toArray();

        foreach ($items as $item) {
            Item::create([
                'name' => $item['name'],
                'description' => $item['description'],
                'category_id' => fake()->randomElement($categoryIds),
                'stock' => fake()->numberBetween(1, 10),
            ]);
        }
    }
}
