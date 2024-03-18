<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
  
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


    public function store(Request $request)
    {
                // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'specialty' => 'required|string|max:255',
        //     // Add validation rules for other fields
        // ]);

        $patient = patient::create($request->all());
        return response()->json(['doctor' => $patient], 201);
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
