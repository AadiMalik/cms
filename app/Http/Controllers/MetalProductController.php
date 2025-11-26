<?php

namespace App\Http\Controllers;

use App\Models\MetalProduct;
use App\Services\Concrete\BeadTypeService;
use App\Services\Concrete\MetalProductService;
use App\Services\Concrete\ProductService;
use App\Services\Concrete\WarehouseService;
use App\Services\Concrete\CommonService;
use App\Services\Concrete\DiamondClarityService;
use App\Services\Concrete\DiamondColorService;
use App\Services\Concrete\DiamondCutService;
use App\Services\Concrete\DiamondTypeService;
use App\Services\Concrete\StoneCategoryService;
use App\Traits\JsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Picqer\Barcode\BarcodeGeneratorPNG;

class MetalProductController extends Controller
{
    use JsonResponse;
    protected $metal_product_service;
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
        MetalProductService $metal_product_service,
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
        $this->metal_product_service = $metal_product_service;
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
        abort_if(Gate::denies('tagging_metal_product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $metal_product = $this->metal_product_service->getAllActiveMetalProduct();
        return view('metal_product.index', compact('metal_product'));
    }
    public function getData(Request $request)
    {
        abort_if(Gate::denies('tagging_metal_product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return $this->metal_product_service->getMetalProductSource();
    }

    public function create()
    {
        abort_if(Gate::denies('tagging_metal_product_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $products = $this->product_service->getAllActiveProduct();
        $warehouses = $this->warehouse_service->getAll();
        $bead_types = $this->bead_type_service->getAllActive();
        $stone_categories = $this->stone_category_service->getAllActive();
        $diamond_types = $this->diamond_type_service->getAllActive();
        $diamond_colors = $this->diamond_color_service->getAllActive();
        $diamond_cuts = $this->diamond_cut_service->getAllActive();
        $diamond_clarities = $this->diamond_clarity_service->getAllActive();
        $parent_tag = $this->common_service->generateParentMetalProductTagNo();
        $parents = $this->metal_product_service->getAllActiveParentMetalProduct();
        return view('metal_product.create', compact(
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
        abort_if(Gate::denies('tagging_metal_product_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($request->is_parent != 1) {
            $validation = Validator::make(
                $request->all(),
                [
                    'tag_no'                    => 'required',
                    'product_id'                => 'required',
                    'warehouse_id'              => 'required',
                    'picture'                   => 'required|image|mimes:jpeg,png,jpg,gif',
                    'purity'                    => 'required',
                    'metal'                     => 'required',
                    'metal_rate'                => 'required',
                    'scale_weight'              => 'required',
                    'bead_weight'               => 'required',
                    'stones_weight'             => 'required',
                    'diamond_weight'            => 'required',
                    'net_weight'                => 'required',
                    'gross_weight'              => 'required',
                    'total_metal_amount'        => 'required',
                    'total_bead_amount'         => 'required',
                    'total_stones_amount'       => 'required',
                    'total_diamond_amount'      => 'required',
                    'other_charges'             => 'required',
                    'total_amount'              => 'required',
                    'beadDetail'                => 'required',
                    'stonesDetail'              => 'required',
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
            $metal_product = $this->metal_product_service->save($obj);

            DB::commit();
            if ($metal_product)
                return  $this->success(
                    config("enum.saved"),
                    $metal_product
                );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    public function show($id)
    {
        abort_if(Gate::denies('tagging_metal_product_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $metal_product = $this->metal_product_service->getById($id);
        $metal_product_bead = $this->metal_product_service->getBeadByMetalProductId($id);
        $metal_product_stone = $this->metal_product_service->getStoneByMetalProductId($id);
        $metal_product_diamond = $this->metal_product_service->getDiamondByMetalProductId($id);
        return view('metal_product.view', compact(
            'metal_product',
            'metal_product_bead',
            'metal_product_stone',
            'metal_product_diamond'
        ));
    }
    public function beadByMetalProductId($metal_product)
    {
        $metal_product_bead = $this->metal_product_service->getBeadByMetalProductId($metal_product);
        if ($metal_product_bead)
            return $this->success(
                config('enum.success'),
                $metal_product_bead,
                false
            );
    }

    public function stoneByMetalProductId($metal_product)
    {
        $metal_product_stone = $this->metal_product_service->getStoneByMetalProductId($metal_product);
        if ($metal_product_stone)
            return $this->success(
                config('enum.success'),
                $metal_product_stone,
                false
            );
    }

    public function diamondByMetalProductId($metal_product)
    {
        $metal_product_diamond = $this->metal_product_service->getDiamondByMetalProductId($metal_product);
        if ($metal_product_diamond)
            return $this->success(
                config('enum.success'),
                $metal_product_diamond,
                false
            );
    }
    public function getByTagNoJson($tag_no)
    {
        $metal_product = $this->metal_product_service->getByTagNo($tag_no);
        if ($metal_product)
            return $this->success(
                config('enum.success'),
                $metal_product,
                false
            );

        return $this->error(
            'Product Not Found!',

        );
    }


    public function status($id)
    {
        abort_if(Gate::denies('tagging_metal_product_status'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $metal_product = $this->metal_product_service->statusById($id);

            if ($metal_product)
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
        abort_if(Gate::denies('tagging_metal_product_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $metal_product = $this->metal_product_service->deleteById($id);

            if ($metal_product)
                return $this->success(
                    config('enum.delete'),
                    []

                );
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function print(Request $request)
    {
        abort_if(Gate::denies('tagging_metal_product_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $metal_products = $this->metal_product_service->getByIds($request->tag_products);
        // dd($metal_products);
        return view('metal_product.print', compact(
            'metal_products'
        ));
    }

    public function update(Request $request)
    {
        abort_if(Gate::denies('tagging_metal_product_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $obj = $request->all();
        try {
            $metal_product = $this->metal_product_service->updateLocation($obj);
            if ($metal_product)
                return $this->success(
                    config('enum.success'),
                    [],
                    false

                );
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
    public function updatePicture(Request $request)
    {
        abort_if(Gate::denies('tagging_metal_product_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $validator = Validator::make($request->all(), [
            'id'        => 'required',
            'picture'   => 'required|image|mimes:jpeg,png,jpg,gif'
        ]);

        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            $obj = $request->all();
            $filenames = null;
            if ($request->hasFile('picture')) {
                $file = $request->file('picture');
                $filename = time() . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('pictures'), $filename);
                $filenames = 'pictures/' . $filename;
                $obj['picture'] = $filenames;
            }
            $metal_product = $this->metal_product_service->updatePicture($obj);
            if ($metal_product)
                return redirect()->back();
        } catch (Exception $e) {
            return redirect()->back();
        }
    }

    public function getByDate(Request $request)
    {
        $obj = $request->all();
        $metal_product = $this->metal_product_service->getMetalProductByDate($obj);
        if ($metal_product)
            return $this->success(
                config('enum.success'),
                $metal_product
            );

        return $this->error(
            'Product Not Found!',
        );
    }

    public function search()
    {
        $tags = $this->metal_product_service->getActiveMetalProduct();
        return view('metal_product.search', compact('tags'));
    }

    public function getSearch($id)
    {
        abort_if(Gate::denies('tagging_metal_product_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $metal_product = $this->metal_product_service->getById($id);
        $metal_product_bead = $this->metal_product_service->getBeadByMetalProductId($id);
        $metal_product_stone = $this->metal_product_service->getStoneByMetalProductId($id);
        $metal_product_diamond = $this->metal_product_service->getDiamondByMetalProductId($id);
        $data = [
            'metal_product' => $metal_product,
            'metal_product_bead' => $metal_product_bead,
            'metal_product_stone' => $metal_product_stone,
            'metal_product_diamond' => $metal_product_diamond
        ];
        return $this->success('Success', $data, false);
    }
}
