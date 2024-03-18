<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientCheckups extends Model
{
    use HasFactory;

    protected $fillable = ['doctor_id', 'status', 'patient_id'];

    public function doctor(){

        return $this->belongsTo(Doctor::class);

    }




    public function patient(){

        return $this->belongsTo(Patient::class);

    }
}
