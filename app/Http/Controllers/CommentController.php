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


     public function index(Request $request)
     {
         $doctorId = $request->input('doctor_id');

         // Assuming you have a Comment model and relationships defined between comments, doctors, and users
         $comments = Comment::with(['doctor', 'user'])
                     ->whereHas('doctor', function ($query) use ($doctorId) {
                         $query->where('id', $doctorId);
                     })
                     ->get();

         return response()->json(['data' => $comments]);
     }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'comment' => 'required | min:2 ' ,
            'doctor_id' => 'required|exists:doctors,id',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([ 'state' => 401 , 'error' => $validator->errors()->all()  ], 401);
        }

        $comment = Comment::create($request->all()) ;
        // $comment->user_id = Auth()->user()->id ;
        return response()->json([ 'state' => "Created Successful" , 'data' => $comment  ], 201);
    }



    public function show(Comment $comment)
    {
        return response()->json([ 'state' => "success" , 'data' => $comment  ], 200);

    }



    public function update(Request $request, Comment $comment)
    {
        $validator = Validator::make($request->all(), [
            'comment' => 'required | min:2 ',
            'doctor_id' => 'required|exists:doctors,id',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([ 'state' => 401 , 'error' => $validator->errors()->all()  ], 401);
        }
        $comment->update($request->all()) ;
        // $comment->user_id = Auth()->user()->id ;
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
