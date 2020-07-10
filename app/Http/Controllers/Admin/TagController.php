<?php

namespace App\Http\Controllers\Admin;
use App\Tag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AdminTagRequest;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::latest()->get();
        return view('admin.tag.index',compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tag.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminTagRequest $request)
    {
        // $tag = new Tag();
        // $tag->name = $request->name;
        // $tag->slug = Str::slug($request->name);
        // $tag->created_at =Carbon::now();
        // $tag->save();

        $data             = $request->except('_token');
        $data['slug']     = Str::slug($request->name);
        $data['created_at'] =Carbon::now();
        $id = Tag::insertGetId($data);
        return redirect()->back()->with('success','Tag created successfully!');
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
        $tag = Tag::find($id);
        return view('admin.tag.edit',compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminTagRequest $request, $id)
    {
        $tag = Tag::find($id);
        $data             = $request->except('_token');
        $data['slug']     = Str::slug($request->name);
        $data['updated_at'] =Carbon::now();
        $tag->update($data);
        return redirect()->route('admin.tag.index')->with('success','Tag updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       Tag::find($id)->delete();
       return redirect()->back()->with('success','Tag deleted successfully!');
   }
}

