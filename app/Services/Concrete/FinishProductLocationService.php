<?php

namespace App\Services\Concrete;

use App\Models\FinishProductLocation;
use App\Repository\Repository;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class FinishProductLocationService
{
      protected $model;
      public function __construct()
      {
            // set the model
            $this->model = new Repository(new FinishProductLocation);
      }
      //Bead type
      public function getSource()
      {
            $model = $this->model->getModel()::where('is_deleted', 0);
            $data = DataTables::of($model)
                  ->addColumn('status', function ($item) {
                        if (Auth::user()->can('tagging_location_status')) {
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
                        $edit_column    = "<a class='text-success mr-2' id='editFinishProductlocation' href='javascript:void(0)' data-toggle='tooltip'  data-id='" . $item->id . "' data-original-title='Edit'><i title='Add' class='nav-icon mr-2 fa fa-edit'></i>Edit</a>";
                        $delete_column    = "<a class='text-danger mr-2' id='deleteFinishProductlocation' href='javascript:void(0)' data-toggle='tooltip'  data-id='" . $item->id . "' data-original-title='delete'><i title='Delete' class='nav-icon mr-2 fa fa-trash'></i>Delete</a>";
                        if (Auth::user()->can('tagging_location_edit'))
                              $action_column .= $edit_column;
                        if (Auth::user()->can('tagging_location_delete'))
                              $action_column .= $delete_column;

                        return $action_column;
                  })
                  ->rawColumns(['status', 'action'])
                  ->make(true);
            return $data;
      }
      // get all
      public function getAllActive()
      {
            return $this->model->getModel()::where('is_deleted', 0)->where('is_active', 1)->get();
      }
      // save
      public function save($obj)
      {

            $obj['createdby_id'] = Auth::User()->id;

            $saved_obj = $this->model->create($obj);

            if (!$saved_obj)
                  return false;

            return $saved_obj;
      }

      // update
      public function update($obj)
      {

            $obj['updatedby_id'] = Auth::User()->id;
            $this->model->update($obj, $obj['id']);
            $saved_obj = $this->model->find($obj['id']);

            if (!$saved_obj)
                  return false;

            return $saved_obj;
      }

      // get by id
      public function getById($id)
      {
            $finish_product_location = $this->model->getModel()::find($id);

            if (!$finish_product_location)
                  return false;

            return $finish_product_location;
      }
      // status by id
      public function statusById($id)
      {
            $finish_product_location = $this->model->getModel()::find($id);
            if ($finish_product_location->is_active == 0) {
                  $finish_product_location->is_active = 1;
            } else {
                  $finish_product_location->is_active = 0;
            }
            $finish_product_location->updatedby_id = Auth::user()->id;
            $finish_product_location->update();

            if ($finish_product_location)
                  return true;

            return false;
      }
      // delete by id
      public function deleteById($id)
      {
            $finish_product_location = $this->model->getModel()::find($id);
            $finish_product_location->is_deleted = 1;
            $finish_product_location->deletedby_id = Auth::user()->id;
            $finish_product_location->update();

            if (!$finish_product_location)
                  return false;

            return $finish_product_location;
      }
}
