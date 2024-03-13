<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    public function  comments(){

        return $this->hasMany(Comment::class) ;

    }
    public function  appointments(){

        return $this->hasMany(Appointment::class) ;

    }



}