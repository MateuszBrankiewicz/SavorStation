<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecipeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['category' => 'Kuchnia włoska'],
            ['category' => 'Kuchnia meksykańska'],
            ['category' => 'Kuchnia polska'],
            ['category' => 'Kuchnia chińska'],
            ['category' => 'Kuchnia japońska'],
            ['category' => 'Kuchnia indyjska'],
            ['category' => 'Kuchnia francuska'],
            ['category' => 'Kuchnia tajska'],
            ['category' => 'Kuchnia amerykańska'],
            ['category' => 'Kuchnia grecka'],
        ];

        DB::table('recipeCategory')->insert($categories);
    }
    
}
