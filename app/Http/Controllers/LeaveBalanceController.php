<?php

namespace App\Http\Controllers;

use App\Services\Concrete\EmployeeService;
use App\Services\Concrete\HRM\LeaveBalanceService;
use App\Traits\JsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class LeaveBalanceController extends Controller
{
    use JsonResponse;
    protected $leave_balance_service;
    protected $employee_service;
    protected $leave_type_service;

    public function __construct(
        LeaveBalanceService $leave_balance_service,
        EmployeeService $employee_service
    ) {
        $this->leave_balance_service = $leave_balance_service;
        $this->employee_service = $employee_service;
    }
    public function index()
    {
        abort_if(Gate::denies('leave_balance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $employees = $this->employee_service->getAllActiveEmployee();
        return view('HRM.leave_balance.index',compact('employees'));
    }

    public function getData(Request $request)
    {
        abort_if(Gate::denies('leave_balance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $data = $request->all();
            return $this->leave_balance_service->getSource($data);
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }
}
