<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Category;
use App\Http\Requests\AdminCategoryRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
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
            'name' => 'required|unique:categories',
            'image' => 'required|mimes:jpeg,bmp,png,jpg|max:2048'
        ],
        [
            'name.require'  => 'category name is not empty',
            'name.unique'  => 'category name is existed, please change another name',
            'image.require'  => 'image file is not empty',
            'image.mimes'  => 'please choose image format (jpeg,bmp,png,jpg)',
            'image.max'  => 'image is not larger than 2Mb'
        ]);
        // get form image
        $image = $request->file('image');
        $slug = Str::slug($request->name);
        if (isset($image))
        {
//            make unique name for image
            $currentDate = Carbon::now()->toDateString();
            $imagename = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
//            check category dir is exists
            if (!Storage::disk('public')->exists('category'))
            {
                Storage::disk('public')->makeDirectory('category');
            }
//            resize image for category and upload
            $category = Image::make($image)->resize(1600,479)->stream();
            Storage::disk('public')->put('category/'.$imagename,$category);

            //            check category slider dir is exists
            if (!Storage::disk('public')->exists('category/slider'))
            {
                Storage::disk('public')->makeDirectory('category/slider');
            }
            //            resize image for category slider and upload
            $slider = Image::make($image)->resize(500,333)->stream();
            Storage::disk('public')->put('category/slider/'.$imagename,$slider);

        } else {
            $imagename = "default.png";
        }

        $category = new Category();
        $category->name = $request->name;
        $category->slug = $slug;
        $category->image = $imagename;
        $category->save();
        return redirect()->back()->with('success','Category created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.category.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required',
            'image' => 'required|mimes:jpeg,bmp,png,jpg|max:2048'
        ],
        [
            'name.require'  => 'category name is not empty',
            'image.require'  => 'image file is not empty',
            'image.mimes'  => 'please choose image format (jpeg,bmp,png,jpg)',
            'image.max'  => 'image is not larger than 2Mb'
        ]);
        // get form image
        $image = $request->file('image');
        $slug = Str::slug($request->name);
        $category = Category::find($id);
        if (isset($image))
        {
//            make unique name for image
            $currentDate = Carbon::now()->toDateString();
            $imagename = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
//            check category dir is exists
            if (!Storage::disk('public')->exists('category'))
            {
                Storage::disk('public')->makeDirectory('category');
            }
//            delete old image
            if (Storage::disk('public')->exists('category/'.$category->image))
            {
                Storage::disk('public')->delete('category/'.$category->image);
            }
//            resize image for category and upload
            $categoryimage = Image::make($image)->resize(1600,479)->stream();
            Storage::disk('public')->put('category/'.$imagename,$categoryimage);

            //            check category slider dir is exists
            if (!Storage::disk('public')->exists('category/slider'))
            {
                Storage::disk('public')->makeDirectory('category/slider');
            }
            //            delete old slider image
            if (Storage::disk('public')->exists('category/slider/'.$category->image))
            {
                Storage::disk('public')->delete('category/slider/'.$category->image);
            }
            //            resize image for category slider and upload
            $slider = Image::make($image)->resize(500,333)->stream();
            Storage::disk('public')->put('category/slider/'.$imagename,$slider);

        } else {
            $imagename = $category->image;
        }

        $category->name = $request->name;
        $category->slug = $slug;
        $category->image = $imagename;
        $category->save();
        return redirect()->route('admin.category.index')->with('success','Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if (Storage::disk('public')->exists('category/'.$category->image))
        {
            Storage::disk('public')->delete('category/'.$category->image);
        }

        if (Storage::disk('public')->exists('category/slider/'.$category->image))
        {
            Storage::disk('public')->delete('category/slider/'.$category->image);
        }
        $category->delete();
        return redirect()->back()->with('success','Category deleted successfully!');
    }
}
