<?php

namespace App\Services\Concrete\HRM;

use App\Models\LeaveBalance;
use App\Repository\Repository;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class LeaveBalanceService
{
    protected $model_leave_balance;
    public function __construct()
    {
        // set the model
        $this->model_leave_balance = new Repository(new LeaveBalance);
    }
    //Bead type
    public function getSource($obj)
    {
        $model = $this->model_leave_balance->getModel()::with(['leave_type','employee'])->orderBy('id', 'DESC');
        if(isset($obj['employee_id']) && $obj['employee_id'] != null) $model = $model->where('employee_id', $obj['employee_id']);
        $data = DataTables::of($model)
            ->addColumn('employee', function ($item) {
                return $item->employee->name ?? '';
            })
            ->addColumn('leave_type', function ($item) {
                return $item->leave_type->name ?? '';
            })
            ->addIndexColumn()
            ->rawColumns(['employee', 'leave_type'])
            ->make(true);
        return $data;
    }

}
