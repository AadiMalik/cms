<?php

namespace App\Services\Concrete\HRM;

use App\Models\Attendance;
use App\Repository\Repository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class AttendanceService
{
    protected $model_attendance;
    public function __construct()
    {
        // set the model
        $this->model_attendance = new Repository(new Attendance);
    }
    //Bead type
    public function getSource()
    {
        $model = $this->model_attendance->getModel()::where('is_deleted', 0);
        $data = DataTables::of($model)
            ->addColumn('duration', function ($item) {

                if (!$item->check_in || !$item->check_out) {
                    return '00:00';
                }

                $checkIn  = Carbon::createFromFormat('H:i:s', $item->check_in);
                $checkOut = Carbon::createFromFormat('H:i:s', $item->check_out);

                // Overnight shift handling
                if ($checkOut->lt($checkIn)) {
                    $checkOut->addDay();
                }

                $minutes = $checkIn->diffInMinutes($checkOut);

                $hours   = floor($minutes / 60);
                $mins    = $minutes % 60;

                return sprintf('%02d:%02d', $hours, $mins);
            })
            ->addColumn('employee', function ($item) {
                return $item->employee->name;
            })
            ->addColumn('action', function ($item) {
                $action_column = '';
                $edit_column    = "<a class='text-success mr-2' id='editAttendance' href='javascript:void(0)' data-toggle='tooltip'  data-id='" . $item->id . "' data-original-title='Edit'><i title='Add' class='nav-icon mr-2 fa fa-edit'></i>Edit</a>";
                $delete_column    = "<a class='text-danger mr-2' id='deleteAttendance' href='javascript:void(0)' data-toggle='tooltip'  data-id='" . $item->id . "' data-original-title='delete'><i title='Delete' class='nav-icon mr-2 fa fa-trash'></i>Delete</a>";
                if (Auth::user()->can('attendance_edit'))
                    $action_column .= $edit_column;
                if (Auth::user()->can('attendance_delete'))
                    $action_column .= $delete_column;

                return $action_column;
            })
            ->rawColumns(['duration','employee', 'action'])
            ->make(true);
        return $data;
    }
    // save
    public function save($obj)
    {

        $obj['createdby_id'] = Auth::User()->id;

        $saved_obj = $this->model_attendance->create($obj);

        if (!$saved_obj)
            return false;

        return $saved_obj;
    }

    // update
    public function update($obj)
    {

        $obj['updatedby_id'] = Auth::User()->id;
        $this->model_attendance->update($obj, $obj['id']);
        $saved_obj = $this->model_attendance->find($obj['id']);

        if (!$saved_obj)
            return false;

        return $saved_obj;
    }

    // get by id
    public function getById($id)
    {
        $attendance = $this->model_attendance->getModel()::find($id);

        if (!$attendance)
            return false;

        return $attendance;
    }
    // status by id
    public function statusById($id)
    {
        $attendance = $this->model_attendance->getModel()::find($id);
        if ($attendance->is_active == 0) {
            $attendance->is_active = 1;
        } else {
            $attendance->is_active = 0;
        }
        $attendance->updatedby_id = Auth::user()->id;
        $attendance->update();

        if ($attendance)
            return true;

        return false;
    }
    // delete by id
    public function deleteById($id)
    {
        $attendance = $this->model_attendance->getModel()::find($id);
        $attendance->is_deleted = 1;
        $attendance->deletedby_id = Auth::user()->id;
        $attendance->update();

        if (!$attendance)
            return false;

        return $attendance;
    }
}
