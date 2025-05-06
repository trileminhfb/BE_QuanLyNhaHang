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
                'unit' => 'kg',
            ],
            [
                'name_ingredient' => 'Cá thu',
                'image' => 'ca.jpg',
                'unit' => 'kg',
            ],
            [
                'name_ingredient' => 'Mực khô',
                'image' => 'muc.jpg',
                'unit' => 'kg',
            ],
            [
                'name_ingredient' => 'Tôm',
                'image' => 'tom.jpg',
                'unit' => 'kg',
            ],
            [
                'name_ingredient' => 'Ốc',
                'image' => 'oc.jpg',
                'unit' => 'kg',
            ],
        ];

        foreach ($ingredients as $ingredient) {
            Ingredient::create($ingredient);
        }
    }
}
