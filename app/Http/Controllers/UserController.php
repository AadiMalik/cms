<?php

namespace App\Http\Controllers;

use App\Services\Concrete\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $user_service;
    public function __construct(
        UserService  $user_service
    ) {
        $this->user_service = $user_service;
    }

    public function index(){
        return view('users.index');
    }


    public function getData(Request $request){
        return $this->user_service->getUserSource();
    }

    public function create(){
        return view('users.create');
    }

    public function store(Request $request){

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
