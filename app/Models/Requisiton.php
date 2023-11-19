<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requisiton extends Model
{
    use HasFactory;
    public function client(){
        return $this->belongsTo(Client::class,'client_id','id');
    }
    public function vessel(){
        return $this->belongsTo(Vessel::class,'vessel_id','id');
    }
}
