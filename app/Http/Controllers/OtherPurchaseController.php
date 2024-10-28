<?php

namespace App\Http\Controllers;

use App\Models\OtherPurchase;
use App\Services\Concrete\AccountService;
use App\Services\Concrete\CommonService;
use App\Services\Concrete\OtherProductService;
use App\Services\Concrete\OtherPurchaseService;
use App\Services\Concrete\SupplierService;
use App\Services\Concrete\WarehouseService;
use App\Traits\JsonResponse;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OtherPurchaseController extends Controller
{
    use JsonResponse;
    protected $other_purchase_service;
    protected $account_service;
    protected $supplier_service;
    protected $other_product_service;
    protected $warehouse_service;
    protected $common_service;

    public function __construct(
        OtherPurchaseService $other_purchase_service,
        SupplierService $supplier_service,
        AccountService $account_service,
        OtherProductService $other_product_service,
        WarehouseService $warehouse_service,
        CommonService $common_service
    ) {
        $this->other_purchase_service = $other_purchase_service;
        $this->account_service = $account_service;
        $this->supplier_service = $supplier_service;
        $this->other_product_service = $other_product_service;
        $this->warehouse_service = $warehouse_service;
        $this->common_service = $common_service;
    }
    public function index()
    {
        $suppliers = $this->supplier_service->getAllActiveSupplier();
        return view('purchases/other_purchase.index', compact('suppliers'));
    }
    public function getData(Request $request)
    {
        try {
            $end = $request['end_date'] ?? date('Y-m-d ', strtotime(Carbon::now()));
            $start = $request['start_date'] ?? date('Y-m-d ', strtotime(Carbon::now()));
            $supplier_id = $request['supplier_id'] ?? '';
            $posted = $request['posted'] ?? '';
            $obj = [
                "supplier_id" => $supplier_id,
                "end" => $end,
                "start" => $start,
                "posted" => $posted,
            ];
            return $this->other_purchase_service->getSource($obj);
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }
    public function create()
    {
        $other_purchase = $this->other_purchase_service->saveOtherPurchase();
        $other_products = $this->other_product_service->getAllActiveOtherProduct();
        $accounts = $this->account_service->getAllActiveChild();
        $suppliers = $this->supplier_service->getAllActiveSupplier();
        $warehouses = $this->warehouse_service->getAll();
        return view('purchases/other_purchase.create', compact(
            'other_purchase',
            'other_products',
            'warehouses',
            'accounts',
            'suppliers'
        ));
    }
    public function store(Request $request)
    {
        $validation = Validator::make(
            $request->all(),
            [
                'id'             => 'required',
                'other_purchase_date'      => 'required',
                'supplier_id'    => 'required',
                'warehouse_id'    => 'required',
                'purchase_account_id'    => 'required',
                'total'          => 'required',
                'otherProductDetail'  => 'required'
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
            $other_purchase = $this->other_purchase_service->save($obj);
            return  $this->success(
                config("enum.saved"),
                $other_purchase
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }


    public function print($id)
    {
        try {

            $other_purchase =  $this->other_purchase_service->getById($id);
            $other_purchase_detail = $this->other_purchase_service->otherPurchaseDetail($id);


            return view('purchases/other_purchase/partials.print', compact('other_purchase', 'other_purchase_detail'));
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }


    public function unpost($id)
    {
        try {
            $this->other_purchase_service->unpost($id);
            return $this->success(
                config('enum.unposted'),
                []
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }
    public function post(Request $request)
    {
        // try {
            $other_sale = $this->other_purchase_service->post($request->all());
            if ($other_sale != 'true') {
                return $this->error(
                    $other_sale
                );
            }
            return $this->success(
                config('enum.posted'),
                []
            );
        // } catch (Exception $e) {
        //     return $this->error(config('enum.error'));
        // }
    }

    public function destroy($id)
    {
        try {
            $other_purchase = $this->other_purchase_service->deleteById($id);
            return $this->success(
                config("enum.delete"),
                [],
                true
            );
        } catch (Exception $e) {
            return $this->error(config('enum.noDelete'),);
        }
    }
}
