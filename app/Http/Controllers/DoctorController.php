<?php
namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DoctorController extends Controller
{

    public function index()
    {
        $doctors = Doctor::all();
        foreach($doctors as $doctor){
             $doctor->department ;
             $doctor->freetime;
             $doctor->appointments ;
        }
        return response()->json(['doctors' => $doctors], 200);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'specialty' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        // if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();

            $imagePath = $request->image->move(public_path('images'), $imageName);



          $data['image'] = "images/".$imageName;

        $doctor = Doctor::create($data);
        $doctor->save();
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($doctor->image) {
                Storage::disk('public')->delete($doctor->image);
            }

            $imagePath = $request->file('image')->store('doctor_images', 'public');
            $data['image'] = $imagePath;
        }

        $doctor->update($data);
        return response()->json(['doctor' => $doctor], 200);
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return response()->json(null, 204);
    }

}
