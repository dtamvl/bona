<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
	public function index()
	{
		$posts = Auth::user()->favorite_posts;
		return view('admin.favorite',compact('posts'));
	}
}
