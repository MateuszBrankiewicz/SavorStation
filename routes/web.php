<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/recipes', function () {
    return view('recipes');
})->name('recipes');
Route::get('/addRecipe', function () {
    return view('recipes.add_recipe');
})->middleware(['auth', 'verified'])->name('add_recipe');
Route::middleware(['auth'])->group(function () {
    // Wyświetlanie formularza dodawania przepisu
    Route::get('/recipes/create', [RecipeController::class, 'create'])->name('recipes.create');

    // Obsługa zapisu nowego przepisu
    Route::post('/recipes', [RecipeController::class, 'store'])->name('recipes.store');

    // Wyświetlanie listy przepisów
    Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');

    // Wyświetlanie pojedynczego przepisu
    Route::get('/recipes/{recipe}', [RecipeController::class, 'show'])->name('recipes.show');
});
require __DIR__.'/auth.php';
