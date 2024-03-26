<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\patient;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;


class AppointmentController extends Controller
{

    function __construct(){
        $this->middleware("auth:sanctum");
    }

    public function index()
    {
        $appointments = Appointment::with(['doctor', 'patient'])->get();

        return response()->json(['appointments' => $appointments], 200);
    }


    public function getAppointmentsForDoctor($user_id)
    {
        // Get the doctor associated with the provided user_id
        $doctor = Doctor::where('user_id', $user_id)->first();

        // Check if a doctor with the given user_id exists
        if (!$doctor) {
            return response()->json(['message' => 'Doctor not found for the given user_id'], 404);
        }

        // Retrieve the doctor's id
        $doctorId = $doctor->id;

        // Retrieve appointments for the doctor with the retrieved doctorId
        $appointments = Appointment::with(['doctor', 'patient'])->where('doctor_id', $doctorId)->get();

        return response()->json(['appointments' => $appointments], 200);
    }


    public function getAppointmentStatus($user_id, $status)
    {
        $doctor = Doctor::where('user_id', $user_id)->first();

        if (!$doctor) {
            return response()->json(['message' => 'Doctor not found for the given user_id'], 404);
        }

        $doctorId = $doctor->id;
        $appointments = Appointment::with(['doctor', 'patient'])
                                   ->where('doctor_id', $doctorId)
                                   ->where('status', $status)
                                   ->get();

        return response()->json(['appointments' => $appointments], 200);
    }



    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'doctor_id' => 'required|exists:doctors,id',
            'patient_id' => 'required|exists:users,id',
            'date' => 'required',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string|max:255',
            'prescription' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $patient = patient::where('user_id',$request->patient_id)->first();
        $request['patient_id'] = $patient->id ;
        $appointment = Appointment::create($request->all());
        return response()->json([
            "message" => "Successfully created appointment!",
            "data" => $appointment
        ], 201);
    }


    public function show(Appointment $appointment)
    {
        $appointmentData = $appointment->load(['doctor', 'patient']);

        return response()->json(['appointment' => $appointmentData], 200);
    }



    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'doctor_id' => 'required|exists:doctors,id',
            'patient_id' => 'required|exists:patients,id',

            'date' => 'required',
            // 'date' => 'required|date|after_or_equal:today|unique:appointments,date,' . $id,

            'price' => 'required|numeric|min:0',
            'description' => 'required|string|max:255',
            'prescription' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        Payment::create([
            'name_on_card' => 'test',
            'card_number'=>'123456',
            'cvc'=>'123',
            'expiry_month'=>'123',
            'expiry_year'=>'02/25'
        ]);
        $appointment = Appointment::findOrFail($id);
        $appointment->update($request->all());

        return response()->json([
            "message" => "Appointment updated successfully!",
            "data" => $appointment
        ], 200);
    }

    public function updateAppointmentStatus($appointmentId, Request $request)
    {
        $appointment = Appointment::find($appointmentId);
        if (!$appointment) {
            return response()->json(['error' => 'Appointment not found'], 404);
        }

        $newStatus = $request->input('status');
        $appointment->status = $newStatus;
        $appointment->save();

        return response()->json(['message' => 'Appointment status updated successfully'], 200);
    }



    public function destroy(Appointment $appointment)
    {
        //
        $appointment->delete();
        return response()->json([
            "message" => "Appointment Deleted successfully!"
        ], 200);
    }
}
