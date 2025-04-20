<?php

namespace App\Http\Controllers;

use App\Services\Concrete\AccountService;
use App\Services\Concrete\CommonService;
use App\Services\Concrete\DiamondClarityService;
use App\Services\Concrete\DiamondColorService;
use App\Services\Concrete\DiamondCutService;
use App\Services\Concrete\DiamondPurchaseService;
use App\Services\Concrete\DiamondTypeService;
use App\Services\Concrete\SupplierService;
use App\Services\Concrete\WarehouseService;
use App\Traits\JsonResponse;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use PDF;

class DiamondPurchaseController extends Controller
{
    use JsonResponse;
    protected $account_service;
    protected $supplier_service;
    protected $diamond_purchase_service;
    protected $diamond_type_service;
    protected $diamond_cut_service;
    protected $diamond_color_service;
    protected $diamond_clarity_service;
    protected $warehouse_service;
    protected $common_service;

    public function __construct(
        DiamondPurchaseService $diamond_purchase_service,
        SupplierService $supplier_service,
        AccountService $account_service,
        DiamondTypeService $diamond_type_service,
        DiamondCutService $diamond_cut_service,
        DiamondColorService $diamond_color_service,
        DiamondClarityService $diamond_clarity_service,
        WarehouseService $warehouse_service,
        CommonService $common_service
    ) {
        $this->diamond_purchase_service = $diamond_purchase_service;
        $this->account_service = $account_service;
        $this->supplier_service = $supplier_service;
        $this->diamond_type_service = $diamond_type_service;
        $this->diamond_cut_service = $diamond_cut_service;
        $this->diamond_color_service = $diamond_color_service;
        $this->diamond_clarity_service = $diamond_clarity_service;
        $this->warehouse_service = $warehouse_service;
        $this->common_service = $common_service;
    }
    public function index()
    {
        abort_if(Gate::denies('diamond_purchase_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $suppliers = $this->supplier_service->getAllActiveSupplier();
        return view('purchases/diamond_purchase.index', compact('suppliers'));
    }
    public function getData(Request $request)
    {
        abort_if(Gate::denies('diamond_purchase_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
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
            return $this->diamond_purchase_service->getSource($obj);
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }
    public function create()
    {
        abort_if(Gate::denies('diamond_purchase_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $diamond_purchase = $this->diamond_purchase_service->saveDiamondPurchase();
        $diamond_types = $this->diamond_type_service->getAllActive();
        $diamond_cuts = $this->diamond_cut_service->getAllActive();
        $diamond_colors = $this->diamond_color_service->getAllActive();
        $diamond_clarity = $this->diamond_clarity_service->getAllActive();
        $accounts = $this->account_service->getAllActiveChild();
        $suppliers = $this->supplier_service->getAllActiveSupplier();
        $warehouses = $this->warehouse_service->getAll();
        return view('purchases/diamond_purchase.create', compact(
            'diamond_purchase',
            'diamond_types',
            'diamond_cuts',
            'diamond_colors',
            'diamond_clarity',
            'warehouses',
            'accounts',
            'suppliers'
        ));
    }
    public function store(Request $request)
    {
        abort_if(Gate::denies('diamond_purchase_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $validation = Validator::make(
            $request->all(),
            [
                'id'                    => 'required',
                'diamond_purchase_date'   => 'required',
                'supplier_id'           => 'required',
                'warehouse_id'          => 'required',
                'purchase_account_id'   => 'required',
                'total'                 => 'required',
                'diamondProductDetail'    => 'required'
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
            $diamond_purchase = $this->diamond_purchase_service->save($obj);
            return  $this->success(
                config("enum.saved"),
                $diamond_purchase
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }


    public function print($id)
    {
        abort_if(Gate::denies('diamond_purchase_print'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {

            $diamond_purchase =  $this->diamond_purchase_service->getById($id);
            $diamond_purchase_detail = $this->diamond_purchase_service->diamondPurchaseDetail($id);

            $pdf = PDF::loadView('/purchases/diamond_purchase/partials.print', compact('diamond_purchase', 'other_purchase_detail'));
            return $pdf->stream();
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }


    public function unpost($id)
    {
        abort_if(Gate::denies('diamond_purchase_unpost'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $this->diamond_purchase_service->unpost($id);
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
        abort_if(Gate::denies('diamond_purchase_post'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $diamond_purchase = $this->diamond_purchase_service->post($request->all());
            if ($diamond_purchase != 'true') {
                return $this->error(
                    $diamond_purchase
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
        abort_if(Gate::denies('diamond_purchase_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $diamond_purchase = $this->diamond_purchase_service->deleteById($id);
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
