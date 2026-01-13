<?php

namespace App\Http\Controllers;

use App\Services\Concrete\HRM\DesignationService;
use App\Traits\JsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class DesignationController extends Controller
{
    use JsonResponse;
    protected $designation_service;

    public function __construct(DesignationService $designation_service)
    {
        $this->designation_service = $designation_service;
    }

    public function index()
    {
        abort_if(Gate::denies('designation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('HRM.designation.index');
    }

    public function getData()
    {
        abort_if(Gate::denies('designation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            return $this->designation_service->getSource();
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('designation_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $validation = Validator::make(
            $request->all(),
            [
                'name' => 'required'
            ],
            $this->validationMessage()
        );

        if ($validation->fails()) {
            $validation_error = "";
            foreach ($validation->errors()->all() as $message) {
                $validation_error .= $message;
            }
            return $this->validationResponse(
                $validation_error
            );
        }
        try {
            if (isset($request->id)) {
                $obj = [
                    'id' => $request->id,
                    'name' => $request->name,
                    'description' => $request->description??''
                ];
                $response = $this->designation_service->update($obj);
                return  $this->success(
                    config("enum.updated"),
                    $response
                );
            } else {
                $obj = [
                    'name' => $request->name,
                    'description' => $request->description??''
                ];
                $response = $this->designation_service->save($obj);
                return  $this->success(
                    config("enum.saved"),
                    $response
                );
            }
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    public function edit($id)
    {
        abort_if(Gate::denies('designation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            return  $this->success(
                config('enum.success'),
                $this->designation_service->getById($id),
                false
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    public function status($id)
    {
        abort_if(Gate::denies('designation_status'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $designation = $this->designation_service->statusById($id);
            return $this->success(
                config("enum.status"),
                $designation,
                true
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    public function destroy($id)
    {
        abort_if(Gate::denies('designation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $designation = $this->designation_service->deleteById($id);
            return $this->success(
                config("enum.delete"),
                $designation,
                true
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }
}
