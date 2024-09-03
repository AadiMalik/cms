<?php

namespace App\Services\Concrete;

use App\Repository\Repository;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;

class PermissionService
{
    // initialize protected model variables
    protected $model_permission;

    public function __construct()
    {
        // set the model
        $this->model_permission = new Repository(new Permission);
    }

    public function getAll(){
        return $this->model_permission->all();
    }

    public function getPermissionSource()
    {
        $model = Permission::get();
        $data = DataTables::of($model)
            ->addColumn('action', function ($item) {
                $action_column = '';
                $edit_column    = "<a class='text-success mr-2' href='permissions/edit/" . $item->id . "'><i title='Add' class='nav-icon mr-2 fa fa-edit'></i>Edit</a>";
                // $view_column    = "<a class='text-warning mr-2' href='permissions/view/" . $item->id . "'><i title='Add' class='nav-icon mr-2 fa fa-eye'></i>View</a>";
                // $print_column    = "<a class='text-info mr-2' href='permissions/print/" . $item->id . "'><i title='Add' class='nav-icon mr-2 fa fa-print'></i>Print</a>";
                // $delete_column    = "<a class='text-danger mr-2' href='permissions/destroy/" . $item->id . "'><i title='Delete' class='nav-icon mr-2 fa fa-trash'></i>Delete</a>";
                $action_column .= $edit_column;
                // $action_column .= $view_column;
                // $action_column .= $print_column;
                // $action_column .= $delete_column;

                return $action_column;
            })
            ->rawColumns(['action'])
            ->make(true);
        return $data;
    }

    public function save($obj)
    {
        if ($obj['id'] != null && $obj['id'] != '') {
            $this->model_permission->update($obj, $obj['id']);
            $saved_obj = $this->model_permission->find($obj['id']);
        } else {
            $saved_obj = $this->model_permission->create($obj);
        }

        if (!$saved_obj)
            return false;

        return $saved_obj;
    }

    public function getById($id)
    {
        return $this->model_permission->find($id);
    }
}
