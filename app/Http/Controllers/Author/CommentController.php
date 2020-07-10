<?php

namespace App\Http\Controllers\Author;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
    public function index()
    {
        $posts = Auth::user()->posts;
        return view('author.comments',compact('posts'));
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        if ($comment->post->user->id == Auth::id())
        {
            $comment->delete();
            \Session::flash('toastr',[
                'type' => 'success',
                'message' => 'Comment Successfully Deleted'
            ]);
        } else {
            \Session::flash('toastr',[
                'type' => 'error',
                'message' => 'You are not authorized to delete this comment. Access denied.'
            ]);
        }
        return redirect()->back();
    }
}
