<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        // $department = Department::all();
        // $doctor = $department->doctor;
        // return $doctor;
        return Department::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'doctor_id' => 'required|exists:doctors,id',
            'description' => 'required|string',
            'name' => 'required|string'
            ]);
        
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401 );
        }
            
        $department= Department::create($request->all());
        return response()->json([
                "message" => "Successfully created department!",
                "data"=> $department
            ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        return $department;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'doctor_id' => 'required|exists:doctors,id',
            'description' => 'required|string',
            'name' => 'required|string'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
    
        $department = Department::findOrFail($id);
        $department->update($request->all());
    
        return response()->json([
            "message" => "department updated successfully!",
            "data" => $department
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        // Delete the department
        $department->delete();

        // Additional logic if needed

        return response()->json(['message' => 'Department deleted successfully'], 200);
    }
}
