<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::all() ;
        return CommentResource::collection($comments) ;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'comment' => 'required | min:2 '
        ]);

        if ($validator->fails()) {
            return response()->json([ 'state' => 401 , 'error' => $validator->errors()->all()  ], 401);
        }

        $comment = Comment::create($request->all()) ;
        // $comment->patient_id = Auth()->user()->id ;
        return response()->json([ 'state' => "Created Successful" , 'data' => $comment  ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        return response()->json([ 'state' => "success" , 'data' => $comment  ], 200);

    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $validator = Validator::make($request->all(), [
            'comment' => 'required | min:2 '
        ]);

        if ($validator->fails()) {
            return response()->json([ 'state' => 401 , 'error' => $validator->errors()->all()  ], 401);
        }
        $comment->update($request->all()) ;
        // $comment->patient_id = Auth()->user()->id ;
        return response()->json([ 'state' => "Updated Successfull" , 'data' => $comment  ] , 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete() ;
        return response()->json(["status" => 200 , 'message' => "Deleted Successfully"] , 200 ) ;
    }

}
