<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException; 

use App\Models\User;
use function Laravel\Prompts\error;

class RecipeController extends Controller
{
    private function validateRecipe(Request $request)
{
    $request->validate([
        'recipeName' => 'required|string|min:3|max:255',
        'recipeDescription' => 'required|string',
        'ingredients' => 'required|array|min:1',
        'ingredients.*' => 'string|min:1',
        'amounts' => 'required|array|min:1',
        'amounts.*' => 'numeric|min:0.01',
        'unity' => 'required|array|min:1',
        'unity.*' => 'string|in:kg,ml,l,g,lyz,szt,szkl',
        'recipeImage' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'steps' => 'required|array|min:1',
        'steps.*' => 'required|string|min:1',
        'categoryRec' => 'required|in:1,2,3,4,5,6,7,8,9,10',
        'makeTime' => 'required|min:0'
    ], [
        'recipeName.required' => 'Nazwa przepisu jest wymagana.',
        'recipeName.string' => 'Nazwa przepisu musi być tekstem.',
        'recipeName.min' => 'Nazwa przepisu musi mieć co najmniej 3 znaki.',
        'recipeDescription.required' => 'Opis przepisu jest wymagany.',
        'ingredients.required' => 'Składniki są wymagane.',
        'ingredients.min' => 'Przepis musi zawierać co najmniej jeden składnik.',
        'ingredients.*.string' => 'Każdy składnik musi być tekstem.',
        'amounts.required' => 'Ilości składników są wymagane.',
        'amounts.*.numeric' => 'Każda ilość musi być liczbą.',
        'unity.required' => 'Jednostki miary są wymagane.',
        'unity.*.in' => 'Nieprawidłowa jednostka miary.',
        'recipeImage.image' => 'Plik musi być obrazem.',
        'recipeImage.mimes' => 'Plik musi mieć format: jpg, jpeg, png, webp.',
        'recipeImage.max' => 'Obraz może mieć maksymalny rozmiar 2 MB.',
        'steps.required' => 'Kroki przepisu są wymagane.',
        'steps.min' => 'Przepis musi zawierać co najmniej jeden krok.',
        'steps.*.string' => 'Każdy krok musi być tekstem.',
        'categoryRec.not_in' => 'Kategoria jest wymagana',
        'makeTime.required' => 'Czas wykonania jest wymagany',
    ]);

    // Dodatkowa walidacja: sprawdzenie długości tablic
    if (count($request->ingredients) !== count($request->amounts) || count($request->ingredients) !== count($request->unity)) {
        throw ValidationException::withMessages([
            'ingredients' => 'Wszystkie składniki muszą mieć odpowiednie ilości i jednostki miary.',
        ]);
    }
}

    // Prywatna metoda do obsługi obrazu
    private function handleImage(Request $request)
    {
        if ($request->hasFile('recipeImage')) {
            return $request->file('recipeImage')->store('recipes', 'public');
        }

        return null;
    }
    private function createRecipe(Request $request, $imagePath)
    {
        $steps = implode(',', $request->steps);

        $recipe = new Recipe;
        $recipe->user_id = Auth::id();
        $recipe->title = $request->recipeName;
        $recipe->description = $request->recipeDescription;
        $recipe->instructions = $steps;
        $recipe->image_path = $imagePath;
        $recipe->category_id = $request->categoryRec;
        $recipe->make_time = $request->makeTime;
        $recipe->save();

        return $recipe;
    }
    private function addIngredientsToRecipe(Request $request, Recipe $recipe)
    {
        if (count($request->ingredients) !== count($request->amounts)) {
            throw new \Exception('Ingredients and amounts arrays have different lengths');
        }

        foreach ($request->ingredients as $index => $ingredientName) {
            if (!empty($ingredientName) && isset($request->amounts[$index])) {
                $ingredient = Ingredient::firstOrCreate(['name' => $ingredientName]);

                $amount = $request->amounts[$index];
                $unity = $request->unity[$index] ?? null;

                $recipe->ingredients()->attach($ingredient->id, [
                    'amount' => $amount,
                    'unity' => $unity,
                ]);
            }
        }
    }


    public function create()
    {
        return view('recipes.create');
    }

   
    public function index()
{
    

   
        $recipes = Recipe::paginate(9);
    
        return view('recipes.index', ['recipes' => $recipes]);
}
public function store(Request $request)
{
    // Walidacja danych
    $this->validateRecipe($request);

    // Obsługa obrazu
    $imagePath = $this->handleImage($request);

    DB::beginTransaction();

    try {
        // Tworzenie nowego przepisu
        $recipe = $this->createRecipe($request, $imagePath);

        // Dodawanie składników do przepisu
        $this->addIngredientsToRecipe($request, $recipe);

        DB::commit();

        return redirect()->route('recipes.index')->with('success', 'Przepis dodany pomyślnie');
    } catch (\Exception $e) {
        DB::rollback();

        return back()->withErrors(['error' => 'Wystąpił problem podczas dodawania przepisu: '.$e->getMessage()]);
    }
}

    public function update(Request $request, $id)
    {
        // Walidacja danych
        $this->validateRecipe($request);

        DB::beginTransaction();

        try {
            $recipe = Recipe::findOrFail($id);

            // Aktualizacja obrazu
            $imagePath = $this->handleImage($request);
            if ($imagePath) {
                $recipe->image_path = $imagePath;
            }

            // Aktualizacja danych przepisu
            $recipe->title = $request->recipeName;
            $recipe->description = $request->recipeDescription;
            $recipe->instructions = implode(',', $request->steps);
            $recipe->category_id = $request->categoryRec;
            $recipe->make_time = $request->makeTime;
            $recipe->save();

            // Aktualizacja składników przepisu
            $recipe->ingredients()->detach();
            $this->addIngredientsToRecipe($request, $recipe);

            DB::commit();

            return redirect()->route('recipes.index')->with('success', 'Przepis zaktualizowana pomyślnie');
        } catch (\Exception $e) {
            DB::rollback();

            return back()->withErrors(['error' => 'Wystąpił problem podczas aktualizowania przepisu: '.$e->getMessage()]);
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
    public function addFavorite(Request $request, $id) {
        $favorite = new Favorite();
        $existingFavorite = $favorite::where('recipe_id',$id) -> where('user_id', auth() -> id());
        if($existingFavorite -> exists()){
            $existingFavorite -> delete();
            return back() -> with('succes', 'Przepis został usunięty');
        }
        $favorite->user_id = auth()->id(); 
        $favorite->recipe_id = $id;
        $favorite->save();
        return back()->with('success', 'Przepis dodany do ulubionych!');
    }
    public function getUserRecipes($userId){
        $recipes = Recipe::where('user_id', $userId) -> paginate(9);
        return view('user-recipes',compact('recipes'));
    }
    public function showEdit($id)
{
    $recipe = Recipe::findOrFail($id); 
    $recipe -> instructions = explode(',',$recipe->instructions);
    $ingredients = Ingredient::getIngredients($id);
    return view('recipes.edit-recipes', compact('recipe','ingredients'));
}
    public function searchCategory($categoryId){
        $recipes = Recipe::where('category_id',$categoryId) -> paginate(9);
        return view('recipes.index', compact('recipes'));
    }
    public function delete($id){
        error_log('usuwam');
        $recipe = Recipe::findOrFail($id);
        $recipe->delete();
    
        return redirect()->route('recipes.index')->with('success', 'Przepis został usunięty.');            $recipe -> delete();
        }
    }

