<?php

namespace App\Http\Controllers;

use App\Models\RattiKaat;
use App\Services\Concrete\AccountService;
use App\Services\Concrete\CommonService;
use App\Services\Concrete\ProductService;
use App\Services\Concrete\RattiKaatService;
use App\Services\Concrete\SupplierService;
use App\Traits\JsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RattiKaatController extends Controller
{

    use JsonResponse;
    protected $account_service;
    protected $supplier_service;
    protected $product_service;
    protected $ratti_kaat_service;
    protected $common_service;

    public function __construct(
        SupplierService $supplier_service,
        AccountService $account_service,
        ProductService $product_service,
        RattiKaatService $ratti_kaat_service,
        CommonService $common_service
    ) {
        $this->account_service = $account_service;
        $this->supplier_service = $supplier_service;
        $this->product_service = $product_service;
        $this->ratti_kaat_service = $ratti_kaat_service;
        $this->common_service = $common_service;
    }

    public function index()
    {
        //
    }
    public function create()
    {
        $accounts = $this->account_service->getAllActiveChild();
        $suppliers = $this->supplier_service->getAllActiveSupplier();
        $products = $this->product_service->getAllActiveProduct();
        $ratti_kaat = $this->ratti_kaat_service->saveRattiKaat();
        return view('purchases.ratti_kaat.create', compact('accounts', 'suppliers', 'products', 'ratti_kaat'));
    }

    // Bead Weight
    public function getBeadWeight($ratti_kaat_id, $product_id)
    {
        try {
            $ratti_kaat_beads = $this->ratti_kaat_service->getBeadWeight($ratti_kaat_id, $product_id);
            return $this->success(
                config('enum.success'),
                $ratti_kaat_beads,
                false
            );
        } catch (Exception $e) {
            return $this->error(config('global.error'));
        }
    }
    public function storeBeadWeight(Request $request)
    {
        $validation = Validator::make(
            $request->all(),
            [
                'bead_weight_product_id'    => 'required',
                'bead_weight_ratti_kaat_id' => 'required',
                'beads'                     => 'required',
                'bead_gram'                 => 'required',
                'bead_carat'                => 'required',
                'bead_gram_rate'            => 'required',
                'bead_carat_rate'           => 'required',
                'bead_total'                => 'required'
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
            $obj = [
                'product_id'        => $request->bead_weight_product_id,
                'ratti_kaat_id'     => $request->bead_weight_ratti_kaat_id,
                'beads'             => $request->beads,
                'gram'              =>$request->bead_gram,
                'carat'             =>$request->bead_carat,
                'gram_rate'         =>$request->bead_gram_rate,
                'carat_rate'        =>$request->bead_carat_rate,
                'total_amount'      =>$request->bead_total
            ];
            $response = $this->ratti_kaat_service->saveBeadWeight($obj);
            return  $this->success(
                config("enum.saved"),
                $response
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }
    public function destroyBeadWeight($id)
    {
        try {
            $beads = $this->ratti_kaat_service->deleteBeadWeightById($id);
            return $this->success(
                config("enum.delete"),
                $beads,
                true
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    // Stone Weight
    public function getStoneWeight($ratti_kaat_id, $product_id)
    {
        try {
            $ratti_kaat_stones = $this->ratti_kaat_service->getStoneWeight($ratti_kaat_id, $product_id);
            return $this->success(
                config('enum.success'),
                $ratti_kaat_stones,
                false
            );
        } catch (Exception $e) {
            return $this->error(config('global.error'));
        }
    }
    public function storeStoneWeight(Request $request)
    {
        $validation = Validator::make(
            $request->all(),
            [
                'stone_weight_product_id'    => 'required',
                'stone_weight_ratti_kaat_id' => 'required',
                'stones'                     => 'required',
                'stone_gram'                 => 'required',
                'stone_carat'                => 'required',
                'stone_gram_rate'            => 'required',
                'stone_carat_rate'           => 'required',
                'stone_total'                => 'required'
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
            $obj = [
                'product_id'        => $request->stone_weight_product_id,
                'ratti_kaat_id'     => $request->stone_weight_ratti_kaat_id,
                'stones'             => $request->stones,
                'gram'              =>$request->stone_gram,
                'carat'             =>$request->stone_carat,
                'gram_rate'         =>$request->stone_gram_rate,
                'carat_rate'        =>$request->stone_carat_rate,
                'total_amount'      =>$request->stone_total
            ];
            $response = $this->ratti_kaat_service->saveStoneWeight($obj);
            return  $this->success(
                config("enum.saved"),
                $response
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }
    public function destroyStoneWeight($id)
    {
        try {
            $stones = $this->ratti_kaat_service->deleteStoneWeightById($id);
            return $this->success(
                config("enum.delete"),
                $stones,
                true
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }
    
// Diamond Carat
public function getDiamondCarat($ratti_kaat_id, $product_id)
{
    try {
        $ratti_kaat_diamonds = $this->ratti_kaat_service->getDiamondCarat($ratti_kaat_id, $product_id);
        return $this->success(
            config('enum.success'),
            $ratti_kaat_diamonds,
            false
        );
    } catch (Exception $e) {
        return $this->error(config('global.error'));
    }
}
public function storeDiamondCarat(Request $request)
{
    $validation = Validator::make(
        $request->all(),
        [
            'diamond_carat_product_id'     => 'required',
            'diamond_carat_ratti_kaat_id'  => 'required',
            'diamonds'                      => 'required',
            'type'                          => 'required',
            'color'                         => 'required',
            'clarity'                       => 'required',
            'cut'                           => 'required',
            'carat'                 => 'required',
            'carat_rate'            => 'required',
            'diamond_total'                 => 'required',
            'diamond_total_dollar'          => 'required'
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
    // try {
        $obj = [
            'product_id'        => $request->diamond_carat_product_id,
            'ratti_kaat_id'     => $request->diamond_carat_ratti_kaat_id,
            'diamonds'          => $request->diamonds,
            'type'          => $request->type,
            'cut'          => $request->cut,
            'color'          => $request->color,
            'clarity'          => $request->clarity,
            'carat'             =>$request->carat,
            'carat_rate'        =>$request->carat_rate,
            'total_amount'      =>$request->diamond_total,
            'total_dollar'      =>$request->diamond_total_dollar,
        ];
        $response = $this->ratti_kaat_service->saveDiamondCarat($obj);
        return  $this->success(
            config("enum.saved"),
            $response
        );
    // } catch (Exception $e) {
    //     return $this->error(config('enum.error'));
    // }
}
public function destroyDiamondCarat($id)
{
    try {
        $diamond = $this->ratti_kaat_service->deleteDiamondCaratById($id);
        return $this->success(
            config("enum.delete"),
            $diamond,
            true
        );
    } catch (Exception $e) {
        return $this->error(config('enum.error'));
    }
}

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RattiKaat  $rattiKaat
     * @return \Illuminate\Http\Response
     */
    public function show(RattiKaat $rattiKaat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RattiKaat  $rattiKaat
     * @return \Illuminate\Http\Response
     */
    public function edit(RattiKaat $rattiKaat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RattiKaat  $rattiKaat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RattiKaat $rattiKaat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RattiKaat  $rattiKaat
     * @return \Illuminate\Http\Response
     */
    public function destroy(RattiKaat $rattiKaat)
    {
        //
    }
}