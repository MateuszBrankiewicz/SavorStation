<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Recipe extends Model
{
    use HasAttributes;
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'description', 'instructions', 'image_path'];

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

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
