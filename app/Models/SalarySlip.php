<?php

namespace App\Models;

use App\Models\Employee\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalarySlip extends Model
{
    use HasFactory;
    public function employee(){
        return $this->belongsTo(Employee::class);
    }
}
