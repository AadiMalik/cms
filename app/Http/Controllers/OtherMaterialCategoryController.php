<?php

namespace App\Http\Controllers;

use App\Services\Concrete\OtherMaterialCategoryService;
use App\Traits\JsonResponse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class OtherMaterialCategoryController extends Controller
{
    use JsonResponse;
    protected $other_material_category_service;

    public function __construct(OtherMaterialCategoryService $other_material_category_service)
    {
        $this->other_material_category_service = $other_material_category_service;
    }

    public function index()
    {
        abort_if(Gate::denies('other_material_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('other_material_category.index');
    }

    public function getData()
    {
        abort_if(Gate::denies('other_material_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            return $this->other_material_category_service->getSource();
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('other_material_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
                $response = $this->other_material_category_service->update($obj);
                return  $this->success(
                    config("enum.updated"),
                    $response
                );
            } else {
                $obj = [
                    'name' => $request->name
                ];
                $response = $this->other_material_category_service->save($obj);
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
        abort_if(Gate::denies('other_material_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            return  $this->success(
                config('enum.success'),
                $this->other_material_category_service->getById($id),
                false
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    public function status($id)
    {
        abort_if(Gate::denies('other_material_category_status'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $other_material_category = $this->other_material_category_service->statusById($id);
            return $this->success(
                config("enum.status"),
                $other_material_category,
                true
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    public function destroy($id)
    {
        abort_if(Gate::denies('other_material_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $other_material_category = $this->other_material_category_service->deleteById($id);
            return $this->success(
                config("enum.delete"),
                $other_material_category,
                true
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }
}
