<?php

namespace App\Http\Controllers;

use App\Services\Concrete\RoleService;
use App\Services\Concrete\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $user_service;
    protected $role_service;
    public function __construct(
        UserService  $user_service,
        RoleService $role_service
    ) {
        $this->user_service = $user_service;
        $this->role_service = $role_service;
    }

    public function index()
    {

        return view('users.index');
    }


    public function getData(Request $request)
    {
        return $this->user_service->getUserSource();
    }

    public function create()
    {

        $roles = $this->role_service->getAll();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => ['required', 'email', 'max:100', 'string', 'unique:users,email,' . $request->id],
                'name' => ['required', 'string', 'max:50'],
                'password' => ['required', 'string', 'min:8', 'max:16', 'confirmed'],
                'role' => ['required'],
            ]);

            if ($validator->fails()) {

                return redirect()->back()->withErrors($validator)->withInput();
            }

            $obj = [
                "id"        => $request->id,
                "name"      => $request->name,
                "email"     => $request->email,
                "password"  => Hash::make($request->password)
            ];

            $user = $this->user_service->save($obj);
            $user->syncRoles([$request->role]);

            if (!$user)
                return redirect()->back()->with('error', config('enum.error'));


            return redirect('users')->with('success', config('enum.saved'));
        } catch (Exception $e) {
            return redirect()->back()->with('error',  $e->getMessage());
        }
    }

    public function edit($id)
    {
        $user = $this->user_service->getById($id);
        $roles = $this->role_service->getAll();
        return view('users.create', compact('user', 'roles'));
    }


    public function destroy($id) {}

    public function status($id) {}
}
