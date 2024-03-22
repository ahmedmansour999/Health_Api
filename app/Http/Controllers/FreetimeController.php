<?php

namespace App\Http\Controllers;

use App\Models\Freetime;
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
            'doctor_freetimes' => 'required|date_format:Y-m-d H:i:s',
        ]);


        $freetime = new Freetime();
        $freetime->doctor_id = $request->doctor_id;
        $freetime->doctor_freetimes = $validatedData['doctor_freetimes'];
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
        $freetimes = Freetime::where('doctor_id', $doctorId)->get();
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
