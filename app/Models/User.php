<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
   
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    public function likes(){
        return $this->hasMany(Like::class);
    }
    public function hasLiked($comment_id){
        return $this->likes()->where('comment_id',$comment_id)->where('like',true)->exists();
    }
    public function hasDisLiked($comment_id){
        return $this->likes()->where('comment_id',$comment_id)->where('like',false)->exists();
    }
    public function toggleLikeDislike($comment_id, $like)
    {
        // Check if the like/dislike already exists
        $existingLike = $this->likes()->where('comment_id', $comment_id)->first();

        if ($existingLike) {
            if ($existingLike->like == $like) {
                $existingLike->delete();

                return [
                    'hasLiked' => false,
                    'hasDisliked' => false
                ];
            } else {
                $existingLike->update(['like' => $like]);
            }
        } else {
            $this->likes()->create([
                'comment_id' => $comment_id,
                'like' => $like,
            ]);
        }

        return [
            'hasLiked' => $this->hasLiked($comment_id),
            'hasDisliked' => $this->hasDisliked($comment_id)
        ];
    }
}
