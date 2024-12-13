<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
class SearchQuery extends Controller
{
    public function index(Request $request){
       $searchTerm = strtolower($request -> content);
        $recipes = Recipe::whereRaw( "LOWER(title) LIKE ?",["%".strtolower($searchTerm)."%"])
        ->orWhereHas('ingredients', function($query) use ($searchTerm) {
            $query->whereRaw('LOWER(name) LIKE ?',["%{$searchTerm}%"]);
        })->paginate(9);
      
        
        return view('recipes.index', compact('recipes'));
    }
}
