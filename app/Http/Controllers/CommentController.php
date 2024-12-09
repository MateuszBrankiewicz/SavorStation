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
    public function ajaxLike(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $comment = Comment::find($request->id);
        $response = $user->toggleLikeDislike($comment->id, $request->like);
    error_log($comment->likes);
        return response()->json(['success' => $response]);
    }
}
