<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
   
    public function index()
    {
        $doctors = Doctor::all();
        return response()->json(['doctors' => $doctors]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'specialization' => 'required|string',
            'hospital' => 'required|string',
            'location' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'age' => 'required|string',
            'gender' => 'required|string',
            'bio' => 'required|string',
            'image' => 'required|string',
            'facebook' => 'nullable|string',
        ]);

        $doctor = Doctor::create($request->all());

        return response()->json(['message' => 'Doctor created successfully','doctor' => $doctor], 201);
    }


    public function show(Doctor $doctor)
    {
        return response()->json(['doctor' => $doctor]);
    }

 
    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'specialization' => 'required|string',
            'hospital' => 'required|string',
            'location' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'age' => 'required|string',
            'gender' => 'required|string',
            'bio' => 'required|string',
            'image' => 'required|string',
            'certificates' => 'nullable|json',
            'facebook' => 'nullable|string',
        ]);

        $doctor->update($request->all());

        return response()->json(['doctor' => $doctor], 200);
    }

 
    public function destroy(Doctor $doctor)
    {
        $doctor->delete();

        return response()->json(['message' => 'Doctor deleted successfully'], 200);
    }
}
