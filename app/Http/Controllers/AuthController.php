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
    public function createUser(Request $request){
    try {
        $validateUser = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'gender' => 'required',
            'age' => 'required|integer',
            'number' => 'required|integer',
            'address' => 'required|string',
            'is_admin' => 'required'
        ]);

        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validateUser->errors()
            ], 422);
        }

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
            'age' => $request->age,
            'number' => $request->number,
            'address' => $request->address,
        ];


        if ($request->is_admin === "doctor" || $request->is_admin === "patient") {
            $userData['is_admin'] = $request->is_admin;
            // Create user
            $user = User::create($userData);

            // Optionally, you can also create a Doctor or Patient record here based on is_admin value
            if ($request->is_admin === "doctor") {
                Doctor::create($userData+['department_id'=>$request->department_id]);
            } elseif ($request->is_admin === "patient") {
                Patient::create($userData);
            }

            return response()->json([
                'status' => true,
                'message' => 'successfully',
                'token' => $user->createToken("token")->plainTextToken,
                'id' => $user->id ,
            ], 201); // Use 201 Created status for successful creation
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Invalid user type'
            ], 422);
        }
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
                'id' => $user->id
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
