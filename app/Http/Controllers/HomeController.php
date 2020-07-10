<?php

namespace App\Http\Controllers;
use App\Category;
use App\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // public function index()
    // {
    //     $categories = Category::all();
    //     $posts = Post::latest()->approved()->published()->take(6)->paginate(6);
    //     return view('welcome',compact('categories','posts'));
    // }
    public function index(Request $request)
    {
     if($request->ajax() || 'NULL'){
        $categories = Category::all();
        $posts = Post::latest()->approved()->published()->paginate(6);
        return view('welcome',compact('categories','posts'));
    }
}
}
