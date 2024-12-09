<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RecipeIngredientsController;
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

Route::get('/addRecipe', function () {
    return view('recipes.add_recipe');
})->middleware(['auth', 'verified'])->name('add_recipe');

Route::middleware(['auth'])->group(function () {
    Route::get('/recipes/create', [RecipeController::class, 'create'])->name('recipes.create');
    Route::post('/recipes', [RecipeController::class, 'store'])->name('recipes.store');
    Route::get('/allRecipes', [RecipeController::class, 'index'])->name('recipes.index');
    Route::get('/recipes/{recipe}', [RecipeIngredientsController::class, 'index'])->name('recipes.show');
    Route::post('/recipes/{recipe}/rate', [RecipeController::class, 'rate'])->name('recipes.rate');
    Route::post('/recipe/addComment/{recipe}', [CommentController::class, 'addComment'])->name('comment.add');
    Route::post('comments/like', [CommentController::class,'commentsLike']) -> name("posts.comment.like");
    Route::post('comments/disLike', [CommentController::class,'commentsdisLike']) -> name("posts.comment.dislike");

});
require __DIR__.'/auth.php';
