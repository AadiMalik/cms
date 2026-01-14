<?php

namespace App\Services\Concrete\HRM;

use App\Models\Attendance;
use App\Models\LeaveBalance;
use App\Models\LeaveRequest;
use App\Repository\Repository;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class LeaveRequestService
{
    protected $model_leave_request;
    public function __construct()
    {
        // set the model
        $this->model_leave_request = new Repository(new LeaveRequest);
    }
    //Bead type
    public function getSource()
    {
        $model = $this->model_leave_request->getModel()::query();
        $data = DataTables::of($model)
            ->addColumn('employee', function ($item) {
                return $item->employee->name ?? '';
            })
            ->addColumn('leave_type', function ($item) {
                return $item->leave_type->name ?? '';
            })
            ->addColumn('status', function ($item) {

                // Final states → only badge (no dropdown)
                if (in_array($item->status, ['Approved', 'Rejected'])) {

                    $class = $item->status == 'Approved' ? 'badge-success' : 'badge-danger';

                    return '<span class="badge ' . $class . '">' . $item->status . '</span>';
                }

                // Pending → dropdown allowed
                return '
                    <select class="form-control form-control-sm change-status"
                        data-id="' . $item->id . '">
                        <option value="Pending" selected disabled>Pending</option>
                        <option value="Approved">Approved</option>
                        <option value="Rejected">Rejected</option>
                    </select>';
            })

            ->addColumn('action', function ($item) {
                $action_column = '';
                $edit_column    = "<a class='text-success mr-2' href='leave-requests/edit/" . $item->id . "'><i title='Add' class='nav-icon mr-2 fa fa-edit'></i>Edit</a>";
                if (Auth::user()->can('leave_request_edit') && $item->status == 'Pending')
                    $action_column .= $edit_column;

                return $action_column;
            })
            ->addIndexColumn()
            ->rawColumns(['employee', 'leave_type', 'status', 'action'])
            ->make(true);
        return $data;
    }
    // get all
    public function getAllActive()
    {
        return $this->model_leave_request->getModel()::where('is_deleted', 0)->where('is_active', 1)->get();
    }
    // save
    public function save($obj)
    {

        $obj['createdby_id'] = Auth::User()->id;
        $from = Carbon::parse($obj['from_date']);
        $to   = Carbon::parse($obj['to_date']);
        $days = $from->diffInDays($to) + 1;
        $obj['no_of_days'] = $days;
        $obj['status'] = 'Pending';
        $saved_obj = $this->model_leave_request->create($obj);

        if (!$saved_obj)
            return false;

        return $saved_obj;
    }

    // update
    public function update($obj)
    {
        $obj['updatedby_id'] = Auth::User()->id;
        $from = Carbon::parse($obj['from_date']);
        $to   = Carbon::parse($obj['to_date']);
        $days = $from->diffInDays($to) + 1;
        $obj['no_of_days'] = $days;
        $obj['status'] = 'Pending';
        $this->model_leave_request->update($obj, $obj['id']);
        $saved_obj = $this->model_leave_request->find($obj['id']);

        if (!$saved_obj)
            return false;

        return $saved_obj;
    }

    // get by id
    public function getById($id)
    {
        $leave_request = $this->model_leave_request->getModel()::find($id);

        if (!$leave_request)
            return false;

        return $leave_request;
    }
    // status by id
    public function status($obj)
    {
        $leave_request = $this->model_leave_request->getModel()::find($obj['id']);
        if ($obj['status'] == 'Approved') {
            $this->updateLeaveBalance($obj['id'], $leave_request->no_of_days);
            $this->createAttendanceForLeave($leave_request);
        }
        $leave_request->status = $obj['status'];
        $leave_request->updatedby_id = Auth::user()->id;
        $leave_request->update();

        if ($leave_request)
            return true;

        return false;
    }

    public function updateLeaveBalance($id, $days)
    {
        $leave_request = $this->model_leave_request->getModel()::with('leave_type')->find($id);
        if ($leave_request->leave_type->is_paid) {
            $balance = LeaveBalance::where([
                'employee_id' => $leave_request->employee_id,
                'leave_type_id' => $leave_request->leave_type->id,
                'year' => now()->year
            ])->firstOrFail();

            $balance->used += $leave_request->no_of_days;
            $balance->remaining -= $leave_request->no_of_days;
            $balance->updatedby_id = Auth::user()->id;
            $balance->save();
        }
    }
    public function createAttendanceForLeave($leave_request)
    {
        $period = CarbonPeriod::create($leave_request->from_date, $leave_request->to_date);

        foreach ($period as $date) {

            Attendance::updateOrCreate(
                [
                    'employee_id'     => $leave_request->employee_id,
                    'attendance_date' => $date->format('Y-m-d'),
                ],
                [
                    'status'     => 'Leave',
                    'leave_type_id' => $leave_request->leave_type_id,
                    'entry_type' => 'auto',
                    'createdby_id' => Auth::user()->id
                ]
            );
        }
    }
}
