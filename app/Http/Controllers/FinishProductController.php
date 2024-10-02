<?php

namespace App\Http\Controllers;

use App\Models\FinishProduct;
use App\Services\Concrete\ProductService;
use App\Services\Concrete\WarehouseService;
use App\Traits\JsonResponse;
use Illuminate\Http\Request;

class FinishProductController extends Controller
{
    use JsonResponse;
    protected $product_service;
    protected $warehouse_service;

    public function __construct(
        ProductService $product_service,
        WarehouseService $warehouse_service
    ) {
        $this->product_service = $product_service;
        $this->warehouse_service = $warehouse_service;
    }
    public function index()
    {
        //
    }

    public function create()
    {
        $products = $this->product_service->getAllActiveProduct();
        $warehouses = $this->warehouse_service->getAll();
        return view('finish_product.create',compact('products','warehouses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FinishProduct  $finishProduct
     * @return \Illuminate\Http\Response
     */
    public function show(FinishProduct $finishProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FinishProduct  $finishProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(FinishProduct $finishProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FinishProduct  $finishProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FinishProduct $finishProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FinishProduct  $finishProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(FinishProduct $finishProduct)
    {
        //
    }
}
