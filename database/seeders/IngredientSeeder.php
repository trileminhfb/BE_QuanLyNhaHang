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
                'name_ingredient' => 'default/Thịt bò nga',
                'image' => 'thịt bò nga.jpg',
                'unit' => 'Kg',
            ],
            [
                'name_ingredient' => 'Cá thu',
                'image' => 'default/cá thu.jpg',
                'unit' => 'Kg',
            ],
            [
                'name_ingredient' => 'Mực khô',
                'image' => 'default/mực khô.jpg',
                'unit' => 'Kg',
            ],
            [
                'name_ingredient' => 'Tôm',
                'image' => 'default/tôm.jpg',
                'unit' => 'Kg',
            ],
            [
                'name_ingredient' => 'Ốc',
                'image' => 'default/ốc.jpg',
                'unit' => 'Kg',
            ],
        ];

        foreach ($ingredients as $ingredient) {
            Ingredient::create($ingredient);
        }
    }
}
