<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;

class CommentController extends Controller
{
    public function getComment($recipe)
    {
        // Pobierz wszystkie komentarze związane z danym przepisem
        $comments = Comment::where('recipe_id', $recipe->id)->get();
        // Dołącz informacje o użytkownikach dla każdego komentarza
        $commentsWithUsers = $comments->map(function ($comment) {
            $user = User::find($comment->user_id);

            return [
                'comment' => $comment,
                'user' => $user,
            ];
        });

        return $commentsWithUsers;
    }
}
