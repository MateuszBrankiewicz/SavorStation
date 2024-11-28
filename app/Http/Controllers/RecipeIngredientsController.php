<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Support\Facades\DB;

class RecipeIngredientsController extends Controller
{
    public function index($id)
    {
        $ingredients = DB::table('ingredients')
            ->join('recipe_ingredients', 'ingredients.id', '=', 'recipe_ingredients.ingredient_id')
            ->where('recipe_ingredients.recipe_id', $id)
            ->select('ingredients.id', 'ingredients.name', 'recipe_ingredients.amount', 'recipe_ingredients.unity')
            ->get();

        $recipe = Recipe::find($id);
        $recipe->instructions = explode(',', $recipe->instructions);
        $combinedIngredients = $ingredients->map(function ($ingredient) {
            return [
                'name' => $ingredient->name,
                'amount' => $ingredient->amount,
                'unity' => $ingredient->unity,
            ];
        });
        $comments = (new CommentController)->getComment($recipe);

        return view('recipes.show', compact('recipe', 'combinedIngredients', 'comments'));
    }
}
