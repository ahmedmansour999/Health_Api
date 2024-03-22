<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $guarded = [
        
    ];


    // retlation one to many with Doctor

    public function doctor(){

        return $this->belongsTo(Doctor::class);

    }


    // retlation one to many with patient

    public function patient(){

        return $this->belongsTo(Patient::class);

    }
}
