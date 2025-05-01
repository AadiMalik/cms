<?php

namespace App\Http\Controllers;

use App\Services\Concrete\AccountService;
use App\Services\Concrete\CommonService;
use App\Services\Concrete\CustomerService;
use App\Services\Concrete\OtherProductService;
use App\Services\Concrete\DiamondSaleService;
use App\Services\Concrete\DiamondTypeService;
use App\Services\Concrete\DiamondClarityService;
use App\Services\Concrete\DiamondColorService;
use App\Services\Concrete\DiamondCutService;
use App\Services\Concrete\WarehouseService;
use App\Traits\JsonResponse;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class DiamondSaleController extends Controller
{
    use JsonResponse;
    protected $diamond_sale_service;
    protected $account_service;
    protected $customer_service;
    protected $diamond_type_service;
    protected $diamond_cut_service;
    protected $diamond_color_service;
    protected $diamond_clarity_service;
    protected $warehouse_service;
    protected $common_service;

    public function __construct(
        DiamondSaleService $diamond_sale_service,
        CustomerService $customer_service,
        AccountService $account_service,
        DiamondTypeService $diamond_type_service,
        DiamondCutService $diamond_cut_service,
        DiamondColorService $diamond_color_service,
        DiamondClarityService $diamond_clarity_service,
        WarehouseService $warehouse_service,
        CommonService $common_service
    ) {
        $this->diamond_sale_service = $diamond_sale_service;
        $this->account_service = $account_service;
        $this->customer_service = $customer_service;
        $this->diamond_type_service = $diamond_type_service;
        $this->diamond_cut_service = $diamond_cut_service;
        $this->diamond_color_service = $diamond_color_service;
        $this->diamond_clarity_service = $diamond_clarity_service;
        $this->warehouse_service = $warehouse_service;
        $this->common_service = $common_service;
    }
    public function index()
    {
        abort_if(Gate::denies('diamond_sale_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $customers = $this->customer_service->getAllActiveCustomer();
        $accounts = $this->account_service->getAllActiveChild();
        return view('diamond_sale.index', compact('customers', 'accounts'));
    }
    public function getData(Request $request)
    {
        abort_if(Gate::denies('diamond_sale_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
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
            return $this->diamond_sale_service->getSource($obj);
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }
    public function create()
    {
        abort_if(Gate::denies('diamond_sale_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $diamond_sale = $this->diamond_sale_service->saveDiamondSale();
        $diamond_types = $this->diamond_type_service->getAllActive();
        $diamond_cuts = $this->diamond_cut_service->getAllActive();
        $diamond_colors = $this->diamond_color_service->getAllActive();
        $diamond_clarity = $this->diamond_clarity_service->getAllActive();
        $warehouses = $this->warehouse_service->getAll();
        return view('diamond_sale.create', compact(
            'diamond_sale',
            'diamond_types',
            'diamond_cuts',
            'diamond_colors',
            'diamond_clarity',
            'warehouses'
        ));
    }
    public function store(Request $request)
    {
        abort_if(Gate::denies('diamond_sale_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $validation = Validator::make(
            $request->all(),
            [
                'id'             => 'required',
                'diamond_sale_date'      => 'required',
                'customer_id'    => 'required',
                'warehouse_id'    => 'required',
                'is_pkr'          => 'required',
                'total'          => 'required',
                'total_dollar'          => 'required',
                'diamondProductDetail'  => 'required'
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
            $diamond_sale = $this->diamond_sale_service->save($obj);
            return  $this->success(
                config("enum.saved"),
                $diamond_sale
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }


    public function print($id)
    {
        abort_if(Gate::denies('diamond_sale_print'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {

            $diamond_sale =  $this->diamond_sale_service->getById($id);
            $diamond_sale_detail = $this->diamond_sale_service->diamondSaleDetail($id);


            return view('diamond_sale/partials.print', compact('diamond_sale', 'diamond_sale_detail'));
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }


    public function unpost($id)
    {
        abort_if(Gate::denies('diamond_sale_unpost'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $this->diamond_sale_service->unpost($id);
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
        abort_if(Gate::denies('diamond_sale_post'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $diamond_sale = $this->diamond_sale_service->post($request->all());
            if ($diamond_sale != 'true') {
                return $this->error(
                    $diamond_sale
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
        abort_if(Gate::denies('diamond_sale_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $diamond_sale = $this->diamond_sale_service->deleteById($id);
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
