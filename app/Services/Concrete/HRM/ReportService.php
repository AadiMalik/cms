<?php

namespace App\Services\Concrete\HRM;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\LeaveBalance;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\User;
use App\Repository\Repository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportService
{
    protected $model_attendance;
    protected $model_leave_type;
    protected $model_leave_balance;
    protected $model_employee;
    protected $model_leave_request;
    protected $model_user;
    public function __construct()
    {
        // set the model
        $this->model_attendance = new Repository(new Attendance);
        $this->model_leave_type = new Repository(new LeaveType);
        $this->model_leave_balance = new Repository(new LeaveBalance);
        $this->model_employee = new Repository(new Employee);
        $this->model_leave_request = new Repository(new LeaveRequest);
        $this->model_user = new Repository(new User);
    }

    // Ledger Report
    public function employeeLeaveReport($obj)
    {
        $query = $this->model_leave_request->getModel()::with([
            'leave_type:id,name,is_paid',
            'employee:id,employee_id,name,department_id,designation_id',
            'employee.department:id,name',
            'employee.designation:id,name',
        ]);

        // Employee filter
        if (isset($obj['employee_id']) && $obj['employee_id']) {
            $query->where('employee_id', $obj['employee_id']);
        }

        // Department filter
        if (isset($obj['department_id']) && $obj['department_id']) {
            $query->whereHas('employee', function ($q) use ($obj) {
                $q->where('department_id', $obj['department_id']);
            });
        }

        // Leave Type filter
        if (isset($obj['leave_type_id']) && $obj['leave_type_id']) {
            $query->where('leave_type_id', $obj['leave_type_id']);
        }

        // Status filter
        if (isset($obj['status']) && $obj['status']) {
            $query->where('status', $obj['status']);
        }

        // Date Range filter
        if ($obj['start_date'] && $obj['end_date']) {
            $query->whereBetween('from_date', [
                $obj['start_date'],
                $obj['end_date']
            ]);
        }

        // Month filter
        if (isset($obj['month']) && $obj['month']) {
            $query->whereMonth('from_date', $obj['month']);
        }

        // Year filter
        if (isset($obj['year']) && $obj['year']) {
            $query->whereYear('from_date', $obj['year']);
        }

        $leaves = $query->orderBy('from_date', 'desc')->get();
        
        return $leaves;
    }
}
