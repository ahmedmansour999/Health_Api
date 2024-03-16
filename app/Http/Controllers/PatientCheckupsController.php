<?php

namespace App\Http\Controllers;

use App\Models\PatientCheckups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PatientCheckupsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PatientCheckups::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'doctor_id' => 'required|exists:doctors,id',
            'status' => 'required|string',
            'patient_id' => 'required|exists:patients,id'
            ]);
        
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401 );
        }
            
        $patientChekups= PatientCheckups::create($request->all());
        return response()->json([
                "message" => "Successfully created patient Chekup!",
                "data"=> $patientChekups
            ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(PatientCheckups $patientCheckups)
    {
        return $patientCheckups;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'doctor_id' => 'required|exists:doctors,id',
            'status' => 'required|string',
            'patient_id' => 'required|exists:patients,id',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
    
        $patientCheckups = PatientCheckups::findOrFail($id);
        $patientCheckups->update($request->all());
    
        return response()->json([
            "message" => "patient Checkup updated successfully!",
            "data" => $patientCheckups
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PatientCheckups $patientCheckups)
    {
        $patientCheckups->delete();
        return response()->json([
            "message" => "patient checkup Deleted successfully!"
        ],200);
    }
}
