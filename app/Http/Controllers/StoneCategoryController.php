<?php

namespace App\Http\Controllers;

use App\Services\Concrete\StoneCategoryService;
use App\Traits\JsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StoneCategoryController extends Controller
{
    use JsonResponse;
    protected $stone_category_service;

    public function __construct(StoneCategoryService $stone_category_service)
    {
        $this->stone_category_service = $stone_category_service;
    }

    public function index()
    {
        return view('stone_category.index');
    }

    public function getData()
    {
        try {
            return $this->stone_category_service->getSource();
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    public function store(Request $request)
    {

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
                $response = $this->stone_category_service->update($obj);
                return  $this->success(
                    config("enum.updated"),
                    $response
                );
            } else {
                $obj = [
                    'name' => $request->name
                ];
                $response = $this->stone_category_service->save($obj);
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
        try {
            return  $this->success(
                config('enum.success'),
                $this->stone_category_service->getById($id),
                false
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    public function status($id)
    {
        try {
            $bead_type = $this->stone_category_service->statusById($id);
            return $this->success(
                config("enum.status"),
                $bead_type,
                true
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    public function destroy($id)
    {
        try {
            $bead_type = $this->stone_category_service->deleteById($id);
            return $this->success(
                config("enum.delete"),
                $bead_type,
                true
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }
}
