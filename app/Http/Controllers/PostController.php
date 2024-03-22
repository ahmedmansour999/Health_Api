<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        return response()->json(['data' => $posts], 201);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'hint' => 'string',
            'body' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $data = $request->all();


        $imageName = time().'.'.$request->image->extension();
        $imagePath = $request->image->move(public_path('images'), $imageName);
        $data['image'] = "images/".$imageName;

        $post = Post::create($data);
       
        $post->save();



        return response()->json(['post' => $post], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return response()->json(['data' => $post], 201);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string',
            'hint' => 'required|string',
            'body' => 'required|string',
            'image' => 'required|image|max:2048',
        ]);



        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('images'), $imageName);

        $post->title = $request->title;
        $post->hint = $request->hint;
        $post->body = $request->body;
        $post->image = $imageName;
        $post->save();

        return response()->json(['post' => $post], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(null, 204);
    }
}
