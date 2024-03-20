<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Freetime extends Model
{
    use HasFactory;
    public function doctor(){
        $this->belongsTo(Doctor::class) ;
    }
}
