<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Produk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::factory(6)
            ->has(Produk::factory()->count(6))
            ->create();
    }
}
