<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Seed bk_categories table.
     */
    public function run(): void
    {
        $targetCategories = 12;
        $existingCategories = Category::query()->count();

        if ($existingCategories < $targetCategories) {
            Category::factory()->count($targetCategories - $existingCategories)->create();
        }
    }
}
