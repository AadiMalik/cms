<?php

namespace App\Services\Concrete;

use App\Repository\Repository;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class RoleService
{
    // initialize protected model variables
    protected $model_role;

    public function __construct()
    {
        // set the model
        $this->model_role = new Repository(new Role());
    }


    public function getAll(){
        return $this->model_role->all();
    }

    public function getRoleSource()
    {
        $model = Role::get();
        $data = DataTables::of($model)
            ->addColumn('permissions', function ($item) {
                $collect = '';
                foreach ($item->permissions as $permission) {
                    $collect .= "<span class='btn-success pl-1 pr-1' style='border-radius: 8px;'>" . $permission->name . "</span> ";
                }
                return $collect;
            })
            ->addColumn('action', function ($item) {
                $action_column = '';
                $edit_column    = "<a class='text-success mr-2' href='roles/edit/" . $item->id . "'><i title='Add' class='nav-icon mr-2 fa fa-edit'></i>Edit</a>";
                $view_column    = "<a class='text-warning mr-2' href='roles/view/" . $item->id . "'><i title='Add' class='nav-icon mr-2 fa fa-eye'></i>View</a>";
                // $print_column    = "<a class='text-info mr-2' href='roles/print/" . $item->id . "'><i title='Add' class='nav-icon mr-2 fa fa-print'></i>Print</a>";
                // $delete_column    = "<a class='text-danger mr-2' href='roles/destroy/" . $item->id . "'><i title='Delete' class='nav-icon mr-2 fa fa-trash'></i>Delete</a>";
                $action_column .= $edit_column;
                $action_column .= $view_column;
                // $action_column .= $print_column;
                // $action_column .= $delete_column;

                return $action_column;
            })
            ->rawColumns(['permissions', 'action'])
            ->make(true);
        return $data;
    }

    public function save($obj)
    {
        if ($obj['id'] != null && $obj['id'] != '') {
            $this->model_role->update($obj, $obj['id']);
            $saved_obj = $this->model_role->find($obj['id']);
        } else {
            $saved_obj = $this->model_role->create($obj);
        }

        if (!$saved_obj)
            return false;

        return $saved_obj;
    }

    public function getById($id)
    {
        return $this->model_role->getModel()::with('permissions')->find($id);
    }
}
