<?php

namespace App\Services\Concrete;

use App\Models\Account;
use App\Models\DiamondPurchase;
use App\Models\DiamondPurchaseDetail;
use App\Models\DiamondTransaction;
use App\Models\Journal;
use App\Models\JournalEntry;
use App\Repository\Repository;
use App\Models\OtherPurchase;
use App\Models\OtherPurchaseDetail;
use App\Models\SupplierPayment;
use App\Models\Transaction;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DiamondPurchaseService
{
    // initialize protected model variables
    protected $model_diamond_purchase;
    protected $model_diamond_purchase_detail;
    protected $model_journal_entry;
    protected $model_supplier_payment;

    protected $common_service;
    protected $journal_entry_service;
    public function __construct()
    {
        // set the model
        $this->model_diamond_purchase = new Repository(new DiamondPurchase);
        $this->model_diamond_purchase_detail = new Repository(new DiamondPurchaseDetail);
        $this->model_journal_entry = new Repository(new JournalEntry);
        $this->model_supplier_payment = new Repository(new SupplierPayment);

        $this->common_service = new CommonService();
        $this->journal_entry_service = new JournalEntryService();
    }

    public function getSource($obj)
    {
        $wh = [];
        if ($obj['posted'] != '') {
            $wh[] = ['posted', $obj['posted']];
        }
        if ($obj['supplier_id'] != '') {
            $wh[] = ['supplier_id', $obj['supplier_id']];
        }
        $model = $this->model_diamond_purchase->getModel()::has('DiamondPurchaseDetail')->with('supplier_name')->where('is_deleted', 0)
            ->whereBetween('diamond_purchase_date', [date("Y-m-d", strtotime(str_replace('/', '-', $obj['start']))), date("Y-m-d", strtotime(str_replace('/', '-', $obj['end'])))])
            ->where($wh);

        $data = DataTables::of($model)
            ->addColumn('check_box', function ($item) {
                if ($item->posted != 1)
                    return '<input type="checkbox" class="sub_chk" value="' . $item->id . '" data-id="' . $item->id . '" >';
            })
            ->addColumn('posted', function ($item) {
                $badge_color = $item->posted == 0 ? 'badge-danger' : 'badge-success';
                $badge_text = $item->posted == 0 ? 'Unposted' : 'Posted';
                return '<span class="badge ' . $badge_color . '">' . $badge_text . '</span>';
            })
            ->addColumn('is_pkr', function ($item) {
                $badge_color = $item->is_pkr == 0 ? 'badge-primary' : 'badge-success';
                $badge_text = $item->is_pkr == 0 ? 'PKR' : 'Dollar';
                return '<span class="badge ' . $badge_color . '">' . $badge_text . '</span>';
            })
            ->addColumn('total_amount', function ($item) {
                return $item->is_pkr == 1 ? $item->total : $item->total_dollar;
            })
            ->addColumn('supplier', function ($item) {
                return $item->supplier_name->name ?? '';
            })
            ->addColumn('action', function ($item) {

                $jvs = '';
                if ($item->jv_id != null)
                    $jvs .= "filter[]=" . $item->jv_id . "";

                if ($item->paid_jv_id != null)
                    $jvs .= "&filter[]=" . $item->paid_jv_id . "";

                $action_column = '';
                $unpost = '<a class="text text-danger" id="unpost" data-toggle="tooltip" data-id="' . $item->id . '" data-original-title="Unpost" href="javascript:void(0)"><i class="fa fa-repeat"></i>Unpost</a>';
                $print_column    = "<a class='text-info mr-2' href='diamond-purchase/print/" . $item->id . "'><i title='Add' class='nav-icon mr-2 fa fa-print'></i>Print</a>";
                $all_print_column    = "<a class='text-info mr-2' id='Ref' href='javascript:void(0)' data-toggle='tooltip'  data-filter='" . $jvs . "' data-original-title='Accounting'><i title='Accounting' class='nav-icon mr-2 fa fa-eye'></i>Accounting</a>";
                $delete_column    = "<a class='text-danger mr-2' id='deleteDiamondPurchase' href='javascript:void(0)' data-toggle='tooltip'  data-id='" . $item->id . "' data-original-title='Delete'><i title='Delete' class='nav-icon mr-2 fa fa-trash'></i>Delete</a>";


                if (Auth::user()->can('diamond_purchase_print'))
                    $action_column .= $print_column;
                if (Auth::user()->can('diamond_purchase_unpost') && $item->posted == 1)
                    $action_column .= $unpost;
                if (Auth::user()->can('diamond_purchase_jvs') && $item->posted == 1)
                    $action_column .= $all_print_column;

                if (Auth::user()->can('diamond_purchase_delete'))
                    $action_column .= $delete_column;

                return $action_column;
            })
            ->rawColumns(['check_box', 'is_pkr', 'supplier', 'total_amount', 'posted', 'action'])
            ->addIndexColumn()
            ->make(true);
        return $data;
    }

    public function getAllDiamondPurchase()
    {
        return $this->model_diamond_purchase->getModel()::with('supplier_name')
            ->where('is_deleted', 0)
            ->get();
    }
    public function saveDiamondPurchase()
    {
        try {
            DB::beginTransaction();
            $obj = [
                'diamond_purchase_no' => $this->common_service->generateDiamondPurchaseNo(),
                'createdby_id' => Auth::User()->id
            ];
            $saved_obj = $this->model_diamond_purchase->create($obj);

            DB::commit();
        } catch (Exception $e) {

            DB::rollback();
            throw $e;
        }
        return $saved_obj;
    }
    public function save($obj)
    {
        try {
            DB::beginTransaction();
            $diamondPurchaseDetail = json_decode($obj['diamondProductDetail']);
            $diamondPurchaseObj = [
                "diamond_purchase_date" => $obj['diamond_purchase_date'],
                "supplier_id" => $obj['supplier_id'],
                "is_pkr" => $obj['is_pkr'] ?? 0,
                "warehouse_id" => $obj['warehouse_id'] ?? null,
                "purchase_account_id" => $obj['purchase_account_id'] ?? null,
                "total" => $obj['total'],
                "total_dollar" => $obj['total_dollar'],
                "paid" => $obj['paid'] ?? 0,
                "paid_account_id" => $obj['paid_account_id'] ?? null,
                "reference" => $obj['reference'] ?? null,
                "updatedby_id" => Auth::user()->id
            ];
            $total_qty = 0;
            foreach ($diamondPurchaseDetail as $item) {
                $diamondPurchaseDetailObj = [
                    "diamond_purchase_id" => $obj['id'],
                    "diamond_type_id" => $item->diamond_type_id ?? '',
                    "diamond_cut_id" => $item->diamond_cut_id ?? '',
                    "diamond_color_id" => $item->diamond_color_id ?? '',
                    "diamond_clarity_id" => $item->diamond_clarity_id ?? '',
                    "carat" => $item->carat ?? 0.000,
                    "qty" => $item->qty ?? 0.000,
                    "carat_price" => $item->carat_price ?? 0.000,
                    "total_amount" => $item->total_amount,
                    "total_dollar" => $item->total_dollar,
                    "createdby_id" => Auth::user()->id
                ];
                $total_qty = $total_qty + $item->qty;
                $diamond_purchase_detail = $this->model_diamond_purchase_detail->create($diamondPurchaseDetailObj);
            }
            $diamondPurchaseObj['total_qty'] = $total_qty;
            $diamond_purchase = $this->model_diamond_purchase->update($diamondPurchaseObj, $obj['id']);
            DB::commit();
        } catch (Exception $e) {
            return $e;
        }

        return true;
    }

    public function getById($id)
    {
        return $this->model_diamond_purchase->getModel()::with(['supplier_name'])->find($id);
    }

    public function diamondPurchaseDetail($diamond_purchase_id)
    {
        $diamond_purchase_detail = $this->model_diamond_purchase_detail->getModel()::with([
            'diamond_type',
            'diamond_cut',
            'diamond_color',
            'diamond_clarity'
        ])
            ->where('diamond_purchase_id', $diamond_purchase_id)
            ->where('is_deleted', 0)->get();

        $data = [];
        foreach ($diamond_purchase_detail as $item) {
            $data[] = [
                "type" => $item->diamond_type->name ?? '',
                "cut" => $item->diamond_cut->name ?? '',
                "color" => $item->diamond_color->name ?? '',
                "clarity" => $item->diamond_clarity->name ?? '',
                "carat" => $item->carat ?? 0,
                "carat_price" => $item->carat_price ?? 0,
                "qty" => $item->qty,
                "total_amount" => $item->total_amount,
                "total_dollar" => $item->total_dollar
            ];
        }

        return $data;
    }

    public function post($obj)
    {

        try {
            DB::beginTransaction();

            foreach ($obj['diamond_purchase'] as $item) {

                $journal_entry_supplier_payment = null;
                $diamond_purchase_voucher = null;
                $supplier_payment = null;

                $diamond_purchase = $this->model_diamond_purchase->getModel()::with([
                    'supplier_name',
                    'supplier_name.account_name',
                    'purchase_account',
                    'DiamondPurchaseDetail',
                    'paid_account'
                ])
                    ->find($item);

                $supplier =  $diamond_purchase->supplier_name;

                //==============  Create Purchase Inventory Transaction

                $this->createDiamondPurchaseInventoryTransaction(
                    $diamond_purchase->DiamondPurchaseDetail,
                    $diamond_purchase->diamond_purchase_date,
                    $diamond_purchase->bill_no,
                    $diamond_purchase->warehouse_id
                );

                $debit_amount = ($diamond_purchase->is_pkr == 0) ? str_replace(',', '', $diamond_purchase->total) : str_replace(',', '', $diamond_purchase->total_dollar);

                //============== Create Purchase Voucher
                $diamond_purchase_voucher = $this->createDiamondPurchaseVoucher(
                    $diamond_purchase->diamond_purchase_no,
                    $diamond_purchase->diamond_purchase_date,
                    $diamond_purchase->bill_no,
                    $diamond_purchase->supplier_name,
                    $diamond_purchase->purchase_account,
                    $debit_amount,
                    $diamond_purchase->is_pkr
                );

                // paid Amount
                if ($diamond_purchase->paid > 0) {
                    if ($diamond_purchase->paid_account_id == null || $diamond_purchase->paid_account_id == '') {
                        $msg = 'Paid amount is greater then 0 but paid account not select!';
                        return $msg;
                    }

                    // supplier Payment Add
                    $paid_amount = str_replace(',', '', $diamond_purchase->paid);

                    //============== Create Purchase supplier Payment Voucher
                    $journal_entry_supplier_payment = $this->createDiamondPurchaseSupplierPaymentVoucher(
                        $diamond_purchase->diamond_purchase_no,
                        $diamond_purchase->diamond_purchase_date,
                        $diamond_purchase->bill_no,
                        $supplier,
                        $diamond_purchase->paid_account,
                        $supplier->account_name,
                        $paid_amount,
                        $diamond_purchase->is_pkr
                    );

                    //============== Create Purchase Supplier Payment
                    $supplier_payment = $this->createDiamondPurchaseSupplierPayment(
                        $journal_entry_supplier_payment,
                        $diamond_purchase->diamond_purchase_no,
                        $diamond_purchase->diamond_purchase_date,
                        $supplier,
                        $diamond_purchase->paid_account,
                        $paid_amount,
                        $diamond_purchase->tax_amount ?? 0,
                        $diamond_purchase->id,
                        $diamond_purchase->is_pkr
                    );
                }
                $diamond_purchase->posted = 1;
                $diamond_purchase->jv_id = $diamond_purchase_voucher;
                $diamond_purchase->paid_jv_id = $journal_entry_supplier_payment;
                $diamond_purchase->supplier_payment_id = $supplier_payment;
                $diamond_purchase->update();
            }
            DB::commit();
        } catch (Exception $e) {

            DB::rollback();
            throw $e;
        }
        return true;
    }
    public function unpost($diamond_purchase_id)
    {
        try {
            DB::beginTransaction();

            $diamond_purchase = $this->model_diamond_purchase->getModel()::find($diamond_purchase_id);

            // Journal entry delete
            $journal_entry = $this->model_journal_entry->getModel()::find($diamond_purchase->jv_id);
            $journal_entry->is_deleted = 1;
            $journal_entry->deletedby_id = Auth::user()->id;
            $journal_entry->update();

            if ($diamond_purchase->paid_jv_id != null) {
                // Journal entry delete
                $paid_journal_entry = $this->model_journal_entry->getModel()::find($diamond_purchase->paid_jv_id);
                $paid_journal_entry->is_deleted = 1;
                $paid_journal_entry->deletedby_id = Auth::user()->id;
                $paid_journal_entry->update();
            }

            if ($diamond_purchase->supplier_payment_id != null) {
                // Journal entry delete
                $supplier_payment = $this->model_supplier_payment->getModel()::find($diamond_purchase->supplier_payment_id);
                $supplier_payment->is_deleted = 1;
                $supplier_payment->deletedby_id = Auth::user()->id;
                $supplier_payment->update();
            }

            // other purchase update
            $diamond_purchase->posted = 0;
            $diamond_purchase->jv_id = Null;
            $diamond_purchase->paid_jv_id = Null;
            $diamond_purchase->supplier_payment_id = Null;
            $diamond_purchase->update();

            DB::commit();
        } catch (Exception $e) {

            DB::rollback();
            throw $e;
        }
        return true;
    }

    public function deleteById($diamond_purchase_id)
    {
        try {
            DB::beginTransaction();

            $diamond_purchase = $this->model_diamond_purchase->getModel()::find($diamond_purchase_id);

            if ($diamond_purchase->jv_id != null) {
                // Journal entry delete
                $journal_entry = $this->model_journal_entry->getModel()::find($diamond_purchase->jv_id);
                $journal_entry->is_deleted = 1;
                $journal_entry->deletedby_id = Auth::user()->id;
                $journal_entry->update();
            }

            if ($diamond_purchase->paid_jv_id != null) {
                // Journal entry delete
                $paid_journal_entry = $this->model_journal_entry->getModel()::find($diamond_purchase->paid_jv_id);
                $paid_journal_entry->is_deleted = 1;
                $paid_journal_entry->deletedby_id = Auth::user()->id;
                $paid_journal_entry->update();
            }

            if ($diamond_purchase->supplier_payment_id != null) {
                // Journal entry delete
                $supplier_payment = $this->model_supplier_payment->getModel()::find($diamond_purchase->supplier_payment_id);
                $supplier_payment->is_deleted = 1;
                $supplier_payment->deletedby_id = Auth::user()->id;
                $supplier_payment->update();
            }

            // other purchase update
            $diamond_purchase->posted = 0;
            $diamond_purchase->is_deleted = 1;
            $diamond_purchase->deletedby_id = Auth::user()->id;
            $diamond_purchase->jv_id = Null;
            $diamond_purchase->paid_jv_id = Null;
            $diamond_purchase->supplier_payment_id = Null;
            $diamond_purchase->update();

            DB::commit();
        } catch (Exception $e) {

            DB::rollback();
            throw $e;
        }
        return true;
    }


    public function createDiamondPurchaseVoucher(
        $diamond_purchase_no,
        $diamond_purchase_date,
        $bill_no,
        $supplier,
        $purchase_account,
        $amount,
        $is_pkr
    ) {
        $journal = Journal::find(config('enum.PV'));
        $in_purchase = ($is_pkr == 0) ? 0 : 2;
        $diamond_purchase_date = date("Y-m-d", strtotime(str_replace('/', '-', $diamond_purchase_date)));
        // Add journal entry
        $data = [
            "date" => $diamond_purchase_date,
            "prefix" => $journal->prefix,
            "journal_id" => $journal->id
        ];
        $entryNum = $this->journal_entry_service->generateJournalEntryNum($data);

        $journal_entry = new JournalEntry;
        $journal_entry->journal_id = $journal->id;
        $journal_entry->supplier_id = $supplier->id;
        $journal_entry->date_post = date("Y-m-d", strtotime(str_replace('/', '-', $diamond_purchase_date)));
        $journal_entry->reference = 'Date :' . $diamond_purchase_date . ' diamond purchase ' . $diamond_purchase_no . '. Supplier is ' . $supplier->name;
        $journal_entry->entryNum = $entryNum;
        $journal_entry->createdby_id = Auth::User()->id;
        $journal_entry->save();

        $journal_entry_id = $journal_entry->id ?? null;

        // Purchase Account
        if ($purchase_account->id == null || $purchase_account->id == '') {
            $msg = 'Purchase Account not selected please attach account then post again!';
            return $msg;
        }
        // PKR (Debit)
        $this->journal_entry_service->saveJVDetail(
            $in_purchase, // currency 0 for PKR, 1 for AU, 2 for Dollar
            $journal_entry_id, // journal entry id
            'Purchase Amount From Purchase Debit Entry', //explaination
            $bill_no, //bill no
            0, // check no or 0
            $diamond_purchase_date, //check date
            1, // is credit flag 0 for credit, 1 for debit
            $amount, //amount
            $purchase_account->id, // account id
            $purchase_account->code, // account code
            Auth::User()->id //created by id
        );

        // credit Amount
        if ($supplier->account_id == null || $supplier->account_id == '') {
            $msg = 'Supplier Account has no account please attach account then post again!';
            return $msg;
        }
        $supplier_account = Account::find($supplier->account_id);
        // PKR (Credit)
        $this->journal_entry_service->saveJVDetail(
            $in_purchase, // currency 0 for PKR, 1 for AU, 2 for Dollar
            $journal_entry_id, // journal entry id
            'Credit Amount From Purchase Credit Entry from ' . $supplier->name, //explaination
            $bill_no, //bill no
            0, // check no or 0
            $diamond_purchase_date, //check date
            0, // is credit flag 0 for credit, 1 for debit
            $amount, //amount
            $supplier_account->id, // account id
            $supplier_account->code, // account code
            Auth::User()->id //created by id
        );

        return $journal_entry_id;
    }

    public function createDiamondPurchaseInventoryTransaction($diamond_purchase_detail, $diamond_purchase_date, $bill_no, $warehouse_id)
    {
        foreach ($diamond_purchase_detail as $index => $item) {

            $obj = [
                "diamond_purchase_id" => $item->diamond_purchase_id,
                "date" => $diamond_purchase_date ?? Carbon::now(),
                "bill_no" => $bill_no,
                "warehouse_id" => $warehouse_id,
                "diamond_type_id" => $item->diamond_type_id,
                "diamond_cut_id" => $item->diamond_cut_id,
                "diamond_color_id" => $item->diamond_color_id,
                "diamond_clarity_id" => $item->diamond_clarity_id,
                "carat" => $item->carat ?? 0,
                "qty" => $item->qty ?? 0,
                "carat_price" => $item->carat_price ?? 0,
                "createdby_id" => Auth::User()->id,
                "type" => 0,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ];

            $transation = DiamondTransaction::create($obj);
        }
    }

    public function createDiamondPurchaseSupplierPaymentVoucher(
        $diamond_purchase_no,
        $diamond_purchase_date,
        $bill_no,
        $supplier,
        $paid_account,
        $supplier_account,
        $paid_amount,
        $is_pkr
    ) {

        $journal_type = ($paid_account->is_cash_account == 1) ? config('enum.CPV') : config('enum.BPV');
        $in_purchase = ($is_pkr == 0) ? 0 : 2;
        $journal_supplier = Journal::find($journal_type);
        // Add journal entry
        $data = [
            "date" => $diamond_purchase_date,
            "prefix" => $journal_supplier->prefix,
            "journal_id" => $journal_supplier->id
        ];
        $entryNum_supplier = $this->journal_entry_service->generateJournalEntryNum($data);

        $journal_entry_supplier = new JournalEntry;
        $journal_entry_supplier->journal_id = $journal_supplier->id;
        $journal_entry_supplier->supplier_id = $supplier->id;
        $journal_entry_supplier->date_post = date("Y-m-d", strtotime(str_replace('/', '-', $diamond_purchase_date)));
        $journal_entry_supplier->reference = 'Date :' . $diamond_purchase_date . ' Against DPO. ' . $diamond_purchase_no;
        $journal_entry_supplier->entryNum = $entryNum_supplier;
        $journal_entry_supplier->createdby_id = Auth::User()->id;
        $journal_entry_supplier->save();

        $paid_jv_id = $journal_entry_supplier->id;

        // Journal entry detail (Credit)
        $this->journal_entry_service->saveJVDetail(
            $in_purchase, // currency 0 for PKR, 1 for AU, 2 for Dollar
            $paid_jv_id, // journal entry id
            'Supplier Paid Payment Against Other Purchase Credit', //explaination
            $bill_no, //bill no
            0, // check no or 0
            $diamond_purchase_date, //check date
            0, // is credit flag 0 for credit, 1 for debit
            $paid_amount, //amount
            $paid_account->id, // account id
            $paid_account->code, // account code
            Auth::User()->id //created by id
        );

        // Journal entry detail (Debit)
        $this->journal_entry_service->saveJVDetail(
            $in_purchase, // currency 0 for PKR, 1 for AU, 2 for Dollar
            $paid_jv_id, // journal entry id
            'Supplier Paid Payment Against Purchase Debit', //explaination
            $bill_no, //bill no
            0, // check no or 0
            $diamond_purchase_date, //check date
            1, // is credit flag 0 for credit, 1 for debit
            $paid_amount, //amount
            $supplier_account->id, // account id
            $supplier_account->code, // account code
            Auth::User()->id //created by id
        );

        return $paid_jv_id;
    }

    public function createDiamondPurchaseSupplierPayment(
        $journal_entry_id,
        $diamond_purchase_no,
        $diamond_purchase_date,
        $supplier,
        $paid_account,
        $paid_amount,
        $tax_amount,
        $diamond_purchase_id,
        $is_pkr
    ) {
        // Supplier Payment Add

        $in_purchase = ($is_pkr == 0) ? 0 : 2;
        $supplier_payment_data = [
            'supplier_id' => $supplier->id,
            'account_id' => $paid_account->id,
            'payment_date' => $diamond_purchase_date,
            'currency' => $in_purchase,
            'cheque_ref' => 'Date :' . $diamond_purchase_date . ' Against DPO. ' . $diamond_purchase_no,
            'sub_total' => $paid_amount,
            'total' => $paid_amount,
            'tax' => 0,
            'tax_amount' => $tax_amount ?? 0,
            'tax_account_id' => Null,
            'diamond_purchase_id' => $diamond_purchase_id,
            'posted' => 1,
            'jv_id' => $journal_entry_id,
            'createdby_id' => Auth::User()->id
        ];

        $supplier_payment =  SupplierPayment::create($supplier_payment_data);

        return $supplier_payment->id;
    }
}
