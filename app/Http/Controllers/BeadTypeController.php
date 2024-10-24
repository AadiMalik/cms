<?php

namespace App\Http\Controllers;

use App\Services\Concrete\BeadTypeService;
use App\Traits\JsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BeadTypeController extends Controller
{
    use JsonResponse;
    protected $bead_type_service;

    public function __construct(BeadTypeService $bead_type_service)
    {
        $this->bead_type_service = $bead_type_service;
    }

    public function index()
    {
        return view('bead_type.index');
    }

    public function getData()
    {
        try {
            return $this->bead_type_service->getSource();
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
                $response = $this->bead_type_service->update($obj);
                return  $this->success(
                    config("enum.updated"),
                    $response
                );
            } else {
                $obj = [
                    'name' => $request->name
                ];
                $response = $this->bead_type_service->save($obj);
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
                $this->bead_type_service->getById($id),
                false
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    public function status($id)
    {
        try {
            $bead_type = $this->bead_type_service->statusById($id);
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
            $bead_type = $this->bead_type_service->deleteById($id);
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
