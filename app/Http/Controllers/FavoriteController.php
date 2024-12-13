<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Recipe;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
 public function getUserRecipes($userId){

    $favorite = Favorite::where('user_id', $userId) -> get();
    //$data = json_decode($recipes, true); // Use `true` for associative array
    error_log($favorite);
    $recipeIds = $favorite->pluck('recipe_id');
    $recipes = Recipe::whereIn('id', $recipeIds) -> paginate(9);
    //$data = json_decode($favorite, true); // Use `true` for associative array

    //error_log($recipes);
    return view('favorite-recipes', compact('recipes'));
 }
}
