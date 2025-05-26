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
                'image' => 'default/ingredient1.png',
                'unit' => 'Kg',
            ],
            [
                'name_ingredient' => 'Cá thu',
                'image' => 'default/ingredient2.png',
                'unit' => 'Kg',
            ],
            [
                'name_ingredient' => 'Mực khô',
                'image' => 'default/ingredient3.png',
                'unit' => 'Kg',
            ],
            [
                'name_ingredient' => 'Tôm',
                'image' => 'default/ingredient4.png',
                'unit' => 'Kg',
            ],
            [
                'name_ingredient' => 'Ốc',
                'image' => 'default/ingredient5.png',
                'unit' => 'Kg',
            ],
        ];

        foreach ($ingredients as $ingredient) {
            Ingredient::create($ingredient);
        }
    }
}
