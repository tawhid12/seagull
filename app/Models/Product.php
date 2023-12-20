<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public  function category(){
        return $this->belongsTo(Category::class);
    }
    public  function pro_type(){
        return $this->belongsTo(ProductType::class);
    }
}
