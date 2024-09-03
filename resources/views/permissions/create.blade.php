@extends('layouts.master')
@section('content')
    <div class="main-content pt-4">
        <div class="breadcrumb">
            <h1>Permission</h1>
            <ul>
                <li>Create</li>
                <li>Add</li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <form action="{{url('permissions/store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 form-group mb-3">
                                    <label for="firstName1">Permission Name<span class="text-danger">*</span> </label>
                                    <input class="form-control" type="text" name="name" placeholder="Enter permission slug" />
                                    @error('name') <span class="text-danger">{{$message}}</span> @enderror
                                </div>

                            </div>

                        </div>
                        <div class="card-footer">

                            <div class="row">
                                <div class="col-md-12">
                                    <a href="{{ url('permissions') }}" class="btn btn-danger">Cancel</a>
                                    <button class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!-- end of main-content -->
    </div>
@endsection
