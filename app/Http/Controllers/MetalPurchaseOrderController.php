<?php

namespace App\Http\Controllers;

use App\Services\Concrete\AccountService;
use App\Services\Concrete\CommonService;
use App\Services\Concrete\ProductService;
use App\Services\Concrete\MetalPurchaseOrderService;
use App\Services\Concrete\SupplierService;
use App\Services\Concrete\WarehouseService;
use App\Traits\JsonResponse;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class MetalPurchaseOrderController extends Controller
{
    use JsonResponse;
    protected $metal_purchase_order_service;
    protected $account_service;
    protected $supplier_service;
    protected $other_product_service;
    protected $warehouse_service;
    protected $product_service;
    protected $common_service;

    public function __construct(
        MetalPurchaseOrderService $metal_purchase_order_service,
        SupplierService $supplier_service,
        AccountService $account_service,
        WarehouseService $warehouse_service,
        ProductService $product_service,
        CommonService $common_service
    ) {
        $this->metal_purchase_order_service = $metal_purchase_order_service;
        $this->account_service = $account_service;
        $this->supplier_service = $supplier_service;
        $this->warehouse_service = $warehouse_service;
        $this->product_service = $product_service;
        $this->common_service = $common_service;
    }
    public function index()
    {
        abort_if(Gate::denies('metal_purchase_order_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $suppliers = $this->supplier_service->getAllActivesupplier();
        return view('metal_purchase_order.index', compact('suppliers'));
    }
    public function getData(Request $request)
    {
        abort_if(Gate::denies('metal_purchase_order_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $end = $request['end_date'] ?? date('Y-m-d ', strtotime(Carbon::now()));
            $start = $request['start_date'] ?? date('Y-m-d ', strtotime(Carbon::now()));
            $supplier_id = $request['supplier_id'] ?? '';
            $obj = [
                "supplier_id" => $supplier_id,
                "end" => $end,
                "start" => $start
            ];
            return $this->metal_purchase_order_service->getSource($obj);
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }
    public function create()
    {
        abort_if(Gate::denies('metal_purchase_order_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $metal_purchase_order = $this->metal_purchase_order_service->saveMetalPurchaseOrder();
        $warehouses = $this->warehouse_service->getAll();
        $suppliers = $this->supplier_service->getAllActiveSupplier();
        $products = $this->product_service->getAllActiveProduct();
        return view('metal_purchase_order.create', compact(
            'metal_purchase_order',
            'warehouses',
            'products',
            'suppliers'
        ));
    }
    public function store(Request $request)
    {
        abort_if(Gate::denies('metal_purchase_order_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $validation = Validator::make(
            $request->all(),
            [
                'id'                => 'required',
                'metal_purchase_order_date'   => 'required',
                'supplier_id'       => 'required',
                'warehouse_id'      => 'required',
                'metal_delivery_date'      => 'required',
                'reference_no'      => 'required',
                'metalPurchaseOrderDetail'   => 'required'
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
            $obj = $request->all();
            $purchase_order = $this->metal_purchase_order_service->save($obj);
            return  $this->success(
                config("enum.saved"),
                $purchase_order
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }


    public function print($id)
    {
        abort_if(Gate::denies('metal_purchase_order_print'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {

            $metal_purchase_order =  $this->metal_purchase_order_service->getById($id);
            $metal_purchase_order_detail = $this->metal_purchase_order_service->metalPurchaseOrderDetail($id);


            return view('metal_purchase_order/partials.print', compact('metal_purchase_order', 'metal_purchase_order_detail'));
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }


    public function destroy($id)
    {
        abort_if(Gate::denies('metal_purchase_order_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $metal_purchase_order = $this->metal_purchase_order_service->deleteById($id);
            return $this->success(
                config("enum.delete"),
                [],
                true
            );
        } catch (Exception $e) {
            return $this->error(config('enum.noDelete'),);
        }
    }

    //approve
    public function approve($metal_purchase_order_id)
    {
        abort_if(Gate::denies('metal_purchase_order_approve'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $metal_purchase_order = $this->metal_purchase_order_service->approved($metal_purchase_order_id);
            if ($metal_purchase_order == true)
                return $this->success(
                    config('enum.status'),
                    $metal_purchase_order,
                    false
                );

            return $this->error($metal_purchase_order);
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    //reject
    public function reject($metal_purchase_order_id)
    {
        abort_if(Gate::denies('metal_purchase_order_reject'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $metal_purchase_order = $this->metal_purchase_order_service->rejected($metal_purchase_order_id);
            if ($metal_purchase_order == true)
                return $this->success(
                    config('enum.status'),
                    $metal_purchase_order,
                    false
                );

            return $this->error($metal_purchase_order);
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }
}
