<?php

namespace App\Services\Concrete\HRM;

use App\Models\LeaveType;
use App\Repository\Repository;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class LeaveTypeService
{
      protected $model_leave_type;
      public function __construct()
      {
            // set the model
            $this->model_leave_type = new Repository(new LeaveType);
      }
      //Bead type
      public function getSource()
      {
            $model = $this->model_leave_type->getModel()::where('is_deleted', 0);
            $data = DataTables::of($model)
                  ->addColumn('is_paid', function ($item) {
                        if ($item->is_paid == 1) {
                              $is_paid = '<span class="badge badge-success">Paid</span>';
                        } else {
                              $is_paid = '<span class="badge badge-danger">Unpaid</span>';
                        }
                        return $is_paid;
                  })
                  ->addColumn('status', function ($item) {
                        if (Auth::user()->can('leave_type_status')) {
                              if ($item->is_active == 1) {
                                    $status = '<label class="switch pr-5 switch-primary mr-3"><input type="checkbox" checked="checked" id="status" data-id="' . $item->id . '"><span class="slider"></span></label>';
                              } else {
                                    $status = '<label class="switch pr-5 switch-primary mr-3"><input type="checkbox" id="status" data-id="' . $item->id . '"><span class="slider"></span></label>';
                              }
                              return $status;
                        } else {
                              return 'N/A';
                        }
                  })
                  ->addColumn('action', function ($item) {
                        $action_column = '';
                        $edit_column    = "<a class='text-success mr-2' id='editLeaveType' href='javascript:void(0)' data-toggle='tooltip'  data-id='" . $item->id . "' data-original-title='Edit'><i title='Add' class='nav-icon mr-2 fa fa-edit'></i>Edit</a>";
                        $delete_column    = "<a class='text-danger mr-2' id='deleteLeaveType' href='javascript:void(0)' data-toggle='tooltip'  data-id='" . $item->id . "' data-original-title='delete'><i title='Delete' class='nav-icon mr-2 fa fa-trash'></i>Delete</a>";
                        if (Auth::user()->can('leave_type_edit'))
                              $action_column .= $edit_column;
                        if (Auth::user()->can('leave_type_delete'))
                              $action_column .= $delete_column;

                        return $action_column;
                  })
                  ->rawColumns(['is_paid','status', 'action'])
                  ->make(true);
            return $data;
      }
      // get all
      public function getAllActive()
      {
            return $this->model_leave_type->getModel()::where('is_deleted', 0)->where('is_active', 1)->get();
      }
      // save
      public function save($obj)
      {

            $obj['createdby_id'] = Auth::User()->id;

            $saved_obj = $this->model_leave_type->create($obj);

            if (!$saved_obj)
                  return false;

            return $saved_obj;
      }

      // update
      public function update($obj)
      {

            $obj['updatedby_id'] = Auth::User()->id;
            $this->model_leave_type->update($obj, $obj['id']);
            $saved_obj = $this->model_leave_type->find($obj['id']);

            if (!$saved_obj)
                  return false;

            return $saved_obj;
      }

      // get by id
      public function getById($id)
      {
            $leave_type = $this->model_leave_type->getModel()::find($id);

            if (!$leave_type)
                  return false;

            return $leave_type;
      }
      // status by id
      public function statusById($id)
      {
            $leave_type = $this->model_leave_type->getModel()::find($id);
            if ($leave_type->is_active == 0) {
                  $leave_type->is_active = 1;
            } else {
                  $leave_type->is_active = 0;
            }
            $leave_type->updatedby_id = Auth::user()->id;
            $leave_type->update();

            if ($leave_type)
                  return true;

            return false;
      }
      // delete by id
      public function deleteById($id)
      {
            $leave_type = $this->model_leave_type->getModel()::find($id);
            $leave_type->is_deleted = 1;
            $leave_type->deletedby_id = Auth::user()->id;
            $leave_type->update();

            if (!$leave_type)
                  return false;

            return $leave_type;
      }
}
