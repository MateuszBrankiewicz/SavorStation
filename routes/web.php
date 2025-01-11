<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RecipeIngredientsController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\SearchQuery;
use Illuminate\Support\Facades\Route;
Route::get('/recipes/search/', [SearchQuery::class, 'index'])->name('recipes.search');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile Routes
Route::prefix('profile')->middleware('auth')->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Recipe Routes
Route::prefix('recipes')->group(function () {
    Route::get('/', [RecipeController::class, 'index'])->name('recipes.index');
    Route::get('/create', [RecipeController::class, 'create'])->middleware(['auth'])->name('recipes.create');
    Route::post('/', [RecipeController::class, 'store'])->middleware(['auth'])->name('recipes.store');
    Route::post('/{recipe}/rate', [RecipeController::class, 'rate'])->middleware(['auth'])->name('recipes.rate');
    Route::get('/{id}/edit', [RecipeController::class, 'showEdit'])->middleware(['auth'])->name('recipes.showEdit');
    Route::put('/{id}', [RecipeController::class, 'update'])->middleware(['auth'])->name('recipes.update');
    Route::get('/{recipe}', [RecipeIngredientsController::class, 'index'])->name('recipes.show');
    Route::get('/category/{categoryId}', [RecipeController::class, 'searchCategory'])->name('search.category');
    Route::delete('/{id}', [RecipeController::class, 'delete'])->name('recipes.delete');
});

// Additional Recipe Features
Route::get('/addRecipe', function () {
    return view('recipes.add_recipe');
})->middleware(['auth', 'verified'])->name('add_recipe');

// Favorite Routes
Route::prefix('favorites')->middleware(['auth'])->group(function () {
    Route::post('/{id}', [RecipeController::class, 'addFavorite'])->name('add.favorite');
    Route::get('/{id}', [FavoriteController::class, 'getUserRecipes'])->name('get.favorites');
});

// User Recipes
Route::prefix('userRecipes')->middleware(['auth'])->group(function () {
    Route::get('/{id}', [RecipeController::class, 'getUserRecipes'])->name('get.userRecipes');
});

// Comment Routes
Route::prefix('comments')->middleware(['auth'])->group(function () {
    Route::post('/add/{recipe}', [CommentController::class, 'addComment'])->name('comment.add');
    Route::post('/like', [CommentController::class, 'commentsLike'])->name('posts.comment.like');
    Route::post('/dislike', [CommentController::class, 'commentsdisLike'])->name('posts.comment.dislike');
});
Route::post('/filter/recipes/', [SearchQuery::class, 'filter']) ->name('search.filter');
// Search Routes

require __DIR__ . '/auth.php';
