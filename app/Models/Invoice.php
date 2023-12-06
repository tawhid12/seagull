<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    public function company(){
        return $this->belongsTo(Company::class);
    }
    public function client(){
        return $this->belongsTo(Client::class);
    }
    public function vessel(){
        return $this->belongsTo(Vessel::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
