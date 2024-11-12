<?php

namespace App\Services\Concrete;

use App\Models\Account;
use App\Models\Customer;
use App\Models\FinishProduct;
use App\Models\JobPurchase;
use App\Models\JobPurchaseDetail;
use App\Models\JobPurchaseDetailBead;
use App\Models\JobPurchaseDetailDiamond;
use App\Models\JobPurchaseDetailStone;
use App\Models\Journal;
use App\Models\JournalEntry;
use App\Models\PurchaseOrder;
use App\Repository\Repository;
use App\Models\Sale;
use App\Models\RattiKaatDetail;
use App\Models\SaleDetail;
use App\Models\SaleDetailBead;
use App\Models\SaleDetailDiamond;
use App\Models\SaleDetailStone;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class JobPurchaseService
{
    // initialize protected model variables
    protected $model_job_purchase;
    protected $model_job_purchase_detail;
    protected $model_job_purchase_detail_bead;
    protected $model_job_purchase_detail_stone;
    protected $model_job_purchase_detail_diamond;
    protected $model_journal_entry;

    protected $common_service;
    protected $journal_entry_service;
    public function __construct()
    {
        // set the model
        $this->model_job_purchase = new Repository(new JobPurchase);
        $this->model_job_purchase_detail = new Repository(new JobPurchaseDetail);
        $this->model_job_purchase_detail_bead = new Repository(new JobPurchaseDetailBead);
        $this->model_job_purchase_detail_stone = new Repository(new JobPurchaseDetailStone);
        $this->model_job_purchase_detail_diamond = new Repository(new JobPurchaseDetailDiamond);
        $this->model_journal_entry = new Repository(new JournalEntry);

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
        $model = $this->model_job_purchase->getModel()::with(
            [
                'purchase_order',
                'sale_order',
                'supplier_name'
            ]
        )->has('JobPurchaseDetail')->where('is_deleted', 0)
            ->whereBetween('job_purchase_date', [date("Y-m-d", strtotime(str_replace('/', '-', $obj['start']))), date("Y-m-d", strtotime(str_replace('/', '-', $obj['end'])))])
            ->where($wh);

        $data = DataTables::of($model)
            ->addColumn('check_box', function ($item) {
                if ($item->posted != 1)
                    return '<input type="checkbox" class="sub_chk" value="' . $item->id . '" data-id="' . $item->id . '" >';
            })
            ->addColumn('purchase_order', function ($item) {
                return $item->purchase_order->purchase_order_no ?? '';
            })
            ->addColumn('sale_order', function ($item) {
                return $item->sale_order->sale_order_no ?? '';
            })
            ->addColumn('customer_name', function ($item) {
                return $item->sale_order->customer_name->name ?? '';
            })
            ->addColumn('supplier_name', function ($item) {
                return $item->supplier_name->name ?? '';
            })
            ->addColumn('posted', function ($item) {
                $badge_color = $item->posted == 0 ? 'badge-danger' : 'badge-success';
                $badge_text = $item->posted == 0 ? 'Unposted' : 'Posted';
                return '<span class="badge ' . $badge_color . '">' . $badge_text . '</span>';
            })
            ->addColumn('action', function ($item) {

                $jvs = '';
                if ($item->jv_id != null)
                    $jvs .= "filter[]=" . $item->jv_id . "";

                $action_column = '';
                $unpost = '<a class="text text-danger" id="unpost" data-toggle="tooltip" data-id="' . $item->id . '" data-original-title="Unpost" href="javascript:void(0)"><i class="fa fa-repeat"></i>Unpost</a>';
                $print_column    = "<a class='text-info mr-2' href='job-purchase/print/" . $item->id . "'><i title='Add' class='nav-icon mr-2 fa fa-print'></i>Print</a>";
                $all_print_column    = "<a class='text-info mr-2' id='Ref' href='javascript:void(0)' data-toggle='tooltip'  data-filter='" . $jvs . "' data-original-title='Accounting'><i title='Accounting' class='nav-icon mr-2 fa fa-eye'></i>Accounting</a>";
                $delete_column    = "<a class='text-danger mr-2' id='deleteJobPurchase' href='javascript:void(0)' data-toggle='tooltip'  data-id='" . $item->id . "' data-original-title='Delete'><i title='Delete' class='nav-icon mr-2 fa fa-trash'></i>Delete</a>";

                // if (Auth::user()->can('customers_edit'))
                //     $action_column .= $edit_column;

                if (Auth::user()->can('customers_edit'))
                    $action_column .= $print_column;
                if (Auth::user()->can('customers_edit') && $item->posted == 1)
                    $action_column .= $unpost;
                if (Auth::user()->can('ratti_kaat_access') && $item->posted == 1)
                    $action_column .= $all_print_column;

                if (Auth::user()->can('customers_delete'))
                    $action_column .= $delete_column;

                return $action_column;
            })
            ->rawColumns(['check_box', 'purchase_order', 'sale_order', 'customer_name', 'supplier_name', 'posted', 'action'])
            ->addIndexColumn()
            ->make(true);
        return $data;
    }

    public function getAllJobPurchase()
    {
        return $this->model_job_purchase->getModel()::with(
            [
                'purchase_order',
                'sale_order',
                'supplier_name'
            ]
        )
            ->where('is_deleted', 0)
            ->get();
    }
    public function save($obj)
    {

        try {
            DB::beginTransaction();
            $jobPurchaseDetail = json_decode($obj['productDetail']);
            $jobPurchaseObj = [
                "job_purchase_no" => $obj['job_purchase_no'],
                "job_purchase_date" => $obj['job_purchase_date'],
                "purchase_order_id" => $obj['purchase_order_id'],
                "sale_order_id" => $obj['sale_order_id'],
                "supplier_id" => $obj['supplier_id'],
                "reference" => $obj['reference'],
                "total_recieved_au" => $obj['total_recieved_au'] ?? 0,
                "total" => $obj['total'],
                "total_au" => $obj['total_au'],
                "total_dollar" => $obj['total_dollar'],
                "createdby_id" => Auth::user()->id
            ];
            $job_purchase = $this->model_job_purchase->create($jobPurchaseObj);

            foreach ($jobPurchaseDetail as $item) {
                $jobPurchaseDetailObj = $item;
                $jobPurchaseDetailObj['job_purchase_id'] = $job_purchase->id;
                $jobPurchaseDetailObj['createdby_id'] = Auth::user()->id;
                $job_purchase_detail = $this->model_job_purchase_detail->create($jobPurchaseDetailObj);

                foreach ($item->beadDetail as $item1) {
                    $jobPurchaseDetailBead = $item1;
                    $jobPurchaseDetailBead['job_purchase_detail_id'] = $job_purchase_detail->id;
                    $jobPurchaseDetailBead['createdby_id'] = Auth::user()->id;
                    $this->model_job_purchase_detail_bead->create($jobPurchaseDetailBead);
                }

                // Stone Detail
                foreach ($item->stonesDetail as $item1) {
                    $jobPurchaseDetailStone = $item1;
                    $jobPurchaseDetailStone['job_purchase_detail_id'] = $job_purchase_detail->id;
                    $jobPurchaseDetailStone['createdby_id'] = Auth::user()->id;
                    $this->model_job_purchase_detail_stone->create($jobPurchaseDetailStone);
                }

                // Diamond Detail
                foreach ($item->diamondDetail as $item1) {
                    $jobPurchaseDetailDiamond = $item1;
                    $jobPurchaseDetailDiamond['job_purchase_detail_id'] = $job_purchase_detail->id;
                    $jobPurchaseDetailDiamond['createdby_id'] = Auth::user()->id;
                    $this->model_job_purchase_detail_diamond->create($jobPurchaseDetailDiamond);
                }
            }

            DB::commit();
        } catch (Exception $e) {
            return $e;
        }

        return true;
    }

    public function getById($id)
    {
        return $this->model_job_purchase->getModel()::with(
            [
                'purchase_order',
                'sale_order',
                'supplier_name'
            ]
        )->find($id);
    }

    public function jobPurchaseDetail($sale_id)
    {
        $sale_detail = $this->model_job_purchase_detail->getModel()::with('product')
            ->where('is_deleted', 0)->get();

        $data = [];
        foreach ($sale_detail as $item) {
            $bead_detail = $this->model_job_purchase_detail_bead->getModel()::where('job_purchase_detail_id', $item->id)
                ->where('is_deleted', 0)->get();
            $stone_detail = $this->model_job_purchase_detail_stone->getModel()::where('job_purchase_detail_id', $item->id)
                ->where('is_deleted', 0)->get();
            $diamond_detail = $this->model_job_purchase_detail_diamond->getModel()::where('job_purchase_detail_id', $item->id)
                ->where('is_deleted', 0)->get();
            $data[] = $item;
            $data[]['bead_detail']=$bead_detail;
            $data[]['stone_detail']=$stone_detail;
            $data[]['diamond_detail']=$diamond_detail;
        }

        return $data;
    }

    public function post($obj)
    {

        try {
            DB::beginTransaction();

            $journal_entry_id = null;
            $jv_id = null;
            foreach ($obj['sale'] as $item) {
                $sale = Sale::with('customer_name')->find($item);
                $customer = Customer::find($sale->customer_id);

                $journal = Journal::find(config('enum.SV'));
                $sale_date = date("Y-m-d", strtotime(str_replace('/', '-', $sale->sale_date)));
                // Add journal entry
                $data = [
                    "date" => $sale_date,
                    "prefix" => $journal->prefix,
                    "journal_id" => $journal->id
                ];
                $entryNum = $this->journal_entry_service->generateJournalEntryNum($data);

                $journal_entry = new JournalEntry;
                $journal_entry->journal_id = $journal->id;
                $journal_entry->customer_id = $sale->customer_id;
                $journal_entry->date_post = date("Y-m-d", strtotime(str_replace('/', '-', $sale->sale_date)));
                $journal_entry->reference = 'Date :' . $sale->sale_date . ' Sale ' . $sale->sale_no . '. Customer is ' . $sale->customer_name;
                $journal_entry->entryNum = $entryNum;
                $journal_entry->createdby_id = Auth::User()->id;
                $journal_entry->save();

                $journal_entry_id = $journal_entry->id ?? null;

                // cash amount
                if ($sale->cash_amount > 0) {
                    if ($obj['cash_account_id'] == null || $obj['cash_account_id'] == '') {
                        $msg = 'Cash Account not select but cash amount is greater then 0';
                        return $msg;
                    }
                    $cash_account = Account::find($obj['cash_account_id']);
                    $Cash_Amount = str_replace(',', '', $sale->cash_amount ?? 0);
                    // PKR (Debit)
                    $this->journal_entry_service->saveJVDetail(
                        0, // currency 0 for PKR, 1 for AU, 2 for Dollar
                        $journal_entry_id, // journal entry id
                        'Cash Amount From Sale Debit Entry', //explaination
                        $sale->id, //bill no
                        0, // check no or 0
                        $sale->sale_date, //check date
                        1, // is credit flag 0 for credit, 1 for debit
                        $Cash_Amount, //amount
                        $cash_account->id, // account id
                        $cash_account->code, // account code
                        Auth::User()->id //created by id
                    );
                }

                // Bank Transfer
                if ($sale->bank_transfer_amount > 0) {
                    if ($obj['bank_transfer_account_id'] == null || $obj['bank_transfer_account_id'] == '') {
                        $msg = 'Bank Transfer Account not select but bank transfer amount is greater then 0';
                        return $msg;
                    }
                    $bank_transfer_account = Account::find($obj['bank_transfer_account_id']);
                    $bank_transfer_Amount = str_replace(',', '', $sale->bank_transfer_amount ?? 0);
                    // PKR (Debit)
                    $this->journal_entry_service->saveJVDetail(
                        0, // currency 0 for PKR, 1 for AU, 2 for Dollar
                        $journal_entry_id, // journal entry id
                        'Bank Amount Transfer From Sale Debit Entry', //explaination
                        $sale->id, //bill no
                        0, // check no or 0
                        $sale->sale_date, //check date
                        1, // is credit flag 0 for credit, 1 for debit
                        $bank_transfer_Amount, //amount
                        $bank_transfer_account->id, // account id
                        $bank_transfer_account->code, // account code
                        Auth::User()->id //created by id
                    );
                }

                // Card Amount
                if ($sale->card_amount > 0) {
                    if ($obj['card_account_id'] == null || $obj['card_account_id'] == '') {
                        $msg = 'Card Account not select but card amount is greater then 0';
                        return $msg;
                    }
                    $card_account = Account::find($obj['card_account_id']);
                    $card_amount = str_replace(',', '', $sale->card_amount ?? 0);
                    // PKR (Debit)
                    $this->journal_entry_service->saveJVDetail(
                        0, // currency 0 for PKR, 1 for AU, 2 for Dollar
                        $journal_entry_id, // journal entry id
                        'Card Amount From Sale Debit Entry', //explaination
                        $sale->id, //bill no
                        0, // check no or 0
                        $sale->sale_date, //check date
                        1, // is credit flag 0 for credit, 1 for debit
                        $card_amount, //amount
                        $card_account->id, // account id
                        $card_account->code, // account code
                        Auth::User()->id //created by id
                    );
                }

                // advance Amount
                if ($sale->advance_amount > 0) {
                    if ($obj['advance_account_id'] == null || $obj['advance_account_id'] == '') {
                        $msg = 'Advance Account not select but advance amount is greater then 0';
                        return $msg;
                    }
                    $advance_account = Account::find($obj['advance_account_id']);
                    $advance_amount = str_replace(',', '', $sale->advance_amount ?? 0);
                    // PKR (Debit)
                    $this->journal_entry_service->saveJVDetail(
                        0, // currency 0 for PKR, 1 for AU, 2 for Dollar
                        $journal_entry_id, // journal entry id
                        'Advance Amount From Sale Debit Entry', //explaination
                        $sale->id, //bill no
                        0, // check no or 0
                        $sale->sale_date, //check date
                        1, // is credit flag 0 for credit, 1 for debit
                        $advance_amount, //amount
                        $advance_account->id, // account id
                        $advance_account->code, // account code
                        Auth::User()->id //created by id
                    );
                }

                // gold impure Amount
                if ($sale->gold_impure_amount > 0) {
                    if ($obj['gold_impurity_account_id'] == null || $obj['gold_impurity_account_id'] == '') {
                        $msg = 'Gold Impurity Account not select but gold impure amount is greater then 0';
                        return $msg;
                    }
                    $gold_impure_account = Account::find($obj['gold_impurity_account_id']);
                    $gold_impure_amount = str_replace(',', '', $sale->gold_impure_amount ?? 0);
                    // PKR (Debit)
                    $this->journal_entry_service->saveJVDetail(
                        0, // currency 0 for PKR, 1 for AU, 2 for Dollar
                        $journal_entry_id, // journal entry id
                        'Gold Impurity Amount From Sale Debit Entry', //explaination
                        $sale->id, //bill no
                        0, // check no or 0
                        $sale->sale_date, //check date
                        1, // is credit flag 0 for credit, 1 for debit
                        $gold_impure_amount, //amount
                        $gold_impure_account->id, // account id
                        $gold_impure_account->code, // account code
                        Auth::User()->id //created by id
                    );
                }

                $credit = $sale->total - $sale->total_received;
                // credit Amount
                if ($credit > 0) {
                    if ($customer->account_id == null || $customer->account_id == '') {
                        $msg = 'Customer Account has no account but paid amount is less then total amount';
                        return $msg;
                    }
                    $customer_account = Account::find($customer->account_id);
                    $credit_amount = str_replace(',', '', $credit ?? 0);
                    // PKR (Debit)
                    $this->journal_entry_service->saveJVDetail(
                        0, // currency 0 for PKR, 1 for AU, 2 for Dollar
                        $journal_entry_id, // journal entry id
                        'Credit Amount From Sale Debit Entry from ' . $sale->customer_name, //explaination
                        $sale->id, //bill no
                        0, // check no or 0
                        $sale->sale_date, //check date
                        1, // is credit flag 0 for credit, 1 for debit
                        $credit_amount, //amount
                        $customer_account->id, // account id
                        $customer_account->code, // account code
                        Auth::User()->id //created by id
                    );
                }

                // revenue Amount
                if ($sale->total > 0) {
                    if ($obj['revenue_account_id'] == null || $obj['revenue_account_id'] == '') {
                        $msg = 'Revenue Account not select!';
                        return $msg;
                    }
                    $revenue_account = Account::find($obj['revenue_account_id']);
                    $revenue_amount = str_replace(',', '', $sale->total ?? 0);
                    // PKR (Credit)
                    $this->journal_entry_service->saveJVDetail(
                        0, // currency 0 for PKR, 1 for AU, 2 for Dollar
                        $journal_entry_id, // journal entry id
                        'Revenue From Sale Credit Entry', //explaination
                        $sale->id, //bill no
                        0, // check no or 0
                        $sale->sale_date, //check date
                        0, // is credit flag 0 for credit, 1 for debit
                        $revenue_amount, //amount
                        $revenue_account->id, // account id
                        $revenue_account->code, // account code
                        Auth::User()->id //created by id
                    );
                }
                $sale->posted = 1;
                $sale->jv_id = $journal_entry_id;
                $sale->update();
            }
            DB::commit();
        } catch (Exception $e) {

            DB::rollback();
            throw $e;
        }
        return true;
    }
    public function unpost($sale_id)
    {
        try {
            DB::beginTransaction();

            $sale = $this->model_job_purchase->getModel()::find($sale_id);

            // Journal entry delete
            $journal_entry = $this->model_journal_entry->getModel()::find($sale->jv_id);
            $journal_entry->is_deleted = 1;
            $journal_entry->deletedby_id = Auth::user()->id;
            $journal_entry->update();

            // sale update
            $sale->posted = 0;
            $sale->jv_id = Null;
            $sale->update();

            DB::commit();
        } catch (Exception $e) {

            DB::rollback();
            throw $e;
        }
        return true;
    }

    public function deleteById($sale_id)
    {
        try {
            DB::beginTransaction();

            $sale = $this->model_job_purchase->getModel()::find($sale_id);

            if ($sale->jv_id != null && $sale->jv_id != '') {
                // Journal entry delete
                $journal_entry = $this->model_journal_entry->getModel()::find($sale->jv_id);
                $journal_entry->is_deleted = 1;
                $journal_entry->deletedby_id = Auth::user()->id;
                $journal_entry->update();
            }

            // sale update
            $sale->is_deleted = 1;
            $sale->deletedby_id = Auth::user()->id;
            $sale->posted = 0;
            $sale->jv_id = Null;
            $sale->update();

            DB::commit();
        } catch (Exception $e) {

            DB::rollback();
            throw $e;
        }
        return true;
    }

    public function statusById($id)
    {
        $job_purchase = $this->model_job_purchase->getModel()::find($id);
        if ($job_purchase->is_active == 0) {
            $job_purchase->is_active = 1;
        } else {
            $job_purchase->is_active = 0;
        }
        $job_purchase->updatedby_id = Auth::user()->id;
        $job_purchase->update();

        if ($job_purchase)
            return true;

        return false;
    }

}
