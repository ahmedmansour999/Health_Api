<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
  
    public function index()
    {
        $patients = Patient::all();
        return response()->json(['patients' => $patients]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'address' => 'nullable|string',
            'gender' => 'nullable|string',
            'age' => 'nullable|string',
            'bloodgroup' => 'nullable|string',
        ]);

        $patient = Patient::create($request->all());

        return response()->json(['patient' => $patient], 201);
    }


    public function show(Patient $patient)
    {
        return response()->json(['patient' => $patient]);
    }


    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'address' => 'nullable|string',
            'gender' => 'nullable|string',
            'age' => 'nullable|string',
            'bloodgroup' => 'nullable|string',
    
        ]);

        $patient->update($request->all());

        return response()->json(['patient' => $patient], 200);
    }

  
    public function destroy(Patient $patient)
    {
        $patient->delete();

        return response()->json(['message' => 'Patient deleted successfully'], 200);
    }
}
