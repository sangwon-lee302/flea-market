<?php

namespace Database\Seeders;

use App\Category as CategoryEnum;
use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryData = array_map(fn ($category) => [
            'name' => $category->value,
        ], CategoryEnum::cases());

        Category::upsert($categoryData, ['name'], ['name']);
    }
}
