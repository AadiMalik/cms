<?php

namespace App\Http\Controllers;

use App\Services\Concrete\DiamondCutService;
use App\Traits\JsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiamondCutController extends Controller
{
    use JsonResponse;
    protected $diamond_cut_service;

    public function __construct(DiamondCutService $diamond_cut_service)
    {
        $this->diamond_cut_service = $diamond_cut_service;
    }

    public function index()
    {
        return view('diamond_cut.index');
    }

    public function getData()
    {
        try {
            return $this->diamond_cut_service->getSource();
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
                $response = $this->diamond_cut_service->update($obj);
                return  $this->success(
                    config("enum.updated"),
                    $response
                );
            } else {
                $obj = [
                    'name' => $request->name
                ];
                $response = $this->diamond_cut_service->save($obj);
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
                $this->diamond_cut_service->getById($id),
                false
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    public function status($id)
    {
        try {
            $diamond_cut = $this->diamond_cut_service->statusById($id);
            return $this->success(
                config("enum.status"),
                $diamond_cut,
                true
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    public function destroy($id)
    {
        try {
            $diamond_cut = $this->diamond_cut_service->deleteById($id);
            return $this->success(
                config("enum.delete"),
                $diamond_cut,
                true
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }
}
