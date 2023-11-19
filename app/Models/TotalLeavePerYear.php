<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TotalLeavePerYear extends Model
{
    use HasFactory;
    public function leave_type(){
        return $this->belongsTo(LeaveType::class);
    }
}
