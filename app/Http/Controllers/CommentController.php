<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    public function addComment($recipe, Request $request){
        error_log("weszło");
        $request -> validate(
            ['content' => 'required|string']
        );
       $comment = new Comment();
       $comment -> recipe_id = $recipe;
       $comment -> user_id = Auth::user() -> id;
       $comment -> content = $request['content'];
        $comment->save();
        return redirect()->back()->with('success', 'Comment added successfully!');

    }

public function commentsLike(Request $request)
{
    $comment = Comment::find($request->comment_id);
    $user = auth()->user();

   
    if ($user->hasLiked($comment->id)) {
        $user->unlike($comment->id);
    } else {
        $user->like($comment->id);
    }

    return back(); 
}

public function commentsDislike(Request $request)
{
    $comment = Comment::find($request->comment_id);
    $user = auth()->user();

   
    if ($user->hasDisliked($comment->id)) {
        $user->unlike($comment->id);
    } else {
        $user->dislike($comment->id);
    }

    return back(); 
}

}
