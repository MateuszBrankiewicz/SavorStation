<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Laravel\Scout\Searchable;

class Recipe extends Model
{
    use HasAttributes;
    use HasFactory;
  
    protected $fillable = ['user_id', 'title', 'description', 'instructions', 'image_path','category_id','make_time'
];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ingredients()
    {
    
        return $this->belongsToMany(Ingredient::class, 'recipe_ingredients', 'recipe_id', 'ingredient_id')
            ->withPivot('amount', 'unity')
            ->withTimestamps();
    }
    public function recipeCategory(){
        return $this -> belongsTo(RecipeCategory::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function getAuthorId($recipeId){
        $recipe = Recipe::where('id',$recipeId) ->get();
        return $recipe -> user_id;
    }
    public function category()
    {
        return $this->belongsTo(RecipeCategory::class);
    }
}
