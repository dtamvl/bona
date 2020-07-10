<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request,$post)
    {
        $this->validate($request,[
            'comment' => 'required'
        ]);

        $comment = new Comment();
        $comment->post_id = $post;
        $comment->user_id = Auth::id();
        $comment->comment = $request->comment;
        $comment->save();
        \Session::flash('toastr',[
        	'type' => 'success',
        	'message' => 'Bạn đã bình luận thành công'
        ]);
        return redirect()->back();
    }
}
