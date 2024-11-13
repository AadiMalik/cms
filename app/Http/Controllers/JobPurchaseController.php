<?php

namespace App\Http\Controllers;

use App\Services\Concrete\AccountService;
use App\Services\Concrete\BeadTypeService;
use App\Services\Concrete\CommonService;
use App\Services\Concrete\CompanySettingService;
use App\Services\Concrete\DiamondClarityService;
use App\Services\Concrete\DiamondColorService;
use App\Services\Concrete\DiamondCutService;
use App\Services\Concrete\DiamondTypeService;
use App\Services\Concrete\JobPurchaseService;
use App\Services\Concrete\JobTaskService;
use App\Services\Concrete\PurchaseOrderService;
use App\Services\Concrete\StoneCategoryService;
use App\Services\Concrete\SupplierService;
use App\Traits\JsonResponse;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobPurchaseController extends Controller
{
    use JsonResponse;
    protected $job_purchase_service;
    protected $account_service;
    protected $supplier_service;
    protected $job_task_service;
    protected $common_service;
    protected $bead_type_service;
    protected $stone_category_service;
    protected $diamond_type_service;
    protected $diamond_color_service;
    protected $diamond_cut_service;
    protected $diamond_clarity_service;
    protected $company_setting_service;

    public function __construct(
        JobPurchaseService $job_purchase_service,
        SupplierService $supplier_service,
        AccountService $account_service,
        JobTaskService $job_task_service,
        CommonService $common_service,
        BeadTypeService $bead_type_service,
        StoneCategoryService $stone_category_service,
        DiamondTypeService $diamond_type_service,
        DiamondColorService $diamond_color_service,
        DiamondCutService $diamond_cut_service,
        DiamondClarityService $diamond_clarity_service,
        CompanySettingService $company_setting_service
    ) {
        $this->job_purchase_service = $job_purchase_service;
        $this->account_service = $account_service;
        $this->supplier_service = $supplier_service;
        $this->job_task_service = $job_task_service;
        $this->common_service = $common_service;
        $this->bead_type_service = $bead_type_service;
        $this->stone_category_service = $stone_category_service;
        $this->diamond_type_service = $diamond_type_service;
        $this->diamond_color_service = $diamond_color_service;
        $this->diamond_cut_service = $diamond_cut_service;
        $this->diamond_clarity_service = $diamond_clarity_service;
        $this->company_setting_service = $company_setting_service;
    }
    public function index()
    {
        $suppliers = $this->supplier_service->getAllActiveSupplier();
        $accounts = $this->account_service->getAllActiveChild();
        $setting = $this->company_setting_service->getSetting();
        return view('purchases/job_purchase.index', compact('suppliers', 'accounts','setting'));
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
            return $this->job_purchase_service->getSource($obj);
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }
    public function create($job_task_id)
    {
        $job_purchase_no = $this->common_service->generateJobPurchaseNo();
        $job_task_detail = $this->job_task_service->JobTaskDetail($job_task_id);
        $supplier = $this->supplier_service->getById($job_task_detail[0]['supplier_id']);
        $bead_types = $this->bead_type_service->getAllActive();
        $stone_categories = $this->stone_category_service->getAllActive();
        $diamond_types = $this->diamond_type_service->getAllActive();
        $diamond_colors = $this->diamond_color_service->getAllActive();
        $diamond_cuts = $this->diamond_cut_service->getAllActive();
        $diamond_clarities = $this->diamond_clarity_service->getAllActive();
        return view('purchases/job_purchase.create', compact(
            'job_purchase_no',
            'job_task_detail',
            'bead_types',
            'stone_categories',
            'diamond_types',
            'diamond_colors',
            'diamond_cuts',
            'diamond_clarities',
            'supplier'
        ));
    }
    public function store(Request $request)
    {
        $validation = Validator::make(
            $request->all(),
            [
                'job_purchase_date'     => 'required',
                'purchase_order_id'     => 'required',
                'supplier_id'           => 'required',
                'total_au'              => 'required',
                'productDetail'         => 'required'
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
            $obj['job_purchase_no']= $this->common_service->generateJobPurchaseNo();
            $sale = $this->job_purchase_service->save($obj);
            if($sale!='true'){
                return  $this->error(
                    config("enum.error")
                );
            }
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

            $job_purchase =  $this->job_purchase_service->getById($id);
            $job_purchase_detail = $this->job_purchase_service->jobPurchaseDetail($id);


            return view('purchases/job_purchase/partials.print', compact('sale', 'sale_detail'));
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }


    public function unpost($id)
    {
        try {
            $this->job_purchase_service->unpost($id);
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
        try {
            $sale = $this->job_purchase_service->post($request->all());
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
            $sale = $this->job_purchase_service->deleteById($id);
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
