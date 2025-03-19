<?php

namespace App\Http\Controllers;

use App\Services\Concrete\FinishProductLocationService;
use App\Traits\JsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class FinishProductLocationController extends Controller
{
    use JsonResponse;
    protected $finish_product_location_service;

    public function __construct(FinishProductLocationService $finish_product_location_service)
    {
        $this->finish_product_location_service = $finish_product_location_service;
    }

    public function index()
    {
        abort_if(Gate::denies('tagging_location_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('finish_product_location.index');
    }

    public function getData()
    {
        abort_if(Gate::denies('tagging_location_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            return $this->finish_product_location_service->getSource();
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('tagging_location_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
                    'name' => $request->name
                ];
                $response = $this->finish_product_location_service->update($obj);
                return  $this->success(
                    config("enum.updated"),
                    $response
                );
            } else {
                $obj = [
                    'name' => $request->name
                ];
                $response = $this->finish_product_location_service->save($obj);
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
        abort_if(Gate::denies('tagging_location_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            return  $this->success(
                config('enum.success'),
                $this->finish_product_location_service->getById($id),
                false
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    public function status($id)
    {
        abort_if(Gate::denies('tagging_location_status'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $finish_product_location = $this->finish_product_location_service->statusById($id);
            return $this->success(
                config("enum.status"),
                $finish_product_location,
                true
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    public function destroy($id)
    {
        abort_if(Gate::denies('tagging_location_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $finish_product_location = $this->finish_product_location_service->deleteById($id);
            return $this->success(
                config("enum.delete"),
                $finish_product_location,
                true
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }
}
