<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    public function run(): void
    {
        $ingredients = [
            [
                'name_ingredient' => 'Thịt bò nga',
                'image' => 'thit-bo.jpg',
            ],
            [
                'name_ingredient' => 'Cá thu',
                'image' => 'ca.jpg',
            ],
            [
                'name_ingredient' => 'Mực khô',
                'image' => 'muc.jpg',
            ],
            [
                'name_ingredient' => 'Tôm',
                'image' => 'tom.jpg',
            ],
            [
                'name_ingredient' => 'Ốc',
                'image' => 'oc.jpg',
            ],
        ];

        foreach ($ingredients as $ingredient) {
            Ingredient::create($ingredient);
        }
    }
}
