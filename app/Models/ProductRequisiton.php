<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRequisiton extends Model
{
    use HasFactory;
    public function  product_requistion_details(){
        return $this->hasMany(ProductRequisitionDetails::class,'product_requisition_id','id');
    }
}
