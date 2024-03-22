<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;

class PaymenttController extends Controller
{
    
    public function index()
    {
        return Payment::all();
    }

    public function show($id)
    {
        return Payment::find($id);
    }

    public function store(Request $request)
    {
        $payment = Payment::create($request->all());
        return response()->json($payment, 201);
    }

    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        $payment->update($request->all());
        return response()->json($payment, 200);
    }

    public function destroy($id)
    {
        Payment::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
