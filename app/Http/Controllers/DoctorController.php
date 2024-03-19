<?php
namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{

    public function index()
    {
        $doctors = Doctor::all();
        foreach($doctors as $doctor){
             $doctor->department ;
        }
        return response()->json(['doctors' => $doctors], 200);
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'specialty' => 'required|string|max:255',
        //     // Add validation rules for other fields
        // ]);

        $doctor = Doctor::create($request->all());
        return response()->json(['doctor' => $doctor], 201);

    }

    public function show(Doctor $doctor)
    {
        $doctor->department ;
        return response()->json(['doctor' => $doctor], 200);
    }

    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'specialty' => 'required|string|max:255',
            // Add validation rules for other fields
        ]);

        $doctor->update($request->all());
        return response()->json(['doctor' => $doctor], 200);
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return response()->json(null, 204);
    }

}
