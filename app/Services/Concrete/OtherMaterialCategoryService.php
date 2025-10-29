<?php

namespace App\Services\Concrete;

use App\Models\OtherMaterialCategory;
use App\Repository\Repository;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class OtherMaterialCategoryService
{
      protected $model_other_material_category;
      public function __construct()
      {
            // set the model
            $this->model_other_material_category = new Repository(new OtherMaterialCategory);
      }
      //Bead type
      public function getSource()
      {
            $model = $this->model_other_material_category->getModel()::where('is_deleted', 0);
            $data = DataTables::of($model)
                  ->addColumn('status', function ($item) {
                        if (Auth::user()->can('other_material_category_status')) {
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
                        $edit_column    = "<a class='text-success mr-2' id='editOtherMaterialCategory' href='javascript:void(0)' data-toggle='tooltip'  data-id='" . $item->id . "' data-original-title='Edit'><i title='Add' class='nav-icon mr-2 fa fa-edit'></i>Edit</a>";
                        $delete_column    = "<a class='text-danger mr-2' id='deleteOtherMaterialCategory' href='javascript:void(0)' data-toggle='tooltip'  data-id='" . $item->id . "' data-original-title='delete'><i title='Delete' class='nav-icon mr-2 fa fa-trash'></i>Delete</a>";
                        if (Auth::user()->can('other_material_category_edit'))
                              $action_column .= $edit_column;
                        if (Auth::user()->can('other_material_category_delete'))
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
            return $this->model_other_material_category->getModel()::where('is_deleted', 0)->where('is_active', 1)->get();
      }
      // save
      public function save($obj)
      {

            $obj['createdby_id'] = Auth::User()->id;

            $saved_obj = $this->model_other_material_category->create($obj);

            if (!$saved_obj)
                  return false;

            return $saved_obj;
      }

      // update
      public function update($obj)
      {

            $obj['updatedby_id'] = Auth::User()->id;
            $this->model_other_material_category->update($obj, $obj['id']);
            $saved_obj = $this->model_other_material_category->find($obj['id']);

            if (!$saved_obj)
                  return false;

            return $saved_obj;
      }

      // get by id
      public function getById($id)
      {
            $other_material_category = $this->model_other_material_category->getModel()::find($id);

            if (!$other_material_category)
                  return false;

            return $other_material_category;
      }
      // status by id
      public function statusById($id)
      {
            $other_material_category = $this->model_other_material_category->getModel()::find($id);
            if ($other_material_category->is_active == 0) {
                  $other_material_category->is_active = 1;
            } else {
                  $other_material_category->is_active = 0;
            }
            $other_material_category->updatedby_id = Auth::user()->id;
            $other_material_category->update();

            if ($other_material_category)
                  return true;

            return false;
      }
      // delete by id
      public function deleteById($id)
      {
            $other_material_category = $this->model_other_material_category->getModel()::find($id);
            $other_material_category->is_deleted = 1;
            $other_material_category->deletedby_id = Auth::user()->id;
            $other_material_category->update();

            if (!$other_material_category)
                  return false;

            return $other_material_category;
      }
}
