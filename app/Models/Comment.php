<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['recipe_id', 'user_id', 'content'];

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function likes()
    {
        return $this->hasMany(Like::class)->where('like', true);
    }

  
    public function dislikes()
    {
        return $this->hasMany(Like::class)->where('like', false);
    }
}

