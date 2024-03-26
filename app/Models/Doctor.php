<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Doctor extends Model
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
        'department_id',
        'image',
        'user_id'
    ];
    public function  comments(){

        return $this->hasMany(Comment::class) ;

    }
    public function  appointments(){

        return $this->hasMany(Appointment::class) ;

    }
    public function  patientcheckups(){

        return $this->hasMany(patientcheckups::class) ;

    }

    public function department(){

        return $this->belongsTo(Department::class);

    }

    public function user(){
        $this->belongsTo(User::class) ;
    }

}
