<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function add($post)
    {
        $user = Auth::user();
        $isFavorite = $user->favorite_posts()->where('post_id',$post)->count();

        if ($isFavorite == 0)
        {
            $user->favorite_posts()->attach($post);
            \Session::flash('toastr',[
        	'type' => 'success',
        	'message' => 'Bạn đã yêu thích tin này'
        ]);

            return redirect()->back();
        } else {
            $user->favorite_posts()->detach($post);
            \Session::flash('toastr',[
        	'type' => 'success',
        	'message' => 'Bạn đã bỏ yêu thích tin này'
        ]);
            return redirect()->back();
        }
    }
}
