<?php

namespace App\Http\Controllers;

use App\Services\Concrete\BeadTypeService;
use App\Services\Concrete\CommonService;
use App\Services\Concrete\DiamondClarityService;
use App\Services\Concrete\DiamondColorService;
use App\Services\Concrete\DiamondCutService;
use App\Services\Concrete\DiamondTypeService;
use App\Services\Concrete\StoneCategoryService;
use App\Services\Concrete\FinishProductService;
use App\Services\Concrete\ProductService;
use App\Services\Concrete\WarehouseService;
use App\Traits\JsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Picqer\Barcode\BarcodeGeneratorPNG;

class FinishProductController extends Controller
{
    use JsonResponse;
    protected $finish_product_service;
    protected $product_service;
    protected $warehouse_service;
    protected $bead_type_service;
    protected $stone_category_service;
    protected $diamond_type_service;
    protected $diamond_color_service;
    protected $diamond_cut_service;
    protected $diamond_clarity_service;
    protected $common_service;

    public function __construct(
        FinishProductService $finish_product_service,
        ProductService $product_service,
        WarehouseService $warehouse_service,
        BeadTypeService $bead_type_service,
        StoneCategoryService $stone_category_service,
        DiamondTypeService $diamond_type_service,
        DiamondColorService $diamond_color_service,
        DiamondCutService $diamond_cut_service,
        DiamondClarityService $diamond_clarity_service,
        CommonService $common_service
    ) {
        $this->finish_product_service = $finish_product_service;
        $this->product_service = $product_service;
        $this->warehouse_service = $warehouse_service;
        $this->bead_type_service = $bead_type_service;
        $this->stone_category_service = $stone_category_service;
        $this->diamond_type_service = $diamond_type_service;
        $this->diamond_color_service = $diamond_color_service;
        $this->diamond_cut_service = $diamond_cut_service;
        $this->diamond_clarity_service = $diamond_clarity_service;
        $this->common_service = $common_service;
    }
    public function index()
    {
        abort_if(Gate::denies('tagging_product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('finish_product.index');
    }
    public function getData(Request $request)
    {
        abort_if(Gate::denies('tagging_product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return $this->finish_product_service->getFinishProductSource();
    }

    public function create()
    {
        abort_if(Gate::denies('tagging_product_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $products = $this->product_service->getAllActiveProduct();
        $warehouses = $this->warehouse_service->getAll();
        $bead_types = $this->bead_type_service->getAllActive();
        $stone_categories = $this->stone_category_service->getAllActive();
        $diamond_types = $this->diamond_type_service->getAllActive();
        $diamond_colors = $this->diamond_color_service->getAllActive();
        $diamond_cuts = $this->diamond_cut_service->getAllActive();
        $diamond_clarities = $this->diamond_clarity_service->getAllActive();
        $parent_tag = $this->common_service->generateParentFinishProductTagNo();
        $parents = $this->finish_product_service->getAllActiveParentFinishProduct();
        return view('finish_product.create', compact(
            'products',
            'warehouses',
            'bead_types',
            'stone_categories',
            'diamond_types',
            'diamond_colors',
            'diamond_cuts',
            'diamond_clarities',
            'parent_tag',
            'parents'
        ));
    }


    public function store(Request $request)
    {
        abort_if(Gate::denies('tagging_product_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($request->is_parent != 1) {
            $validation = Validator::make(
                $request->all(),
                [
                    'tag_no'                    => 'required',
                    'product_id'                => 'required',
                    'warehouse_id'              => 'required',
                    'picture'                   => 'required|image|mimes:jpeg,png,jpg,gif',
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
                    'total_bead_price'          => 'required',
                    'total_stones_price'        => 'required',
                    'total_diamond_price'       => 'required',
                    'other_amount'              => 'required',
                    'gold_rate'                 => 'required',
                    'total_gold_price'          => 'required',
                    'total_amount'              => 'required',
                    'beadDetail'                => 'required',
                    'stonesDetail'               => 'required',
                    'diamondDetail'             => 'required'
                ],
                $this->validationMessage()
            );
        } else {
            $validation = Validator::make(
                $request->all(),
                [
                    'tag_no'                    => 'required',
                    'warehouse_id'              => 'required',
                    'picture'                   => 'required|image|mimes:jpeg,png,jpg,gif'
                ],
                $this->validationMessage()
            );
        }
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
                return  $this->success(
                    config("enum.saved"),
                    $finish_product
                );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    public function show($id)
    {
        abort_if(Gate::denies('tagging_product_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $finish_product = $this->finish_product_service->getById($id);
        $finish_product_bead = $this->finish_product_service->getBeadByFinishProductId($id);
        $finish_product_stone = $this->finish_product_service->getStoneByFinishProductId($id);
        $finish_product_diamond = $this->finish_product_service->getDiamondByFinishProductId($id);
        return view('finish_product.view', compact(
            'finish_product',
            'finish_product_bead',
            'finish_product_stone',
            'finish_product_diamond'
        ));
    }
    public function beadByFinishProductId($finish_product)
    {
        $finish_product_bead = $this->finish_product_service->getBeadByFinishProductId($finish_product);
        if ($finish_product_bead)
            return $this->success(
                config('enum.success'),
                $finish_product_bead,
                false
            );
    }

    public function stoneByFinishProductId($finish_product)
    {
        $finish_product_stone = $this->finish_product_service->getStoneByFinishProductId($finish_product);
        if ($finish_product_stone)
            return $this->success(
                config('enum.success'),
                $finish_product_stone,
                false
            );
    }

    public function diamondByFinishProductId($finish_product)
    {
        $finish_product_diamond = $this->finish_product_service->getDiamondByFinishProductId($finish_product);
        if ($finish_product_diamond)
            return $this->success(
                config('enum.success'),
                $finish_product_diamond,
                false
            );
    }
    public function getByTagNoJson($tag_no)
    {
        $finish_product = $this->finish_product_service->getByTagNo($tag_no);
        if ($finish_product)
            return $this->success(
                config('enum.success'),
                $finish_product,
                false
            );

        return $this->error(
            'Product Not Found!',

        );
    }


    public function status($id)
    {
        abort_if(Gate::denies('tagging_product_status'), Response::HTTP_FORBIDDEN, '403 Forbidden');
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
        abort_if(Gate::denies('tagging_product_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
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
