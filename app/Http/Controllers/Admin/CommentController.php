<?php

namespace App\Http\Controllers\Admin;
use App\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentController extends Controller
{
     public function index()
    {
        $comments = Comment::latest()->get();
        return view('admin.comments',compact('comments'));
    }

    public function destroy($id)
    {
        Comment::findOrFail($id)->delete();
        \Session::flash('toastr',[
        	'type' => 'success',
        	'message' => 'Comment Successfully Deleted'
        ]);
        return redirect()->back();
    }
}
