<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Recipe; // Dodaj import modelu Recipe
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function create()
    {
        return view('recipes.create');
    }

    public function show(Recipe $recipe)
    {
        return view('recipes.show', compact('recipe'));
    }

    public function index()
    {
        $recipes = Recipe::with('ingredients')->latest()->get();

        return view('recipes.index', compact('recipes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'recipeName' => 'required|string|max:255',
            'recipeDescription' => 'required|string',
            'ingredients' => 'required|array',
            'quantities' => 'required|array',
            'recipeImage' => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ]);
        $imagePath = null;
        if ($request->hasFile('recipeImage')) {
            $imagePath = $request->file('recipeImage')->store('recipes', 'public');
        }
        $recipe = Recipe::create([
            'user_id' => auth()->id(),
            'title' => $request->recipeName,
            'description' => $request->recipeDescription,
            'instructions' => '',
            'image_path' => $imagePath,
        ]);
        foreach ($request->ingredients as $index => $ingredientsName) {
            if (! empty($ingredientsName)) {
                $recipe->ingredients->attach(
                    Ingredient::firstOrCreate(['name => $ingredientName']), ['amount' => $request->amounts[$index]]
                );
            }
        }

        return redirect()->route('recipes.show')->with('succes', 'Przepis zostal dodany');
    }
}
