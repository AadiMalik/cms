<?php

namespace App\Http\Controllers;

use App\ExcelExports\ReportExport;
use App\Services\Concrete\AccountService;
use App\Services\Concrete\CustomerService;
use App\Services\Concrete\JournalEntryService;
use App\Services\Concrete\ReportService;
use App\Services\Concrete\SupplierService;
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

    #endregion

    #region Constructor

    public function __construct(
        ReportService $report_service,
        AccountService  $account_service,
        SupplierService $supplier_service,
        JournalEntryService $journal_entry_service,
        CustomerService $customer_service
    ) {
        $this->report_service = $report_service;
        $this->account_service = $account_service;
        $this->journal_entry_service = $journal_entry_service;
        $this->supplier_service = $supplier_service;
        $this->customer_service = $customer_service;
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
            return view('reports/tag_history/index');
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
}
