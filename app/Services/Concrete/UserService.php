<?php

namespace App\Services\Concrete;

use App\Repository\Repository;
use App\Models\User;
use Yajra\DataTables\DataTables;

class UserService
{
    // initialize protected model variables
    protected $model_user;

    public function __construct()
    {
        // set the model
        $this->model_user = new Repository(new User);
    }

    public function getUserSource()
    {
        $model = User::with('roles');
        $data = DataTables::of($model)
        ->addColumn('role', function ($item) {
            return $item->roles[0]->name??'';
        })
            ->addColumn('action', function ($item) {
                $action_column = '';
                $edit_column    = "<a class='text-success mr-2' href='users/edit/" . $item->id . "'><i title='Add' class='nav-icon mr-2 fa fa-edit'></i>Edit</a>";
                $view_column    = "<a class='text-warning mr-2' href='users/view/" . $item->id . "'><i title='Add' class='nav-icon mr-2 fa fa-eye'></i>View</a>";
                // $print_column    = "<a class='text-info mr-2' href='users/print/" . $item->id . "'><i title='Add' class='nav-icon mr-2 fa fa-print'></i>Print</a>";
                // $delete_column    = "<a class='text-danger mr-2' href='users/destroy/" . $item->id . "'><i title='Delete' class='nav-icon mr-2 fa fa-trash'></i>Delete</a>";
                $action_column .= $edit_column;
                $action_column .= $view_column;
                // $action_column .= $print_column;
                // $action_column .= $delete_column;

                return $action_column;
            })
            ->rawColumns(['role','action'])
            ->make(true);
        return $data;
    }

    public function save($obj)
    {
        if ($obj['id'] != null && $obj['id'] != '') {
            $this->model_user->update($obj, $obj['id']);
            $saved_obj = $this->model_user->find($obj['id']);
        } else {
            $saved_obj = $this->model_user->create($obj);
        }

        if (!$saved_obj)
            return false;

        return $saved_obj;
    }

    public function getById($id)
    {
        return $this->model_user->getModel()::with(['roles','permissions'])->find($id);
    }
}
