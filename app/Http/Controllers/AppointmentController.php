<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;


class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Appointment::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'doctor_id' => 'required|exists:doctors,id',
            'patient_id' => 'required|exists:patients,id',
            'date' => 'required|date|after_or_equal:today|unique:appointments,date',
            'price' => 'required|numeric|min:0'
            ]);
        
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401 );
        }
            
        $appointment= Appointment::create($request->all());
        return response()->json([
                "message" => "Successfully created appointment!",
                "data"=> $appointment
            ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        //
        return $appointment;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'doctor_id' => 'required|exists:doctors,id',
            'patient_id' => 'required|exists:patients,id',
            'date' => 'required|date|after_or_equal:today|unique:appointments,date,'.$id,
            'price' => 'required|numeric|min:0'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
    
        $appointment = Appointment::findOrFail($id);
        $appointment->update($request->all());
    
        return response()->json([
            "message" => "Appointment updated successfully!",
            "data" => $appointment
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        //
        $appointment->delete();
        return response()->json([
            "message" => "Appointment Deleted successfully!"
        ],200);
    }
}
