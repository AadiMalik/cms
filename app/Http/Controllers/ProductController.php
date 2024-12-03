<?php

namespace App\Http\Controllers;

use App\Services\Concrete\ProductService;
use App\Traits\JsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

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
        abort_if(Gate::denies('products_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
            return view('products.index');
    }

    public function getData()
    {
        abort_if(Gate::denies('products_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            return $this->product_service->getProductSource();
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }
    
    public function store(Request $request)
    {
        abort_if(Gate::denies('products_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
        abort_if(Gate::denies('products_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
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
        abort_if(Gate::denies('products_status'), Response::HTTP_FORBIDDEN, '403 Forbidden');
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
        abort_if(Gate::denies('products_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
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
