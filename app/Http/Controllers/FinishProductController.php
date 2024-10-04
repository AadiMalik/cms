<?php

namespace App\Http\Controllers;

use App\Services\Concrete\FinishProductService;
use App\Services\Concrete\ProductService;
use App\Services\Concrete\WarehouseService;
use App\Traits\JsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Picqer\Barcode\BarcodeGeneratorPNG;

class FinishProductController extends Controller
{
    use JsonResponse;
    protected $finish_product_service;
    protected $product_service;
    protected $warehouse_service;

    public function __construct(
        FinishProductService $finish_product_service,
        ProductService $product_service,
        WarehouseService $warehouse_service
    ) {
        $this->finish_product_service = $finish_product_service;
        $this->product_service = $product_service;
        $this->warehouse_service = $warehouse_service;
    }
    public function index()
    {
        return view('finish_product.index');
    }
    public function getData(Request $request)
    {
        return $this->finish_product_service->getFinishProductSource();
    }

    public function create()
    {
        $products = $this->product_service->getAllActiveProduct();
        $warehouses = $this->warehouse_service->getAll();
        return view('finish_product.create', compact('products', 'warehouses'));
    }


    public function store(Request $request)
    {
        $validation = $request->validate(
            [
                'ratti_kaat_id'             => 'required',
                'ratti_kaat_detail_id'      => 'required',
                'tag_no'                    => 'required',
                'product_id'                => 'required',
                'warehouse_id'              => 'required',
                'picture'                   => 'image|mimes:jpeg,png,jpg,gif',
                'gold_carat'                => 'required',
                'scale_weight'              => 'required',
                'bead_weight'               => 'required',
                'stones_weight'             => 'required',
                'diamond_weight'            => 'required',
                'net_weight'                => 'required',
                'waste_per'                 => 'required',
                'waste'                     => 'required',
                'gross_weight'              => 'required',
                'making_gram'               => 'required',
                'making'                    => 'required',
                'laker'                     => 'required',
                'bead_price'                => 'required',
                'stones_price'              => 'required',
                'diamond_price'             => 'required',
                'total_bead_price'          => 'required',
                'total_stones_price'        => 'required',
                'total_diamond_price'       => 'required',
                'other_amount'              => 'required',
                'gold_rate'                 => 'required',
                'total_gold_price'          => 'required',
                'total_amount'              => 'required'
            ]
        );

        try {
            DB::beginTransaction();
            $obj = $request->all();
            $filenames = null;
            if ($request->hasFile('picture')) {
                $file = $request->file('picture');
                $filename = time() . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('pictures'), $filename);
                $filenames = 'pictures/' . $filename;
                $obj['picture'] = $filenames;
            }

            $generator = new BarcodeGeneratorPNG();
            $barcodeImage = $generator->getBarcode($obj['tag_no'], $generator::TYPE_CODE_39);
            $filePath = 'barcodes/' . $obj['tag_no'] . '.png';

            file_put_contents($filePath, $barcodeImage);


            $obj['barcode'] = $filePath;
            $finish_product = $this->finish_product_service->save($obj);

            DB::commit();
            if ($finish_product)
                return redirect('finish-product')->with('message', config('enum.saved'));
        } catch (Exception $e) {
            return back()->with('error', config('enum.error'));
        }
    }

    public function show($id)
    {
        $finish_product = $this->finish_product_service->getById($id);
        return view('finish_product.view', compact('finish_product'));
    }


    public function status($id)
    {
        try {
            $finish_product = $this->finish_product_service->statusById($id);

            if ($finish_product)
                return $this->success(
                    config('enum.status'),
                    []

                );
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $finish_product = $this->finish_product_service->deleteById($id);

            if ($finish_product)
                return $this->success(
                    config('enum.delete'),
                    []

                );
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
