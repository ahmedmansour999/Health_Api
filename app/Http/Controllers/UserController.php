<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\patient;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function __construct(){
        $this->middleware("auth:sanctum");
    }

    public function index()
    {
        $users = User::all();
        $usersWithDetails = [];

        foreach ($users as $user) {
            if ($user->role === 'doctor') {
                $data = $user->doctor;
            } elseif ($user->role === 'patient') {
                $date = $user->patient; // Assuming patient details are stored in a separate table

            } else {
                $data = $user ;
            }
        }

        return response()->json(['users' => $data], 200);
    }

    public function store(CreateUserRequest $request)
    {
        $validatedData = $request->validated();

        // $validatedData['password'] = Hash::make($validatedData['password']);

        $user = User::create($validatedData);

        return response()->json(['message' => 'User created successfully', 'user' => $user], 200);

    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json(['user' => $user], 200);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $validatedData = $request->validated();

        if ($request->has('password')) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        $user->update($validatedData);
        return response()->json(['message' => 'User updated successfully'], 200);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}
