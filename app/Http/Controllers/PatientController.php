<?php

namespace App\Http\Controllers;

use App\Models\patient;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $patients = patient::all() ;

        foreach($patients as $patient){
            $patient->comments ;
            $patient->appointments ;

            $patient->patientcheckups ;
            $patient->department ;
        }
        return response()->json(['patient' => $patients], 200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Assuming you're using authentication and have access to the authenticated user
        $user = $request->user();

        // Prepare data for patient creation
        $data = [
            'name' => $request->name,
            'image' => null, // Placeholder for image path
        ];

        // Handle image upload

            $imageName = time().'.'.$request->image->extension();
            $imagePath = $request->image->move(public_path('images'), $imageName);
            $data['image'] = "images/".$imageName;


        // If a user is authenticated, associate the patient with the user
        if ($user) {
            $data['user_id'] = $user->id;
        }

        // Create patient record
        $patient = Patient::create($data);

        $patient->save() ;
        return response()->json(['patient' => $patient], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(patient $patient)
    {
        $patient->comments ;
        $patient->appointments ;
        $patient->patientcheckups ;
        $patient->department ;

        return response()->json(['patient' => $patient], 200);


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, patient $patient)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'specialty' => 'required|string|max:255',
            // Add validation rules for other fields
        ]);

        $patient->update($request->all());
        return response()->json(['patient' => $patient], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(patient $patient)
    {
        $patient->delete();
        return response()->json(null, 204);
    }
}
