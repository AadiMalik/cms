<?php

namespace App\Services\Concrete;

use App\Repository\Repository;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class CustomerService
{
    // initialize protected model variables
    protected $model_customer;

    public function __construct()
    {
        // set the model
        $this->model_customer = new Repository(new Customer);
    }

    public function getCustomerSource()
    {
        $model = $this->model_customer->getModel()::with('account_name')->where('is_deleted', 0);

        $data = DataTables::of($model)
            ->addColumn('account', function ($item) {
                $name = $item->account_name->name ?? '';
                $code = $item->account_name->code ?? '';
                return $code . ' ' . $name;
            })
            ->addColumn('status', function ($item) {
                if ($item->is_active == 1) {
                    $status = '<label class="switch pr-5 switch-primary mr-3"><input type="checkbox" checked="checked" id="status" data-id="' . $item->id . '"><span class="slider"></span></label>';
                } else {
                    $status = '<label class="switch pr-5 switch-primary mr-3"><input type="checkbox" id="status" data-id="' . $item->id . '"><span class="slider"></span></label>';
                }
                return $status;
            })

            ->addColumn('action', function ($item) {
                $action_column = '';
                $edit_column    = "<a class='text-success mr-2' href='customers/edit/" . $item->id . "'><i title='Add' class='nav-icon mr-2 fa fa-edit'></i>Edit</a>";
                // $view_column    = "<a class='text-warning mr-2' href='customers/view/" . $item->id . "'><i title='Add' class='nav-icon mr-2 fa fa-eye'></i>View</a>";
                $delete_column    = "<a class='text-danger mr-2' id='deleteCustomer' href='javascript:void(0)' data-toggle='tooltip'  data-id='" . $item->id . "' data-original-title='Delete'><i title='Delete' class='nav-icon mr-2 fa fa-trash'></i>Delete</a>";

                if (Auth::user()->can('customers_edit'))
                    $action_column .= $edit_column;


                if (Auth::user()->can('customers_delete'))
                    $action_column .= $delete_column;

                return $action_column;
            })
            ->rawColumns(['account', 'status', 'action'])
            ->make(true);
        return $data;
    }

    public function getAllActiveCustomer()
    {
        return $this->model_customer->getModel()::with('account_name')
            ->where('is_deleted', 0)
            ->where('is_active', 1)
            ->get();
    }

    public function save($obj)
    {
        if ($obj['id'] != null && $obj['id'] != '') {
            $obj['updatedby_id'] = Auth::user()->id;
            $this->model_customer->update($obj, $obj['id']);
            $saved_obj = $this->model_customer->find($obj['id']);
        } else {
            $obj['createdby_id'] = Auth::user()->id;
            $saved_obj = $this->model_customer->create($obj);
        }

        if (!$saved_obj)
            return false;

        return true;
    }

    public function getById($id)
    {
        return $this->model_customer->getModel()::find($id);
    }

    public function statusById($id)
    {
        $customer = $this->model_customer->getModel()::find($id);
        if ($customer->is_active == 0) {
            $customer->is_active = 1;
        } else {
            $customer->is_active = 0;
        }
        $customer->updatedby_id = Auth::user()->id;
        $customer->update();

        if ($customer)
            return true;

        return false;
    }

    public function deleteById($id)
    {
        $customer = $this->model_customer->getModel()::find($id);
        $customer->is_deleted = 1;
        $customer->deletedby_id = Auth::user()->id;
        $customer->update();

        if ($customer)
            return true;

        return false;
    }
}