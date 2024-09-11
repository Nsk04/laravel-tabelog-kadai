<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
    
        $food_categories = [
            '和食', 'イタリア料理', 'フランス料理', '中華料理','韓国料理', 'タイ料理', 'スペイン料理','海鮮料理','定食','一品料理','和菓子','洋菓子'
        ];
    
    
                foreach ($food_categories as $food_category) {
                    Category::create([
                        'name' => $food_category,
                        'description' => $food_category
                    ]);
                }
    
    }
}
