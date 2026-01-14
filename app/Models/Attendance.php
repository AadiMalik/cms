<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'leave_type_id',
        'attendance_date',
        'check_in',
        'check_out',
        'status',
        'entry_type',
        'is_deleted',
        'createdby_id',
        'updatedby_id',
        'deletedby_id'
    ];

    public function leave_type()
    {
        return $this->belongsTo(LeaveType::class, 'leave_type_id');
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
