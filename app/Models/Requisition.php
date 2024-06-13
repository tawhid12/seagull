<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requisition extends Model
{
    use HasFactory;
    public function company(){
        return $this->belongsTo(Company::class);
    }
    public function order(){
        return $this->belongsTo(Order::class);
    }
    public function requisition_detl(){
        return $this->hasMany(RequisitionDetail::class);
    }
    public function posted_by(){
        return $this->belongsTo(User::class,'created_by','id');
    }
    public function approved(){
        return $this->belongsTo(User::class,'approved_by','id');
    }
}
