<?php

namespace App\Http\Controllers;

use App\Services\Concrete\ProductService;
use App\Traits\JsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    use JsonResponse;
    protected $product_service;

    public function __construct(ProductService $product_service)
    {
        $this->product_service = $product_service;
    }

    public function index(Request $request)
    {
            return view('products.index');
    }

    public function getData()
    {
        try {
            return $this->product_service->getProductSource();
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }
    
    public function store(Request $request)
    {

        $validation = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'prefix' => 'required|max:3'
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
                    'prefix' => $request->prefix
                ];
                $response = $this->product_service->updateProduct($obj);
                return  $this->success(
                    config("enum.updated"),
                    $response
                );
            } else {
                $obj = [
                    'name' => $request->name,
                    'prefix' => $request->prefix
                ];
                $response = $this->product_service->saveProduct($obj);
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
                $this->product_service->getProductById($id),
                false
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    public function status($id)
    {
        try {
            $product = $this->product_service->statusById($id);
            return $this->success(
                config("enum.status"),
                $product,
                true
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    public function destroy($id)
    {
        try {
            $product = $this->product_service->deleteProductById($id);
            return $this->success(
                config("enum.delete"),
                $product,
                true
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }
}
