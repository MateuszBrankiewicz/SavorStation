<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;

class SearchQuery extends Controller
{
    public function index(Request $request)
    {
        $query = Recipe::query();
    
        if ($request->content !== null && $request->content !== "") {
            $searchTerm = strtolower($request->content);
            $query->whereRaw("LOWER(title) LIKE ?", ["%{$searchTerm}%"])
                  ->orWhereHas('ingredients', function($subQuery) use ($searchTerm) {
                      $subQuery->whereRaw("LOWER(name) LIKE ?", ["%{$searchTerm}%"]);
                  });
        }
    
        if ($request->category !== null && (int)$request->category !== 0) {
            $query->where('category_id', (int)$request->category);
        }
    
        if ($request->makeTime !== null && is_numeric($request->makeTime)) {
            $query->where('make_time', '<=', (int)$request->makeTime);
        }
    
        if ($request->sortingValue !== null && $request->sortingValue !== '0') {
            switch ($request->sortingValue) {
                case 'ratingDec':
                    $query->orderBy('rating', 'desc');
                    break;
                case 'ratingInc':
                    $query->orderBy('rating', 'asc');
                    break;
                case 'timeDec':
                    $query->orderBy('make_time', 'desc');
                    break;
                case 'timeInc':
                    $query->orderBy('make_time', 'asc');
                    break;
                case 'ratingCountDec':
                    $query->orderBy('votes', 'desc');
                    break;
                case 'ratingCountInc':
                    $query->orderBy('votes', 'asc');
                    break;
            }
        }
    
        $recipes = $query->paginate(9);
    
        return view('recipes.index', compact('recipes'));
    }
 
}
