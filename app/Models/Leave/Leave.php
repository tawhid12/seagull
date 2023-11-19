<?php

namespace App\Models\Leave;

use App\Models\Employee\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\LeaveType;
class Leave extends Model
{
    use HasFactory;
    public function leave_type(){
        return $this->belongsTo(LeaveType::class);
    }
    public function employee(){
        return $this->belongsTo(Employee::class);
    }
}
