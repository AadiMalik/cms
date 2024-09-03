<?php

namespace App\Http\Controllers;

use App\Services\Concrete\PermissionService;
use App\Services\Concrete\RoleService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    protected $role_service;
    protected $permission_service;

    public function __construct(
        RoleService  $role_service,
        PermissionService $permission_service
    ) {
        $this->role_service = $role_service;
        $this->permission_service = $permission_service;
    }

    public function index()
    {
        return view('roles.index');
    }


    public function getData(Request $request)
    {
        return $this->role_service->getRoleSource();
    }

    public function create()
    {
        $permissions = $this->permission_service->getAll();
        return view('roles.create',compact('permissions'));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'max:50', 'string', 'unique:roles,name,'.$request->id],
                'permissions' => ['required', 'array'],
            ]);

            if ($validator->fails()) {

                return redirect()->back()->withErrors($validator)->withInput();
            }

            $obj = [
                "id"    => $request->id,
                "name"  => $request->name
            ];

            $role = $this->role_service->save($obj);
            $role->syncPermissions($request->permissions);

            if (!$role)
                return redirect()->back()->with('error', config('enum.error'));


            return redirect('roles')->with('success', config('enum.saved'));
        } catch (Exception $e) {
            return redirect()->back()->with('error',  $e->getMessage());
        }
    }

    public function edit($id) {
        $role = $this->role_service->getById($id);
        $permissions = $this->permission_service->getAll();
        return view('roles.create',compact('role','permissions'));
    }

    public function view($id) {
        $role = $this->role_service->getById($id);
        return view('roles.view',compact('role'));
    }


    public function destroy($id) {}

    public function status($id) {}
}
