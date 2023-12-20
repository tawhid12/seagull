<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vessel extends Model
{
    use HasFactory;
    public function company(){
        return $this->belongsTo(Company::class);
    }
    public function client(){
        return $this->belongsTo(Client::class);
    }
    public function vessel_category(){
        return $this->belongsTo(VesselCategory::class,'vessel_cat_id','id');
    }
}
