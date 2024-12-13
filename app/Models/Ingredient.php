<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function recipes()
    {
        
        return $this->belongsToMany(Recipe::class, 'recipe_ingredients', 'ingredient_id', 'recipe_id')->withPivot('amount', 'unity');
    }
    public static function getIngredients($recipeId){

        $directIngredients = DB::table('ingredients')
        ->join('recipe_ingredients', 'ingredients.id', '=', 'recipe_ingredients.ingredient_id')
        ->where('recipe_ingredients.recipe_id', $recipeId)
        ->select('ingredients.*', 'recipe_ingredients.amount', 'recipe_ingredients.unity')
        ->get();
        $directIngredients = $directIngredients -> toArray();
        return $directIngredients;
    }
}
