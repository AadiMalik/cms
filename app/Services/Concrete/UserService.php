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
        $model = User::get();
        $data = DataTables::of($model)
            ->addColumn('action', function ($item) {
                $action_column = '';
                $edit_column    = "<a class='text-success mr-2' href='edit/" . $item->id . "'><i title='Add' class='nav-icon mr-2 fa fa-edit'></i>Edit</a>";
                $view_column    = "<a class='text-warning mr-2' href='view/" . $item->id . "'><i title='Add' class='nav-icon mr-2 fa fa-eye'></i>View</a>";
                $print_column    = "<a class='text-info mr-2' href='print/" . $item->id . "'><i title='Add' class='nav-icon mr-2 fa fa-print'></i>Print</a>";
                $delete_column    = "<a class='text-danger mr-2' href='destroy/" . $item->id . "'><i title='Delete' class='nav-icon mr-2 fa fa-trash'></i>Delete</a>";
                $action_column .= $edit_column;
                $action_column .= $view_column;
                $action_column .= $print_column;
                $action_column .= $delete_column;

                return $action_column;
            })
            ->rawColumns(['action'])
            ->make(true);
        return $data;
    }
}
