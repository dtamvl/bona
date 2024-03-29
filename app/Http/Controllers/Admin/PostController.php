<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Post;
use App\Category;
use App\Tag;
use App\Subscriber;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AuthorPostApproved;
use App\Notifications\NewPostNotify;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::where('is_approved',true)->latest()->get();
        return view('admin.post.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.post.create',compact('categories','tags'));
    }

    public function pending()
    {
        $posts = Post::where('is_approved',false)->get();
        return view('admin.post.pending',compact('posts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => 'required',
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'description' => 'required',
            'categories' => 'required',
            'tags' => 'required',
            'body' => 'required',
        ],
        [
            'title.require'  => 'Tiêu đề không được để trống',
            'image.mimes'  => 'Vui lòng chọn đúng định dạng ảnh (jpg,png,jpeg,gif,svg)',
            'image.image'  => 'File tải lên không phải định dạng ảnh',
            'image.max'  => 'Dung lượng ảnh không được quá 2Mb'
        ]);
        $image = $request->file('image');
        $slug = Str::slug($request->title);
        if(isset($image))
        {
//            make unipue name for image
            $currentDate = Carbon::now()->toDateString();
            $imageName  = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();

            if(!Storage::disk('public')->exists('post'))
            {
                Storage::disk('public')->makeDirectory('post');
            }

            $postImage = Image::make($image)->resize(1600,1066)->stream();
            Storage::disk('public')->put('post/'.$imageName,$postImage);

        } else {
            $imageName = "default.png";
        }
        $post = new Post();
        $post->user_id = Auth::id();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->slug = $slug;
        $post->image = $imageName;
        $post->body = $request->body;
        if(isset($request->status))
        {
            $post->status = true;
        }else {
            $post->status = false;
        }
        $post->is_approved = true;
        $post->save();

        $post->categories()->attach($request->categories);
        $post->tags()->attach($request->tags);

        $subscribers = Subscriber::all();
        foreach ($subscribers as $subscriber)
        {
            Notification::route('mail',$subscriber->email)
            ->notify(new NewPostNotify($post));
        }

        return redirect()->back()->with('success','Post created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
       return view('admin.post.show',compact('post'));
   }

   public function active($id)
   {
    $post = Post::find($id);
    $post->status = !$post->status;
    $post->save();
    return redirect()->back();
}

public function approve($id)
{
        // $post = Post::find($id);
        // $post->is_approved = !$post->is_approved;
        // $post->save();
        // return redirect()->back();
        // 
   $post = Post::find($id);
   if ($post->is_approved == false)
   {
    $post->is_approved = true;
    $post->save();
    $post->user->notify(new AuthorPostApproved($post));

    $subscribers = Subscriber::all();
    foreach ($subscribers as $subscriber)
    {
        Notification::route('mail',$subscriber->email)
        ->notify(new NewPostNotify($post));
    }

            // Toastr::success('Post Successfully Approved :)','Success');
} else {
            // Toastr::info('This Post is already approved','Info');
    $post->is_approved = false;
    $post->save();
}
return redirect()->back();
}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.post.edit',compact('post','categories','tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
         $this->validate($request,[
            'title' => 'required',
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'description' => 'required',
            'categories' => 'required',
            'tags' => 'required',
            'body' => 'required',
        ],
        [
            'title.require'  => 'Tiêu đề không được để trống',
            'image.mimes'  => 'Vui lòng chọn đúng định dạng ảnh (jpg,png,jpeg,gif,svg)',
            'image.image'  => 'File tải lên không phải định dạng ảnh',
            'image.max'  => 'Dung lượng ảnh không được quá 2Mb'
        ]);
        $image = $request->file('image');
        $slug = Str::slug($request->title);
        if(isset($image))
        {
//            make unipue name for image
            $currentDate = Carbon::now()->toDateString();
            $imageName  = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();

            if(!Storage::disk('public')->exists('post'))
            {
                Storage::disk('public')->makeDirectory('post');
            }
//            delete old post image
            if(Storage::disk('public')->exists('post/'.$post->image))
            {
                Storage::disk('public')->delete('post/'.$post->image);
            }
            $postImage = Image::make($image)->resize(1600,1066)->stream();
            Storage::disk('public')->put('post/'.$imageName,$postImage);

        } else {
            $imageName = $post->image;
        }

        $post->user_id = Auth::id();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->slug = $slug;
        $post->image = $imageName;
        $post->body = $request->body;
        if(isset($request->status))
        {
            $post->status = true;
        }else {
            $post->status = false;
        }
        $post->is_approved = true;
        $post->save();

        $post->categories()->sync($request->categories);
        $post->tags()->sync($request->tags);

        return redirect()->route('admin.post.index')->with('success','Post updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
       if (Storage::disk('public')->exists('post/'.$post->image))
       {
        Storage::disk('public')->delete('post/'.$post->image);
    }
    $post->categories()->detach();
    $post->tags()->detach();
    $post->delete();
    return redirect()->back();
}
}
