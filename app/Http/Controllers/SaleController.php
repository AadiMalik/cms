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
        return view('sale.index', compact('customers'));
    }
    public function getData(Request $request)
    {
        try {
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
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }
    public function create()
    {
        $sale = null;
        $finish_product = $this->finish_product_service->getAllActiveFinishProduct();
        return view('sale.create', compact('sale','finish_product'));
    }
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        //
    }
}
