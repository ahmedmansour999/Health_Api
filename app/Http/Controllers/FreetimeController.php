<?php

namespace App\Http\Controllers;

use App\Models\Freetime;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FreetimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Freetime::all();
        // dd($data);
        return $data ;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'doctor_freetimes' => 'required',
            'doctor_freetimesto' => 'required',
            'days' => 'required',
        ]);


        $freetime = new Freetime();
        $freetime->user_id = $request->user_id;
        $freetime->doctor_freetimes = $validatedData['doctor_freetimes'];
        $freetime->doctor_freetimesto = $validatedData['doctor_freetimesto'];
        $freetime->days = $validatedData['days'];
        $freetime->save();

        return response()->json(['message' => 'Doctor Free Appointment time  created successfully', 'freetime' => $freetime], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Freetime $freetime)
    {
        return response()->json($freetime);
    }


    public function getFreetimesForDoctor($doctorId)
    {
        // Retrieve users with doctor details where doctor_id is equal to $doctorId
        $users = User::with('doctor')->whereHas('doctor', function ($query) use ($doctorId) {
            $query->where('user_id', $doctorId);
        })->get();

        // Initialize an array to store freetimes
        $freetimes = [];

        // Iterate over each user to get freetimes
        foreach ($users as $user) {
            // Get the user's id
            $userId = $user->id;

            // Retrieve freetimes for the user
            $userFreetimes = Freetime::where('user_id', $userId)->get();

            // Merge the user's freetimes into the main freetimes array
            $freetimes = array_merge($freetimes, $userFreetimes->toArray());
        }

        return response()->json(['freetimes' => $freetimes], 200);
    }


    public function getFreetimesForDoctorFront($doctorId)
    {
        // Retrieve users with doctor details where doctor_id is equal to $doctorId
        $users = User::with('doctor')->whereHas('doctor', function ($query) use ($doctorId) {
            $query->where('id', $doctorId);
        })->get();

        // Initialize an array to store freetimes
        $freetimes = [];

        // Iterate over each user to get freetimes
        foreach ($users as $user) {
            // Get the user's id
            $userId = $user->id;

            // Retrieve freetimes for the user
            $userFreetimes = Freetime::where('user_id', $userId)->get();

            // Merge the user's freetimes into the main freetimes array
            $freetimes = array_merge($freetimes, $userFreetimes->toArray());
        }

        return response()->json(['freetimes' => $freetimes], 200);
    }


    public function update(Request $request, Freetime $freetime)
    {
        $validatedData = $request->validate([
            'doctor_freetimes' => 'required|date_format:Y-m-d H:i:s',
        ]);

        // Update the freetime record
        $freetime->doctor_freetimes = $validatedData['doctor_freetimes'];
        $freetime->save();

        return response()->json(['message' => 'Doctor Free Appointment time updated successfully', 'freetime' => $freetime]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Freetime $freetime)
    {
        $freetime->delete();

        return response()->json(['message' => 'Doctor Free Appointment time deleted successfully'], 204);
    }
}
