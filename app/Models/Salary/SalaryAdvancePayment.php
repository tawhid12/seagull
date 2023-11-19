<?php

namespace App\Models\Salary;
use App\Models\Employee\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryAdvancePayment extends Model
{
    use HasFactory;
    public function employee(){
        return $this->belongsTo(Employee::class);
    }
}
