<?php

namespace App\Http\Controllers;

use App\Services\Concrete\EmployeeService;
use App\Services\Concrete\HRM\LeaveRequestService;
use App\Services\Concrete\HRM\LeaveTypeService;
use App\Traits\JsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class LeaveRequestController extends Controller
{
    use JsonResponse;
    protected $leave_request_service;
    protected $employee_service;
    protected $leave_type_service;

    public function __construct(
        LeaveRequestService $leave_request_service,
        EmployeeService $employee_service,
        LeaveTypeService $leave_type_service
    ) {
        $this->leave_request_service = $leave_request_service;
        $this->employee_service = $employee_service;
        $this->leave_type_service = $leave_type_service;
    }

    public function index()
    {
        abort_if(Gate::denies('leave_request_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('HRM.leave_request.index');
    }

    public function getData()
    {
        abort_if(Gate::denies('leave_request_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            return $this->leave_request_service->getSource();
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    public function create()
    {
        abort_if(Gate::denies('leave_request_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $employees = $this->employee_service->getAllActiveEmployee();
        $leave_types = $this->leave_type_service->getAllActive();
        return view('HRM.leave_request.create', compact('employees', 'leave_types'));
    }
    public function store(Request $request)
    {
        abort_if(Gate::denies('leave_request_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $validator = Validator::make($request->all(), [
                'employee_id' => ['required','exists:employees,id'],
                'leave_type_id' => ['required','exists:leave_types,id'],
                'from_date' => ['required','date'],
                'to_date' => ['required','date'],
                'reason' => ['nullable'],
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            if (isset($request->id)) {
                $obj = [
                    'id' => $request->id,
                    'employee_id' => $request->employee_id,
                    'leave_type_id' => $request->leave_type_id,
                    'from_date' => $request->from_date,
                    'to_date' => $request->to_date,
                    'reason' => $request->reason
                ];
                $response = $this->leave_request_service->update($obj);
                if (!$response)
                    return redirect()->back()->with('error', config('enum.error'));
            } else {
                $obj = [
                    'employee_id' => $request->employee_id,
                    'leave_type_id' => $request->leave_type_id,
                    'from_date' => $request->from_date,
                    'to_date' => $request->to_date,
                    'reason' => $request->reason
                ];
                $response = $this->leave_request_service->save($obj);
                if (!$response)
                    return redirect()->back()->with('error', config('enum.error'));
            }
            return redirect('leave-requests')->with('success', config('enum.saved'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', config('enum.error'));
        }
    }

    public function edit($id)
    {
        abort_if(Gate::denies('leave_request_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $employees = $this->employee_service->getAllActiveEmployee();
            $leave_types = $this->leave_type_service->getAllActive();
            $leave_request = $this->leave_request_service->getById($id);
            return view('HRM.leave_request.create', compact('leave_request', 'employees', 'leave_types'));
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    public function status(Request $request)
    {
        abort_if(Gate::denies('leave_request_status'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $obj = $request->all();
            $leave_request = $this->leave_request_service->status($obj);
            return $this->success(
                config("enum.status"),
                $leave_request,
                true
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }
}
