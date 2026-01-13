<?php

namespace App\Http\Controllers;

use App\Services\Concrete\EmployeeService;
use App\Services\Concrete\HRM\AttendanceService;
use App\Traits\JsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller
{
    use JsonResponse;
    protected $attendance_service;
    protected $employee_service;

    public function __construct(
        AttendanceService $attendance_service,
        EmployeeService $employee_service
    ) {
        $this->attendance_service = $attendance_service;
        $this->employee_service = $employee_service;
    }

    public function index()
    {
        abort_if(Gate::denies('attendance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $employees = $this->employee_service->getAllActiveEmployee();
        return view('HRM.attendance.index', compact('employees'));
    }

    public function getData(Request $request)
    {
        abort_if(Gate::denies('attendance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            return $this->attendance_service->getSource($request->all());
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('attendance_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $validation = Validator::make(
            $request->all(),
            [
                'employee_id' => 'required|exists:employees,id',
                'attendance_date' => 'required|date',
                'check_in' => 'required',
                'check_out' => 'required',
                'status' => 'required|in:Present,Absent,Late,Leave',
            ],
            $this->validationMessage()
        );

        if ($validation->fails()) {
            $validation_error = "";
            foreach ($validation->errors()->all() as $message) {
                $validation_error .= $message;
            }
            return $this->validationResponse(
                $validation_error
            );
        }
        try {
            if (isset($request->id)) {
                $obj = [
                    'id' => $request->id,
                    'employee_id' => $request->employee_id,
                    'attendance_date' => $request->attendance_date,
                    'check_in' => $request->check_in,
                    'check_out' => $request->check_out,
                    'status' => $request->status,
                    'note' => $request->note ?? '',
                    'entry_type' => 'manual'
                ];
                $response = $this->attendance_service->update($obj);
                return  $this->success(
                    config("enum.updated"),
                    $response
                );
            } else {
                $obj = [
                    'employee_id' => $request->employee_id,
                    'attendance_date' => $request->attendance_date,
                    'check_in' => $request->check_in,
                    'check_out' => $request->check_out,
                    'status' => $request->status,
                    'note' => $request->note ?? '',
                    'entry_type' => 'manual'
                ];
                $response = $this->attendance_service->save($obj);
                return  $this->success(
                    config("enum.saved"),
                    $response
                );
            }
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    public function edit($id)
    {
        abort_if(Gate::denies('attendance_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            return  $this->success(
                config('enum.success'),
                $this->attendance_service->getById($id),
                false
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    public function status($id)
    {
        abort_if(Gate::denies('attendance_status'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $attendance = $this->attendance_service->statusById($id);
            return $this->success(
                config("enum.status"),
                $attendance,
                true
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    public function destroy($id)
    {
        abort_if(Gate::denies('attendance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $attendance = $this->attendance_service->deleteById($id);
            return $this->success(
                config("enum.delete"),
                $attendance,
                true
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }
}
