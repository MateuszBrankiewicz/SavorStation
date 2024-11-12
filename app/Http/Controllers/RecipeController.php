<?php

namespace App\Http\Controllers;

use App\Models\Recipe; // Dodaj import modelu Recipe

class RecipeController extends Controller
{
    public function show()
    {
        // Pobierz wszystkie przepisy z bazy danych
        $recipes = Recipe::all();

        // Przekaż listę przepisów do widoku 'recipes'
        return view('recipes', [
            'recipes' => $recipes,
        ]);
    }
}
