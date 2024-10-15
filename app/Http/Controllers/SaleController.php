<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Services\Concrete\AccountService;
use App\Services\Concrete\CommonService;
use App\Services\Concrete\CustomerService;
use App\Services\Concrete\FinishProductService;
use App\Services\Concrete\ProductService;
use App\Services\Concrete\SaleService;
use App\Traits\JsonResponse;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\Validator;

class SaleController extends Controller
{
    use JsonResponse;
    protected $sale_service;
    protected $account_service;
    protected $customer_service;
    protected $product_service;
    protected $finish_product_service;
    protected $common_service;

    public function __construct(
        SaleService $sale_service,
        CustomerService $customer_service,
        AccountService $account_service,
        ProductService $product_service,
        FinishProductService $finish_product_service,
        CommonService $common_service
    ) {
        $this->sale_service = $sale_service;
        $this->account_service = $account_service;
        $this->customer_service = $customer_service;
        $this->product_service = $product_service;
        $this->finish_product_service = $finish_product_service;
        $this->common_service = $common_service;
    }
    public function index()
    {
        $customers = $this->customer_service->getAllActiveCustomer();
        $accounts = $this->account_service->getAllActiveChild();
        return view('sale.index', compact('customers', 'accounts'));
    }
    public function getData(Request $request)
    {
        // try {
            $end = $request['end_date'] ?? date('Y-m-d ', strtotime(Carbon::now()));
            $start = $request['start_date'] ?? date('Y-m-d ', strtotime(Carbon::now()));
            $customer_id = $request['customer_id'] ?? '';
            $posted = $request['posted'] ?? '';
            $obj = [
                "customer_id" => $customer_id,
                "end" => $end,
                "start" => $start,
                "posted" => $posted,
            ];
            return $this->sale_service->getSaleSource($obj);
        // } catch (Exception $e) {
        //     return $this->error(config('enum.error'));
        // }
    }
    public function create()
    {
        $sale = $this->sale_service->saveSale();
        $finish_product = $this->finish_product_service->getAllActiveFinishProduct();
        return view('sale.create', compact('sale', 'finish_product'));
    }
    public function store(Request $request)
    {
        $validation = Validator::make(
            $request->all(),
            [
                'id'             => 'required',
                'sale_date'      => 'required',
                'customer_id'    => 'required',
                'total'          => 'required',
                'productDetail'  => 'required'
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
            $sale = $this->sale_service->save($obj);
            return  $this->success(
                config("enum.saved"),
                $sale
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    
    public function print($id)
    {
        try {

            $sale =  $this->sale_service->getById($id);
            $sale_detail = $this->sale_service->saleDetail($id);


            return view('sale/partials.print', compact('sale', 'sale_detail'));
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    
    public function unpostSale($id)
    {
        try {
            $this->sale_service->unpostSale($id);
            return $this->success(
                config('enum.unposted'),
                []
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }
    public function postSale(Request $request)
    {
        try {
            $sale = $this->sale_service->postSale($request->all());
            if ($sale != 'true') {
                return $this->error(
                    $sale
                );
            }
            return $this->success(
                config('enum.posted'),
                []
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    public function destroy($id)
    {
        try {
            $sale = $this->sale_service->deleteSaleById($id);
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
