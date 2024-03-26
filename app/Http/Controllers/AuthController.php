<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function createUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
                'gender' => 'required',
                'age' => 'required|integer',
                'number' => 'required',
                'address' => 'required|string',
                'is_admin' => 'required|in:doctor,patient', // Ensure is_admin is either 'doctor' or 'patient'
            ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validateUser->errors()
                ], 422);
            }

            // Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'is_admin' => $request->is_admin,
            ]);

            // Optionally, create a Doctor or Patient record based on is_admin value
            if ($request->is_admin === 'doctor') {
                Doctor::create([
                    'id' => $user->id ,
                    'user_id' => $user->id, // Assign the user_id to the created user's id
                    'name' => $request->name,
                    'email' => $request->email,
                    'gender' => $request->gender,
                    'age' => $request->age,
                    'number' => $request->number,
                    'address' => $request->address,
                    'password' => Hash::make($request->password),
                    'department_id' => $request->department_id,
                    // Add other doctor-specific fields here
                ]);
            } elseif ($request->is_admin === 'patient') {

                Patient::create([
                    'id' => $user->id ,
                    'user_id' => $user->id, // Assign the user_id to the created user's id
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'gender' => $request->gender,
                    'age' => $request->age,
                    'number' => $request->number,
                    'address' => $request->address,
                    // Add other patient-specific fields here
                ]);
            }

            return response()->json([
                'status' => true,
                'message' => 'Successfully registered',
                'token' => $user->createToken('token')->plainTextToken,
                'id' => $user->id,
            ], 201); // Use 201 Created status for successful creation
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
            [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if(!Auth::attempt($request->only(['email', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'status' => true,
                'message' => 'Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken,
                'id' => $user->id,
                'is_admin'=>$user->is_admin,
                'name' => $user->name,
                'email' => $user->email
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

//     public function logout(Request $request){
//             $user = Auth::guard('sanctum')->user();
//             $token = $request->header("token");
//             if($token !== null){
//               $user=   User::where( "token","=" , $token )->first();

//               if($user !== null){
//                 $user->update([
//                     "token"=>null
//                 ]);
//                 return response("you logged out successfully", 200);

//               }else{
//                 return response("token not correct", 404);

//               }
//             }else{
//                 return response("token not founded", 404);

//             }

// }

    // public function logout(Request $request)
    // {
    //     try {
    //         // Retrieve the authenticated user
    //         $user = Auth::user();


    //         $user->tokens()->delete();

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Logged out successfully'
    //         ], 200);
    //     } catch (\Throwable $th) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Failed to logout: ' . $th->getMessage()
    //         ], 500);
    //     }
    // }



}
