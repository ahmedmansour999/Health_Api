<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class patient extends Model
{
    use HasFactory , HasApiTokens;
    protected $fillable = [
        'name',
        'email',
        'password',
        'gender',
        'age',
        'number',
        'is_admin',
        'address',
        'image',
    ];


    public function  appointments(){

        return $this->hasMany(Appointment::class) ;

    }

    public function  patientcheckups(){

        return $this->hasMany(patientcheckups::class) ;

    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
