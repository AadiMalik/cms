<?php

namespace App\Http\Controllers;

use App\ExcelExports\ReportExport;
use App\Services\Concrete\AccountService;
use App\Services\Concrete\CustomerService;
use App\Services\Concrete\FinishProductService;
use App\Services\Concrete\JournalEntryService;
use App\Services\Concrete\OtherProductService;
use App\Services\Concrete\ProductService;
use App\Services\Concrete\ReportService;
use App\Services\Concrete\SupplierService;
use App\Services\Concrete\WarehouseService;
use App\Traits\JsonResponse;
use PDF;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    use JsonResponse;
    #region Class Fields & Propertities

    protected $report_service;
    protected $account_service;
    protected $journal_entry_service;
    protected $supplier_service;
    protected $customer_service;
    protected $finish_product_service;
    protected $product_service;
    protected $warehouse_service;
    protected $other_product_service;

    #endregion

    #region Constructor

    public function __construct(
        ReportService $report_service,
        AccountService  $account_service,
        SupplierService $supplier_service,
        JournalEntryService $journal_entry_service,
        CustomerService $customer_service,
        FinishProductService $finish_product_service,
        ProductService $product_service,
        WarehouseService $warehouse_service,
        OtherProductService $other_product_service
    ) {
        $this->report_service = $report_service;
        $this->account_service = $account_service;
        $this->journal_entry_service = $journal_entry_service;
        $this->supplier_service = $supplier_service;
        $this->customer_service = $customer_service;
        $this->finish_product_service = $finish_product_service;
        $this->product_service = $product_service;
        $this->warehouse_service = $warehouse_service;
        $this->other_product_service = $other_product_service;
    }


    // Ledger Report
    public function ledgerReport()
    {
        try {
            $accounts = $this->account_service->getAllActiveChild();
            $suppliers = $this->supplier_service->getAllActiveSupplier();
            $customers = $this->customer_service->getAllActiveCustomer();
            return view('reports/ledger/index', compact('accounts', 'suppliers', 'customers'));
        } catch (Exception $e) {
            return back()->with('error', config('enum.error'));
        }
    }
    public function getPreviewLedgerReport(Request $request)
    {
        $validation = Validator::make(
            $request->all(),
            [
                'start_date' => 'required',
                'end_date' => 'required',
                'currency' => 'required',
            ]
        );
        if ($validation->fails()) {
            $validation_error = "";
            foreach ($validation->errors()->all() as $message) {
                $validation_error .= $message;
            }
            return $this->error(
                $validation_error
            );
        }
        try {
            $obj = $request->all();
            $parms['data'] = $this->report_service->ledgerReport($obj);
            $parms = (object)$parms;
            $parms->start_date = $request->start_date;
            $parms->end_date = $request->end_date;
            if ($request->supplier_id != '' && $request->supplier_id != null) {
                $supplier = $this->supplier_service->getById($request->supplier_id);
                $parms->supplier = $supplier->name ?? '';
            }
            if ($request->customer_id != '' && $request->customer_id != null) {
                $customer = $this->customer_service->getById($request->customer_id);
                $parms->customer = $customer->name ?? '';
            }
            $parms->currency = ($request->currency == 0) ? 'PKR (Rs)' : (($request->currency == 1) ? 'Gold (AU)' : 'Dollar ($)');
            $parms->report_name = "ledger_report";
            return view('/reports/ledger/partials.report', compact('parms'));
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }
    public function getLedgerReport(Request $request)
    {
        try {
            $obj = $request->all();
            $parms['data'] = $this->report_service->ledgerReport($obj);
            $parms = (object)$parms;
            $parms->start_date = $request->start_date;
            $parms->end_date = $request->end_date;
            if ($request->supplier_id != '' && $request->supplier_id != null) {
                $supplier = $this->supplier_service->getById($request->supplier_id);
                $parms->supplier = $supplier->name ?? '';
            }
            if ($request->customer_id != '' && $request->customer_id != null) {
                $customer = $this->customer_service->getById($request->customer_id);
                $parms->customer = $customer->name ?? '';
            }
            $parms->currency = ($request->currency == 0) ? 'PKR (Rs)' : (($request->currency == 1) ? 'Gold (AU)' : 'Dollar ($)');
            $parms->report_name = "ledger_report";
            if ($request->has('export-excel')) {
                return Excel::download(new ReportExport($parms), 'Ledger-Report.xls');
            }
            $pdf = PDF::loadView('/reports/ledger/partials.report', compact('parms'));
            return $pdf->stream('Ledger Report' . $request->start_date . '-' . $request->end_date . '.pdf');
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }


    // Tag History Report
    public function tagHistoryReport()
    {
        try {
            $finish_products = $this->finish_product_service->getAllSaledFinishProduct();
            $products = $this->product_service->getAllProduct();
            $warehouses = $this->warehouse_service->getAll();
            return view('reports/tag_history/index', compact('finish_products', 'products', 'warehouses'));
        } catch (Exception $e) {
            return back()->with('error', config('enum.error'));
        }
    }
    public function getPreviewTagHistoryReport(Request $request)
    {
        $validation = Validator::make(
            $request->all(),
            [
                'start_date' => 'required',
                'end_date' => 'required',
            ]
        );
        if ($validation->fails()) {
            $validation_error = "";
            foreach ($validation->errors()->all() as $message) {
                $validation_error .= $message;
            }
            return $this->error(
                $validation_error
            );
        }
        try {
            $obj = $request->all();
            $parms['data'] = $this->report_service->tagHistoryReport($obj);
            $parms = (object)$parms;
            $parms->start_date = $request->start_date;
            $parms->end_date = $request->end_date;
            if ($request->finish_product_id != '' && $request->finish_product_id != null) {
                $tag_no = $this->finish_product_service->getById($request->finish_product_id);
                $parms->tag_no = $tag_no->tag_no ?? '';
            }
            if ($request->product_id != '' && $request->product_id != null) {
                $product = $this->product_service->getProductById($request->product_id);
                $parms->product = $product->name ?? '';
            }
            if ($request->warehouse_id != '' && $request->warehouse_id != null) {
                $warehouse = $this->warehouse_service->getById($request->warehouse_id);
                $parms->warehouse = $warehouse->name ?? '';
            }
            $parms->report_name = "tag_history_report";
            return view('/reports/tag_history/partials.report', compact('parms'));
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }
    public function getTagHistoryReport(Request $request)
    {
        try {
            $obj = $request->all();
            $parms['data'] = $this->report_service->tagHistoryReport($obj);
            $parms = (object)$parms;
            $parms->start_date = $request->start_date;
            $parms->end_date = $request->end_date;
            if ($request->finish_product_id != '' && $request->finish_product_id != null) {
                $tag_no = $this->finish_product_service->getById($request->finish_product_id);
                $parms->tag_no = $tag_no->tag_no ?? '';
            }
            if ($request->product_id != '' && $request->product_id != null) {
                $product = $this->product_service->getProductById($request->product_id);
                $parms->product = $product->name ?? '';
            }
            if ($request->warehouse_id != '' && $request->warehouse_id != null) {
                $warehouse = $this->warehouse_service->getById($request->warehouse_id);
                $parms->warehouse = $warehouse->name ?? '';
            }
            $parms->report_name = "tag_history_report";
            if ($request->has('export-excel')) {
                return Excel::download(new ReportExport($parms), 'Tag-History-Report.xls');
            }
            $pdf = PDF::loadView('/reports/tag_history/partials.report', compact('parms'));
            return $pdf->stream('Tag History Report' . $request->start_date . '-' . $request->end_date . '.pdf');
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    // Profit Loss
    public function profitLossReport()
    {
        try {
            return view('reports/profit_loss/index');
        } catch (Exception $e) {
            return back()->with('error', config('enum.error'));
        }
    }
    public function getProfitLossReport(Request $request)
    {
        try {
            $obj = $request->all();
            $parms['data'] = $this->report_service->getProfitLossReport($obj);
            $parms = (object)$parms;
            $parms->start_date = $request->get('start_date');
            $parms->end_date = $request->get('end_date');
            $parms->report_name = "profit_loss_report";
            // if export excel button is clicked
            if ($request->has('export-excel')) {
                return Excel::download(new ReportExport($parms), 'Profit-Loss.xls');
            }
            $pdf = PDF::loadView('/reports/profit_loss/partials.report', compact('parms'));
            return $pdf->stream('Profit Loss - ' . $parms->start_date . '-' . $parms->end_date . '.pdf');
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }


    public function getPreviewProfitLossReport(Request $request)
    {
        // try {
        $obj = $request->all();

        $parms['data'] = $this->report_service->getProfitLossReport($obj);
        $parms = (object)$parms;
        $parms->start_date = $request->get('start_date');
        $parms->end_date = $request->get('end_date');
        $parms->report_name = "profit_loss_report";
        return view('/reports/profit_loss/partials.report', compact('parms'));
        // } catch (Exception $e) {
        //     return $this->error(config('enum.error'));
        // }
    }

    public function goToLedgerReport($parent_id)
    {
        $accounts = $this->account_service->getAllByParentId($parent_id);
        $child_ids = [];
        foreach ($accounts as $item) {
            $child_ids[] = $item['id'];
        }
        return  $this->success(
            config("enum.success"),
            $child_ids,
            false
        );
    }


    // Stock Ledger Report
    public function stockLedger()
    {
        try {
            $warehouses = $this->warehouse_service->getAll();
            return view('reports/stock_ledger/index', compact('warehouses'));
        } catch (Exception $e) {
            return back()->with('error', config('enum.error'));
        }
    }
    public function getStockLedgerReport(Request $request)
    {
        try {
            $obj = $request->all();

            $parms['data'] = $this->report_service->getStockLedgerReport($obj);

            $parms = (object)$parms;
            $parms->start_date = $request->get('start_date');
            $parms->end_date = $request->get('end_date');
            $parms->warehouse = 'All';
            if ($request->warehouse_id != '' && $request->warehouse_id != null) {
                $warehouse = $this->warehouse_service->getById($request->warehouse_id);
                $parms->warehouse = $warehouse->name ?? '';
            }
            $parms->report_name = "stock_ledger_report";

            // if export excel button is clicked
            if ($request->has('export-excel')) {
                return Excel::download(new ReportExport($parms), 'Stock-Ledger.xls');
            }

            $pdf = PDF::loadView('/reports/stock_ledger/partials.report', compact('parms'))->setPaper('a4', 'landscape');
            return $pdf->stream('Stock Ledger - ' . $parms->start_date . '-' . $parms->end_date . '.pdf');
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    public function getPreviewStockLedgerReport(Request $request)
    {
        try {
            $obj = $request->all();

            $parms['data'] = $this->report_service->getStockLedgerReport($obj);

            $parms = (object)$parms;

            $parms->start_date = $request->get('start_date');
            $parms->end_date = $request->get('end_date');
            $parms->warehouse = 'All';
            if ($request->warehouse_id != '' && $request->warehouse_id != null) {
                $warehouse = $this->warehouse_service->getById($request->warehouse_id);
                $parms->warehouse = $warehouse->name ?? '';
            }
            $parms->report_name = "stock_ledger_report";

            return view('/reports/stock_ledger/partials.report', compact('parms'));
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }


    //Product Ledger
    public function productLedger()
    {
        try {
            $other_products = $this->other_product_service->getAllActiveOtherProduct();
            $warehouses = $this->warehouse_service->getAll();
            return view('reports/product_ledger/index', compact('other_products', 'warehouses'));
        } catch (Exception $e) {
            return back()->with('error', config('enum.error'));
        }
    }
    public function getPreviewProductLedgerReport(Request $request)
    {
        // try {
        $obj = $request->all();
        $start = $request->start_date;
        $end = $request->end_date;
        $data = $this->report_service->getProductLedgerReport($obj);
        $warehouse = $this->warehouse_service->getById($request->warehouse_id);
        return view('/reports/product_ledger/partials.report', compact('start', 'end', 'data', 'warehouse'));
        // } catch (Exception $e) {
        //     return $this->error(config('enum.error'));
        // }
    }
    public function getProductLedgerReport(Request $request)
    {
        try {
            $obj = $request->all();
            $start = $request->start_date;
            $end = $request->end_date;
            $data = $this->report_service->getProductLedgerReport($obj);
            $warehouse = $this->warehouse_service->getById($request->warehouse_id);
            $pdf = PDF::loadView('/reports/stock_ledger/partials.report', compact('start', 'end', 'data', 'warehouse'));
            return $pdf->stream('Product Ledger - ' . $start . '-' . $end . '.pdf');
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    //customer List
    public function customerList()
    {
        try {
            $customers = $this->customer_service->getAllActiveCustomer();
            return view('reports/customer_list/index', compact('customers'));
        } catch (Exception $e) {
            return back()->with('error', config('enum.error'));
        }
    }

    public function getCustomerListReport(Request $request)
    {
        try {
            $parms['data'] = $this->customer_service->getAllActiveCustomer($request->all());

            $parms = (object)$parms;

            if (isset($request->customer_id) && $request->customer_id != '') {
                $customer = $this->customer_service->getById($request->customer_id);
                $parms->customer = $customer->name ?? 'All';
            }
            $parms->report_name = "customer_list_report";  // report name for export expor tfunction

            if ($request->has('export-excel')) {
                return Excel::download(new ReportExport($parms), 'Customer-List.xls');
            }

            $pdf = PDF::loadView('/reports/customer_list/partials.report', compact('parms'));
            return $pdf->stream('Customer List .pdf');
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }


    public function getPreviewCustomerListReport(Request $request)
    {
        try {

            $parms['data'] = $this->customer_service->getAllActiveCustomer($request->all());

            $parms = (object)$parms;
            if (isset($request->customer_id) && $request->customer_id != '') {
                $customer = $this->customer_service->getById($request->customer_id);
                $parms->customer = $customer->name ?? 'All';
            }
            $parms->report_name = "customer_list_report";  // report name for export expor tfunction

            return view('/reports/customer_list/partials.report', compact('parms'));
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    // Product Consumption
    public function productConsumption()
    {
        try {
            $warehouses = $this->warehouse_service->getAll();
            return view('reports/product_consumption/index', compact('warehouses'));
        } catch (Exception $e) {
            return back()->with('error', config('enum.error'));
        }
    }

    public function getProductConsumptionReport(Request $request)
    {
        try {
            ini_set("memory_limit", "800M");
            ini_set("max_execution_time", "800");
            $obj = $request->all();

            $parms['data'] = $this->report_service->getProductConsumptionReport($obj);
            $parms = (object)$parms;
            $parms->start_date = $request->get('start_date');
            $parms->end_date = $request->get('end_date');
            if ($request->warehouse_id != '' && $request->warehouse_id != null) {
                $warehouse = $this->warehouse_service->getById($request->warehouse_id);
                $parms->warehouse = $warehouse->name ?? '';
            }
            $parms->report_name = "product_consumption";  // report name for export expor tfunction

            // if export excel button is clicked
            if ($request->has('export-excel')) {
                return Excel::download(new ReportExport($parms), 'Product-Consumption.xls');
            }

            $pdf = PDF::loadView('/reports/product_consumption/partials.report', compact('parms'))->setPaper('a4', 'landscape');
            return $pdf->stream('Product Consumption - ' . $parms->start_date . '-' . $parms->end_date . '.pdf');
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }


    public function getPreviewProductConsumptionReport(Request $request)
    {
        try {
            $obj = $request->all();

            $parms['data'] = $this->report_service->getProductConsumptionReport($obj);

            $parms = (object)$parms;

            $parms->start_date = $request->get('start_date');
            $parms->end_date = $request->get('end_date');
            if ($request->warehouse_id != '' && $request->warehouse_id != null) {
                $warehouse = $this->warehouse_service->getById($request->warehouse_id);
                $parms->warehouse = $warehouse->name ?? '';
            }
            $parms->report_name = "product_consumption";  // report name for export expor tfunction

            return view('/reports/product_consumption/partials.report', compact('parms'));
        } catch (Exception $e) {
            InsertErrorLog(config('global.adminSide'), $e->getCode(), $e->getLine(), $e->getFile(), $e->getMessage());
            return $this->error(config('global.error'));
        }
    }
}
