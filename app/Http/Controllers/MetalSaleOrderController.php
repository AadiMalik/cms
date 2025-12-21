<?php

namespace App\Http\Controllers;

use App\Services\Concrete\CustomerService;
use App\Services\Concrete\MetalSaleOrderService;
use App\Traits\JsonResponse;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Services\Concrete\AccountService;
use App\Services\Concrete\CommonService;
use App\Services\Concrete\CompanySettingService;
use App\Services\Concrete\JournalEntryService;
use App\Services\Concrete\ProductService;
use App\Services\Concrete\WarehouseService;

class MetalSaleOrderController extends Controller
{
    use JsonResponse;
    protected $metal_sale_order_service;
    protected $account_service;
    protected $customer_service;
    protected $other_product_service;
    protected $warehouse_service;
    protected $product_service;
    protected $common_service;
    protected $company_setting_service;
    protected $journal_entry_service;

    public function __construct(
        MetalSaleOrderService $metal_sale_order_service,
        CustomerService $customer_service,
        AccountService $account_service,
        WarehouseService $warehouse_service,
        ProductService $product_service,
        CommonService $common_service,
        CompanySettingService $company_setting_service,
        JournalEntryService $journal_entry_service
    ) {
        $this->metal_sale_order_service = $metal_sale_order_service;
        $this->account_service = $account_service;
        $this->customer_service = $customer_service;
        $this->warehouse_service = $warehouse_service;
        $this->product_service = $product_service;
        $this->common_service = $common_service;
        $this->company_setting_service = $company_setting_service;
        $this->journal_entry_service = $journal_entry_service;
    }
    public function index()
    {
        abort_if(Gate::denies('metal_sale_order_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $customers = $this->customer_service->getAllActiveCustomer();
        $accounts = $this->account_service->getAllActiveChild();
        $setting = $this->company_setting_service->getSetting();
        return view('metal_sale_order.index', compact('customers','accounts','setting'));
    }
    public function getData(Request $request)
    {
        abort_if(Gate::denies('metal_sale_order_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $end = $request['end_date'] ?? date('Y-m-d ', strtotime(Carbon::now()));
            $start = $request['start_date'] ?? date('Y-m-d ', strtotime(Carbon::now()));
            $customer_id = $request['customer_id'] ?? '';
            $obj = [
                "customer_id" => $customer_id,
                "end" => $end,
                "start" => $start
            ];
            return $this->metal_sale_order_service->getSource($obj);
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }
    public function create()
    {
        abort_if(Gate::denies('metal_sale_order_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $metal_sale_order = $this->metal_sale_order_service->saveMetalSaleOrder();
        $warehouses = $this->warehouse_service->getAll();
        $customers = $this->customer_service->getAllActiveCustomer();
        $products = $this->product_service->getAllActiveProduct();
        return view('metal_sale_order.create', compact(
            'metal_sale_order',
            'warehouses',
            'customers',
            'products'
        ));
    }
    public function store(Request $request)
    {
        abort_if(Gate::denies('metal_sale_order_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $validation = Validator::make(
            $request->all(),
            [
                'id'                => 'required',
                'metal_sale_order_date'   => 'required',
                'metal_delivery_date'   => 'required',
                'customer_id'       => 'required',
                'warehouse_id'      => 'required',
                'metalSaleOrderDetail'   => 'required'
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
            $metal_sale_order = $this->metal_sale_order_service->save($obj);
            return  $this->success(
                config("enum.saved"),
                $metal_sale_order
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }


    public function print($id)
    {
        abort_if(Gate::denies('metal_sale_order_print'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {

            $metal_sale_order =  $this->metal_sale_order_service->getById($id);
            $metal_sale_order_detail = $this->metal_sale_order_service->metalSaleOrderDetail($id);
            $advance = $this->journal_entry_service->getMetalSaleOrderPayments($id);

            return view('metal_sale_order/partials.print', compact('metal_sale_order', 'metal_sale_order_detail','advance'));
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }


    public function destroy($id)
    {
        abort_if(Gate::denies('metal_sale_order_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $metal_sale_order = $this->metal_sale_order_service->deleteById($id);
            return $this->success(
                config("enum.delete"),
                [],
                true
            );
        } catch (Exception $e) {
            return $this->error(config('enum.noDelete'),);
        }
    }

    public function getProductMol($product_id){
        // try {
            $product_mol = $this->product_service->getAllMolProductId($product_id);
            return $this->success(
                config("enum.success"),
                $product_mol,
                false
            );
        // } catch (Exception $e) {
        //     return $this->error(config('enum.error'),);
        // }
    }

    public function byWarehouse($warehouse_id)
    {
        try {
            $metal_sale_order = $this->metal_sale_order_service->getByWarehouseId($warehouse_id);
            return $this->success(
                config("enum.success"),
                $metal_sale_order,
                false
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'),);
        }
    }

    public function byCustomer($customer_id)
    {
        try {
            $metal_sale_order = $this->metal_sale_order_service->getMetalSaleOrderByCustomerId($customer_id);
            return $this->success(
                config("enum.success"),
                $metal_sale_order,
                false
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'),);
        }
    }

    public function getDetail($id)
    {
        try {

            $metal_sale_order_detail = $this->metal_sale_order_service->metalSaleOrderDetail($id);
            return $this->success(
                config("enum.success"),
                $metal_sale_order_detail,
                false
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'),);
        }
    }
}
