<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\User;
use function Laravel\Prompts\error;

class RecipeController extends Controller
{
    public function create()
    {
        return view('recipes.create');
    }

    public function show(Recipe $recipe)
    {

        $recipe->load('ingredients');

        error_log(print_r($recipe->ingredients, return: true));  // Logs the ingredients to the error log

        return view('recipes.show', compact('recipe'));
    }

    public function index()
{
    
        $test = Recipe::find(4);
        error_log($test);
   
        $recipes = Recipe::paginate(9);
    
        return view('recipes.index', ['recipes' => $recipes]);
}
    public function store(Request $request)
    {
        error_log('Store method called');

        // Walidacja danych
        $request->validate([
            'recipeName' => 'required|string|max:255',
            'recipeDescription' => 'required|string',
            'ingredients' => 'required|array',
            'ingredients.*' => 'string|min:1', // Walidacja dla każdego składnika
            'amounts' => 'required|array',
            'amounts.*' => 'numeric|min:0.01', // Walidacja dla każdej ilości
            'recipeImage' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // Obsługa obrazów do 2 MB
            'steps' => 'required|array',
        ]);

        $imagePath = null;

        // Obsługa obrazu przepisu
        if ($request->hasFile('recipeImage')) {
            $imagePath = $request->file('recipeImage')->store('recipes', 'public'); // Przechowywanie w katalogu public/recipes
            error_log('Image path: '.$imagePath);
        } else {
            error_log('No image uploaded');
        }

        DB::beginTransaction();

        try {
            $steps = implode(',', $request->steps);

            // Tworzenie nowego przepisu
            $recipe = new Recipe;
            $recipe->user_id = Auth::id();
            $recipe->title = $request->recipeName;
            $recipe->description = $request->recipeDescription;
            $recipe->instructions = $steps;
            $recipe->image_path = $imagePath; // Zapisanie ścieżki zdjęcia do bazy
            $recipe->save();

            error_log('Przepis zapisany w bazie danych');

            // Walidacja długości tablic
            if (count($request->ingredients) !== count($request->amounts)) {
                throw new \Exception('Ingredients and amounts arrays have different lengths');
            }

            // Dodawanie składników do przepisu
            foreach ($request->ingredients as $index => $ingredientName) {
                if (! empty($ingredientName) && isset($request->amounts[$index])) {
                    $ingredient = Ingredient::firstOrCreate(['name' => $ingredientName]);
                    error_log('Utworzono lub znaleziono składnik: '.print_r($ingredient->toArray(), true));

                    $amount = $request->amounts[$index];
                    $unity = $request->unity[$index] ?? null;

                    error_log('Ingredient: '.$ingredientName.', Amount: '.$amount);

                    $recipe->ingredients()->attach($ingredient->id, [
                        'amount' => $amount,
                        'unity' => $unity,
                    ]);
                } else {
                    error_log("Invalid ingredient or amount at index $index");
                }
            }

            DB::commit();
            error_log('Transaction committed');

            return redirect()->route('recipes.index')->with('success', 'Recipe added successfully.');

        } catch (\Exception $e) {
            DB::rollback();
            error_log('Błąd: '.$e->getMessage());

            return back()->withErrors(['error' => 'Wystąpił problem podczas dodawania przepisu: '.$e->getMessage()]);
        }
    }
    public function rate(Request $request, Recipe $recipe){
        $validated = $request -> validate(
            ['rating' => 'required|numeric|min:0|max:5']
        );
        $newRating = $recipe -> rating * $recipe -> votes;
        $newRating = $newRating + $validated['rating'];
        $newRating = $newRating/($recipe->votes + 1);
        $recipe -> rating = $newRating;
        $recipe -> votes +=1;
        $recipe->save();
       return response()->json([
            'newRating' => $newRating
       ]);
    }
}
