<?php

namespace App\Http\Controllers\Admin;
use App\Category;
use App\Post;
use App\Tag;
use App\User;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
	public function index()
	{
		

		$posts = Post::all();
		$popular_posts = Post::withCount('comments')
		->withCount('favorite_to_users')
		->orderBy('view_count','desc')
		->orderBy('comments_count','desc')
		->orderBy('favorite_to_users_count','desc')
		->take(5)->get();
		$total_pending_posts = Post::where('is_approved',false)->count();
		$all_views = Post::sum('view_count');
		$author_count = User::where('role_id',2)->count();
		$new_authors_today = User::where('role_id',2)
		->whereDate('created_at',Carbon::today())->count();
		$new_authors_month = User::where('role_id',2)->whereDate('created_at', '>', date('Y-m-d', strtotime("-30 days")))->count();
		$active_authors = User::where('role_id',2)
		->withCount('posts')
		->withCount('comments')
		->withCount('favorite_posts')
		->orderBy('posts_count','desc')
		->orderBy('comments_count','desc')
		->orderBy('favorite_posts_count','desc')
		->take(10)->get();
		$category_count = Category::all()->count();
		$tag_count = Tag::all()->count();

		return view('admin.dashboard',compact('posts','popular_posts','total_pending_posts','all_views','author_count','new_authors_today','new_authors_month','active_authors','category_count','tag_count'));
	}
}
