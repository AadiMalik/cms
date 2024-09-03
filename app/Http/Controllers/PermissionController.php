<?php

namespace App\Http\Controllers;

use App\Services\Concrete\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    protected $permission_service;
    public function __construct(
        PermissionService  $permission_service
    ) {
        $this->permission_service = $permission_service;
    }

    public function index(){
        return view('permissions.index');
    }


    public function getData(Request $request){
        return $this->permission_service->getPermissionSource();
    }

    public function create(){
        return view('permissions.create');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => ['required','max:50','unique:permissions,name','string']
        ]);
        
        if($validator->fails()){
        
          return redirect()->back()->withErrors($validator)->withInput();
        }
        dd($request->all());
    }

    public function edit($id){

    }

    public function update(Request $request,$id){

    }

    public function destroy($id){

    }

    public function status($id){

    }
}
