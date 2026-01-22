<?php

namespace App\Http\Controllers;

use App\ExcelExports\ReportExport;
use App\Services\Concrete\EmployeeService;
use App\Services\Concrete\HRM\DepartmentService;
use App\Services\Concrete\HRM\LeaveTypeService;
use App\Services\Concrete\HRM\ReportService;
use App\Traits\JsonResponse;
use PDF;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class HrmReportController extends Controller
{
    use JsonResponse;
    #region Class Fields & Propertities

    protected $report_service;
    protected $employee_service;
    protected $leave_type_service;
    protected $department_service;
    public function __construct(
        ReportService $report_service,
        EmployeeService  $employee_service,
        LeaveTypeService $leave_type_service,
        DepartmentService $department_service
    ) {
        $this->report_service = $report_service;
        $this->employee_service = $employee_service;
        $this->leave_type_service = $leave_type_service;
        $this->department_service = $department_service;
    }
    // employee leave Report
    public function employeeLeaveReport()
    {
        abort_if(Gate::denies('employee_leave_report_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $employees = $this->employee_service->getAllActiveEmployee();
            $leave_types = $this->leave_type_service->getAllActive();
            $departments = $this->department_service->getAllActive();
            return view('hrm/reports/employee_leave/index', compact('employees', 'leave_types', 'departments'));
        } catch (Exception $e) {
            return back()->with('error', config('enum.error'));
        }
    }
    public function getPreviewEmployeeLeaveReport(Request $request)
    {
        abort_if(Gate::denies('employee_leave_report_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $validation = Validator::make(
            $request->all(),
            [
                'start_date' => 'required',
                'end_date' => 'required',
            ]
        );
        if ($validation->fails()) {
            $validation_error = "";
            foreach ($validation->errors()->all() as $message) {
                $validation_error .= $message;
            }
            return $this->error(
                $validation_error
            );
        }
        // try {
        $obj = $request->all();
        $parms['data'] = $this->report_service->employeeLeaveReport($obj);
        $parms = (object)$parms;
        $parms->start_date = $request->start_date;
        $parms->end_date = $request->end_date;
        if ($request->employee_id != '' && $request->employee_id != null) {
            $employee = $this->employee_service->getById($request->employee_id);
            $parms->employee = $employee->name ?? '';
        }
        if ($request->department_id != '' && $request->department_id != null) {
            $department = $this->department_service->getById($request->department_id);
            $parms->department = $department->name ?? '';
        }
        if ($request->leave_type_id != '' && $request->leave_type_id != null) {
            $leave_type = $this->leave_type_service->getById($request->leave_type_id);
            $parms->leave_type = $leave_type->name ?? '';
        }
        $parms->report_name = "employee_leave_report";
        return view('/hrm/reports/employee_leave/partials.report', compact('parms'));
        // } catch (Exception $e) {
        //     return $this->error(config('enum.error'));
        // }
    }
    public function getEmployeeLeaveReport(Request $request)
    {
        abort_if(Gate::denies('employee_leave_report_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $obj = $request->all();
            $parms['data'] = $this->report_service->employeeLeaveReport($obj);
            $parms = (object)$parms;
            $parms->start_date = $request->start_date;
            $parms->end_date = $request->end_date;
            if ($request->employee_id != '' && $request->employee_id != null) {
                $employee = $this->employee_service->getById($request->employee_id);
                $parms->employee = $employee->name ?? '';
            }
            if ($request->department_id != '' && $request->department_id != null) {
                $department = $this->department_service->getById($request->department_id);
                $parms->department = $department->name ?? '';
            }
            if ($request->leave_type_id != '' && $request->leave_type_id != null) {
                $leave_type = $this->leave_type_service->getById($request->leave_type_id);
                $parms->leave_type = $leave_type->name ?? '';
            }
            $parms->report_name = "employee_leave_report";
            if ($request->has('export-excel')) {
                return Excel::download(new ReportExport($parms), 'Employee-Leave-Report.xls');
            }
            $pdf = PDF::loadView('/hrm/reports/employee_leave/partials.report', compact('parms'));
            return $pdf->stream('Employee Leave Report' . $request->start_date . '-' . $request->end_date . '.pdf');
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }
}
