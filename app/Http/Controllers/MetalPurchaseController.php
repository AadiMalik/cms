<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Concrete\AccountService;
use App\Services\Concrete\CommonService;
use App\Services\Concrete\ProductService;
use App\Services\Concrete\SupplierService;
use App\Services\Concrete\BeadTypeService;
use App\Services\Concrete\CompanySettingService;
use App\Services\Concrete\DiamondClarityService;
use App\Services\Concrete\DiamondColorService;
use App\Services\Concrete\DiamondCutService;
use App\Services\Concrete\DiamondTypeService;
use App\Services\Concrete\JobPurchaseService;
use App\Services\Concrete\MetalPurchaseService;
use App\Services\Concrete\PurchaseOrderService;
use App\Services\Concrete\StoneCategoryService;
use App\Traits\JsonResponse;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class MetalPurchaseController extends Controller
{
    use JsonResponse;
    protected $account_service;
    protected $supplier_service;
    protected $product_service;
    protected $metal_purchase_service;
    protected $common_service;
    protected $bead_type_service;
    protected $stone_category_service;
    protected $diamond_type_service;
    protected $diamond_color_service;
    protected $diamond_cut_service;
    protected $diamond_clarity_service;
    protected $job_purchase_service;
    protected $company_setting_service;
    protected $purchase_order_service;

    public function __construct(
        SupplierService $supplier_service,
        AccountService $account_service,
        ProductService $product_service,
        MetalPurchaseService $metal_purchase_service,
        CommonService $common_service,
        BeadTypeService $bead_type_service,
        StoneCategoryService $stone_category_service,
        DiamondTypeService $diamond_type_service,
        DiamondColorService $diamond_color_service,
        DiamondCutService $diamond_cut_service,
        DiamondClarityService $diamond_clarity_service,
        JobPurchaseService $job_purchase_service,
        CompanySettingService $company_setting_service,
        PurchaseOrderService $purchase_order_service
    ) {
        $this->account_service = $account_service;
        $this->supplier_service = $supplier_service;
        $this->product_service = $product_service;
        $this->metal_purchase_service = $metal_purchase_service;
        $this->common_service = $common_service;
        $this->bead_type_service = $bead_type_service;
        $this->stone_category_service = $stone_category_service;
        $this->diamond_type_service = $diamond_type_service;
        $this->diamond_color_service = $diamond_color_service;
        $this->diamond_cut_service = $diamond_cut_service;
        $this->diamond_clarity_service = $diamond_clarity_service;
        $this->job_purchase_service = $job_purchase_service;
        $this->company_setting_service = $company_setting_service;
        $this->purchase_order_service = $purchase_order_service;
    }

    public function index()
    {
        abort_if(Gate::denies('metal_purchase_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $suppliers = $this->supplier_service->getAllActiveSupplier();
        $setting = $this->company_setting_service->getSetting();
        $accounts = $this->account_service->getAllActiveChild();
        return view('purchases.metal_purchase.index', compact('suppliers','setting','accounts'));
    }
    public function getData(Request $request)
    {
        abort_if(Gate::denies('metal_purchase_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $end = $request['end_date'] ?? Carbon::now()->addDay(1);
            $start = $request['start_date'] ?? Carbon::now()->subDay(1);
            $supplier_id = $request['supplier_id'] ?? '';
            $posted = $request['posted'] ?? '';
            $obj = [
                "supplier_id" => $supplier_id,
                "end" => $end,
                "start" => $start,
                "posted" => $posted,
            ];
            return $this->metal_purchase_service->getMetalPurchaseSource($obj);
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }
    public function create()
    {
        abort_if(Gate::denies('metal_purchase_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $suppliers = $this->supplier_service->getAllActiveSupplier();
        $products = $this->product_service->getAllActiveProduct();
        $metal_purchase = $this->metal_purchase_service->saveMetalPurchase();
        $bead_types = $this->bead_type_service->getAllActive();
        $stone_categories = $this->stone_category_service->getAllActive();
        $diamond_types = $this->diamond_type_service->getAllActive();
        $diamond_colors = $this->diamond_color_service->getAllActive();
        $diamond_cuts = $this->diamond_cut_service->getAllActive();
        $diamond_clarities = $this->diamond_clarity_service->getAllActive();
        $purchase_orders = $this->purchase_order_service->getAllPurchaseOrder();
        return view('purchases.metal_purchase.create', compact(
            'suppliers',
            'products',
            'metal_purchase',
            'bead_types',
            'stone_categories',
            'diamond_types',
            'diamond_colors',
            'diamond_cuts',
            'diamond_clarities',
            'purchase_orders'
        ));
    }

    // Bead Weight
    public function getBeadWeight($metal_purchase_detail_id)
    {
        try {
            $metal_purchase_beads = $this->metal_purchase_service->getBeadWeight($metal_purchase_detail_id);
            return $this->success(
                config('enum.success'),
                $metal_purchase_beads,
                false
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    // Stone Weight
    public function getStoneWeight($metal_purchase_detail_id)
    {
        try {
            $metal_purchase_stones = $this->metal_purchase_service->getStoneWeight($metal_purchase_detail_id);
            return $this->success(
                config('enum.success'),
                $metal_purchase_stones,
                false
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    // Diamond Carat
    public function getDiamondCarat($metal_purchase_detail_id)
    {
        try {
            $metal_purchase_diamonds = $this->metal_purchase_service->getDiamondCarat($metal_purchase_detail_id);
            return $this->success(
                config('enum.success'),
                $metal_purchase_diamonds,
                false
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }
    
    // Metal Purchase Store
    public function store(Request $request)
    {
        // dd($request->all());
        abort_if(Gate::denies('metal_purchase_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $validation = Validator::make(
            $request->all(),
            [
                'id'                => 'required',
                'purchase_date'     => 'required',
                'supplier_id'       => 'required',
                'reference'         => 'required',
                'pictures.*'        => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'purchaseDetail'    => 'required',
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
            $filenames = [];
            if ($request->hasFile('pictures')) {
                foreach ($request->file('pictures') as $file) {
                    $filename = time() . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('pictures'), $filename);
                    $filenames[] = 'pictures/' . $filename;
                }
            }
            $obj = [
                "id" => $request->id,
                "purchase_date" => $request->purchase_date ?? Null,
                "supplier_id" => $request->supplier_id ?? Null,
                "paid" => ($request->paid != '') ? $request->paid : 0,
                "paid_dollar" => ($request->paid_dollar != '') ? $request->paid_dollar : 0,
                "reference" => $request->reference ?? Null,
                "pictures" => $filenames ?? Null,
                "purchase_order_id" => $request->purchase_order_id ?? Null,
                "purchaseDetail" => $request->purchaseDetail
            ];

            $metal_purchase = $this->metal_purchase_service->updateMetalPurchase($obj, $request->id);

            return $this->success(
                config('enum.saved'),
                []
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }


    public function edit($id)
    {
        abort_if(Gate::denies('metal_purchase_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $suppliers = $this->supplier_service->getAllActiveSupplier();
        $products = $this->product_service->getAllActiveProduct();
        $bead_types = $this->bead_type_service->getAllActive();
        $stone_categories = $this->stone_category_service->getAllActive();
        $diamond_types = $this->diamond_type_service->getAllActive();
        $diamond_colors = $this->diamond_color_service->getAllActive();
        $diamond_cuts = $this->diamond_cut_service->getAllActive();
        $diamond_clarities = $this->diamond_clarity_service->getAllActive();
        $metal_purchase = $this->metal_purchase_service->getMetalPurchaseById($id);
        $purchase_orders = $this->purchase_order_service->getAllPurchaseOrder();
        return view('purchases.metal_purchase.create', compact(
            'suppliers',
            'products',
            'metal_purchase',
            'bead_types',
            'stone_categories',
            'diamond_types',
            'diamond_colors',
            'diamond_cuts',
            'diamond_clarities',
            'purchase_orders'
        ));
    }


    public function metalPurchaseDetail($raat_kaat_id)
    {
        try {
            $metal_purchase_detail = $this->metal_purchase_service->getMetalPurchaseDetail($raat_kaat_id);
            return $this->success(
                config('enum.success'),
                $metal_purchase_detail,
                false
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    // Metal Post
    public function postMetalPurchase(Request $request)
    {
        abort_if(Gate::denies('metal_purchase_post'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $metal_purchase_post = $this->metal_purchase_service->postMetalPurchase($request->all());
            if ($metal_purchase_post != 'true') {
                return $this->validationResponse(
                    $metal_purchase_post
                );
            }
            return $this->success(
                config('anum.posted'),
                [],
                true
            );
        } catch (Exception $e) {
            return $this->error(config('anum.error'));
        }
    }
    public function unpostMetalPurchase($id)
    {
        abort_if(Gate::denies('metal_purchase_post'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $response = $this->metal_purchase_service->unpostMetalPurchaseById($id);
            return $this->success(
                config('enum.unposted'),
                $response,
                true
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'),);
        }
    }
    public function destroy($id)
    {
        abort_if(Gate::denies('metal_purchase_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $response = $this->metal_purchase_service->deleteMetalPurchaseById($id);
            return $this->success(
                config('enum.delete'),
                $response,
                true
            );
        } catch (Exception $e) {
            return $this->error(config('enum.noDelete'),);
        }
    }

    public function getMetalPurchaseByProductId($product_id)
    {

        try {
            $product = $this->product_service->getProductById($product_id);
            $metal_purchases = $this->metal_purchase_service->getMetalPurchaseByProductId($product_id);
            // $job_purchase = $this->job_purchase_service->getJobPurchaseByProductId($product_id);
            $tag_no = $this->common_service->generateFinishProductTagNo($product->prefix);
            $data = [
                "metal_purchase" => $metal_purchases,
                // "job_purchase" => $job_purchase,
                "tag_no" => $tag_no
            ];
            return $this->success(
                config('enum.success'),
                $data
            );
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function getMetalPurchaseDetailById($detail_id)
    {
        try {
            $response = $this->metal_purchase_service->getMetalPurchaseDetailById($detail_id);
            return $this->success(
                config('enum.success'),
                $response,
                true
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'),);
        }
    }
}
