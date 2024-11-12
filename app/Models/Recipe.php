<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
protected $fillable = ['user_id', 'title', 'description', 'instructions'];

public function user()
{
return $this->belongsTo(User::class);
}

public function ingredients()
{
return $this->belongsToMany(Ingredient::class, 'recipe_ingredients')->withPivot('amount');
}

public function comments()
{
return $this->hasMany(Comment::class);
}
}
