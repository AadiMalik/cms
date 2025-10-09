<?php

namespace App\Services\Concrete;

use App\Models\Retainer;
use App\Repository\Repository;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class RetainerService
{
      protected $model_retainer;
      public function __construct()
      {
            // set the model
            $this->model_retainer = new Repository(new Retainer);
      }
      //Other Product
      public function getSource()
      {
            $model = $this->model_retainer->getModel()::with([
                  'journal',
                  'debit_account',
                  'credit_account',
                  'jv',
                  'created_by'
            ])->orderBy('created_at', 'DESC')->get();
            $data = DataTables::of($model)
                  ->addColumn('is_active', function ($item) {
                        // if (Auth::user()->can('retainer_status')) {
                        if ($item->is_active == 1) {
                              $status = '<label class="switch pr-5 switch-primary mr-3"><input type="checkbox" checked="checked" id="status" data-id="' . $item->id . '"><span class="slider"></span></label>';
                        } else {
                              $status = '<label class="switch pr-5 switch-primary mr-3"><input type="checkbox" id="status" data-id="' . $item->id . '"><span class="slider"></span></label>';
                        }
                        return $status;
                        // } else {
                        //       return 'N/A';
                        // }
                  })
                  ->addColumn('status', function ($item) {
                        $dropdown = '<select id="status" style="width:150px;" class="form-control" data-id="' . $item->id . '">';
                        if ($item->status == 'pending') {
                              $dropdown .= '<option value="pending" selected>Pending</option>';
                              $dropdown .= '<option value="confirmed">Confirmed</option>';
                        } else {
                              $dropdown .= '<option value="pending">Pending</option>';
                              $dropdown .= '<option value="confirmed" selected>Confirmed</option>';
                        }
                        $dropdown .= '</select>';
                        return $dropdown;
                  })
                  ->addColumn('currency', function ($item) {
                        return $item->currency == 0 ? 'PKR' : ($item->currency == 1 ? 'Gold (AU)' : 'Dollar ($)');
                  })
                  ->addColumn('journal', function ($item) {
                        return $item->journal->name ?? '';
                  })
                  ->addColumn('debit_account', function ($item) {
                        return $item->debit_account->name ?? '';
                  })
                  ->addColumn('credit_account', function ($item) {
                        return $item->credit_account->name ?? '';
                  })
                  ->addColumn('jv', function ($item) {
                        return $item->jv->entryNum ?? '';
                  })
                  ->addColumn('created_by', function ($item) {
                        return $item->created_by->name ?? '';
                  })
                  ->addColumn('created_at', function ($item) {
                        return $item->created_at->format('d-m-Y g:i A');
                  })
                  ->addColumn('action', function ($item) {
                        $action_column = '';
                        // $edit_column    = "<a class='text-success mr-2' id='editRetainer' href='javascript:void(0)' data-toggle='tooltip'  data-id='" . $item->id . "' data-original-title='Edit'><i title='Add' class='nav-icon mr-2 fa fa-edit'></i>Edit</a>";
                        $delete_column    = "<a class='text-danger mr-2' id='deleteRetainer' href='javascript:void(0)' data-toggle='tooltip'  data-id='" . $item->id . "' data-original-title='delete'><i title='Delete' class='nav-icon mr-2 fa fa-trash'></i>Delete</a>";
                        // if (Auth::user()->can('retainer_edit'))
                        //       $action_column .= $edit_column;
                        // if (Auth::user()->can('retainer_delete'))
                        $action_column .= $delete_column;

                        return $action_column;
                  })
                  ->rawColumns([
                        'is_active',
                        'created_at',
                        'currency',
                        'journal',
                        'debit_account',
                        'credit_account',
                        'jv',
                        'created_by',
                        'action',
                        'status'
                  ])
                  ->make(true);
            return $data;
      }
      // save 
      public function save($obj)
      {

            $obj['createdby_id'] = Auth::User()->id;

            $saved_obj = $this->model_retainer->create($obj);

            if (!$saved_obj)
                  return false;

            return $saved_obj;
      }

      // update
      public function update($obj)
      {

            $obj['updatedby_id'] = Auth::User()->id;
            $this->model_retainer->update($obj, $obj['id']);
            $saved_obj = $this->model_retainer->find($obj['id']);

            if (!$saved_obj)
                  return false;

            return $saved_obj;
      }

      // get by id
      public function getById($id)
      {
            $retainer = $this->model_retainer->getModel()::find($id);

            if (!$retainer)
                  return false;

            return $retainer;
      }
      // status by id
      public function activeById($id)
      {
            $retainer = $this->model_retainer->getModel()::find($id);
            if ($retainer->is_active == 0) {
                  $retainer->is_active = 1;
            } else {
                  $retainer->is_active = 0;
            }
            $retainer->updatedby_id = Auth::user()->id;
            $retainer->update();

            if ($retainer)
                  return true;

            return false;
      }
      // delete by id
      public function deleteById($id)
      {
            $retainer = $this->model_retainer->getModel()::find($id);
            $retainer->delete();

            if (!$retainer)
                  return false;

            return $retainer;
      }

      //status change
      public function status($obj)
      {
            $retainer = $this->model_retainer->getModel()::find($obj['id']);
            $retainer->status = $obj['status'];
            $retainer->update();
            return true;
      }
}
