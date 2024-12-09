<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Like extends Model
{
    protected $fillable = ['post_id', 'user_id', 'like'];

    public function post()
    {
        return $this->belongsTo(Comment::class);
    }

   
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
