<?php

namespace App\Services\Concrete;

use App\Models\Account;
use App\Models\CompanySetting;
use App\Models\Customer;
use App\Models\CustomerPayment;
use App\Models\MetalProduct;
use App\Models\Journal;
use App\Models\JournalEntry;
use App\Repository\Repository;
use App\Models\MetalSale;
use App\Models\MetalPurchaseDetail;
use App\Models\MetalSaleDetail;
use App\Models\MetalSaleDetailBead;
use App\Models\MetalSaleDetailDiamond;
use App\Models\MetalSaleDetailStone;
use App\Models\SaleOrder;
use App\Models\SaleUsedGold;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class MetalSaleService
{
    // initialize protected model variables
    protected $model_metal_sale;
    protected $model_metal_sale_detail;
    protected $model_metal_sale_detail_bead;
    protected $model_metal_sale_detail_stone;
    protected $model_metal_sale_detail_diamond;
    protected $model_journal_entry;
    protected $model_metal_sale_used_gold;

    protected $common_service;
    protected $journal_entry_service;
    protected $customer_payment_service;
    protected $notification_service;
    public function __construct()
    {
        // set the model
        $this->model_metal_sale = new Repository(new MetalSale);
        $this->model_metal_sale_detail = new Repository(new MetalSaleDetail);
        $this->model_metal_sale_detail_bead = new Repository(new MetalSaleDetailBead);
        $this->model_metal_sale_detail_stone = new Repository(new MetalSaleDetailStone);
        $this->model_metal_sale_detail_diamond = new Repository(new MetalSaleDetailDiamond);
        $this->model_journal_entry = new Repository(new JournalEntry);
        $this->model_metal_sale_used_gold = new Repository(new SaleUsedGold);

        $this->common_service = new CommonService();
        $this->journal_entry_service = new JournalEntryService();
        $this->customer_payment_service = new CustomerPaymentService();
        $this->notification_service = new NotificationService();
    }

    public function getSaleSource($obj)
    {
        $wh = [];
        if ($obj['posted'] != '') {
            $wh[] = ['posted', $obj['posted']];
        }
        if ($obj['customer_id'] != '') {
            $wh[] = ['customer_id', $obj['customer_id']];
        }
        $model = $this->model_metal_sale->getModel()::has('MetalSaleDetail')->where('is_deleted', 0)
            ->whereBetween('metal_sale_date', [date("Y-m-d", strtotime(str_replace('/', '-', $obj['start']))), date("Y-m-d", strtotime(str_replace('/', '-', $obj['end'])))])
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
            ->addColumn('action', function ($item) {

                $jvs = '';
                if ($item->jv_id != null)
                    $jvs .= "filter[]=" . $item->jv_id . "";

                $action_column = '';
                $unpost = '<a class="text text-danger" id="unpost_metal_sale" data-toggle="tooltip" data-id="' . $item->id . '" data-original-title="Unpost" href="javascript:void(0)"><i class="fa fa-repeat"></i>Unpost</a>';
                $print_column    = "<a class='text-info mr-2' href='metal-sale/print/" . $item->id . "'><i title='Add' class='nav-icon mr-2 fa fa-print'></i>Print</a>";
                $all_print_column    = "<a class='text-info mr-2' id='Ref' href='javascript:void(0)' data-toggle='tooltip'  data-filter='" . $jvs . "' data-original-title='Accounting'><i title='Accounting' class='nav-icon mr-2 fa fa-eye'></i>Accounting</a>";
                $delete_column    = "<a class='text-danger mr-2' id='deleteMetalSale' href='javascript:void(0)' data-toggle='tooltip'  data-id='" . $item->id . "' data-original-title='Delete'><i title='Delete' class='nav-icon mr-2 fa fa-trash'></i>Delete</a>";
                $payment_column    = "<a class='text-primary mr-2' href='javascript:void(0)' id='createNewPayment' data-toggle='tooltip'  data-metal_sale_id='" . $item->id . "' data-customer_id='" . $item->customer_id . "'><i title='Add Payment' class='nav-icon mr-2 fa fa-dollar'></i>Add Payment</a>";
                // if (Auth::user()->can('customers_edit'))
                //     $action_column .= $edit_column;
                if (Auth::user()->can('customer_payment_create') && $item->total_received != $item->total)
                    $action_column .= $payment_column;
                if (Auth::user()->can('metal_sale_print'))
                    $action_column .= $print_column;
                if (Auth::user()->can('metal_sale_unpost') && $item->posted == 1)
                    $action_column .= $unpost;
                if (Auth::user()->can('metal_sale_jvs') && $item->posted == 1)
                    $action_column .= $all_print_column;

                if (Auth::user()->can('metal_sale_delete'))
                    $action_column .= $delete_column;

                return $action_column;
            })
            ->rawColumns(['check_box', 'posted', 'action'])
            ->addIndexColumn()
            ->make(true);
        return $data;
    }

    public function getAllMetalSale()
    {
        return $this->model_metal_sale->getModel()::with('customer_name')
            ->where('is_deleted', 0)
            ->get();
    }
    public function saveMetalSale()
    {
        try {
            DB::beginTransaction();
            $obj = [
                'metal_sale_no' => $this->common_service->generateMetalSaleNo(),
                'createdby_id' => Auth::User()->id
            ];
            $saved_obj = $this->model_metal_sale->create($obj);

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
            $customer = Customer::find($obj['customer_id']);
            $metalSaleDetail = json_decode($obj['productDetail']);
            // $usedGold = json_decode($obj['usedGoldDetail']);
            $selectedAdvanceIds = json_decode($obj['selected_advance_ids'], true);
            $metalSaleObj = [
                "metal_sale_date" => $obj['metal_sale_date'],
                "customer_id" => $obj['customer_id'],
                "customer_name" => $customer->name ?? '',
                "customer_cnic" => $customer->cnic ?? '',
                "customer_contact" => $customer->contact ?? '',
                "customer_address" => $customer->address ?? '',
                "total_qty" => count($metalSaleDetail) ?? 0,
                "sub_total" => $obj['sub_total'],
                "discount_amount" => $obj['discount_amount'] ?? 0,
                "total" => $obj['total'],
                "advance_amount" => $obj['advance_amount'] ?? 0,
                // "gold_impure_amount" => $obj['gold_impurity_amount'] ?? 0,
                "total_received" => $obj['advance_amount'],
                "change_amount" => $obj['change_amount'] ?? 0,
                "updatedby_id" => Auth::user()->id
            ];
            $metal_sale = $this->model_metal_sale->update($metalSaleObj, $obj['id']);
            foreach ($metalSaleDetail as $item) {
                $metalSaleDetailObj = [
                    "metal_sale_id" => $obj['id'],
                    "metal_product_id" => ($item->metal_product_id != '') ? $item->metal_product_id : null,
                    "metal_purchase_id" => ($item->metal_purchase_id != '') ? $item->metal_purchase_id : null,
                    "metal_purchase_detail_id" => ($item->metal_purchase_detail_id != '') ? $item->metal_purchase_detail_id : null,
                    // "job_purchase_detail_id" => ($item->job_purchase_detail_id != '') ? $item->job_purchase_detail_id : null,
                    "product_id" => ($item->product_id != '') ? $item->product_id : null,
                    "purity" => $item->purity,
                    "metal" => $item->metal,
                    "metal_rate" => $item->metal_rate,
                    "scale_weight" => $item->scale_weight,
                    "bead_weight" => $item->bead_weight,
                    "stones_weight" => $item->stones_weight,
                    "diamond_weight" => $item->diamond_weight,
                    "net_weight" => $item->net_weight,
                    "gross_weight" => $item->gross_weight,
                    "total_metal_amount" => $item->total_metal_amount,
                    "other_charges" => $item->other_charges,
                    "total_bead_amount" => $item->total_bead_amount,
                    "total_stones_amount" => $item->total_stones_amount,
                    "total_diamond_amount" => $item->total_diamond_amount,
                    "total_amount" => $item->total_amount,
                    "createdby_id" => Auth::user()->id
                ];
                $metal_sale_detail = $this->model_metal_sale_detail->create($metalSaleDetailObj);

                foreach ($item->beadDetail as $item1) {
                    $metalSaleDetailBead = [
                        "metal_sale_detail_id" => $metal_sale_detail->id,
                        "type" => $item1->type,
                        "beads" => $item1->beads,
                        "gram" => $item1->gram,
                        "carat" => $item1->carat,
                        "gram_rate" => $item1->gram_rate,
                        "carat_rate" => $item1->carat_rate,
                        "total_amount" => $item1->total_amount,
                    ];
                    $this->model_metal_sale_detail_bead->create($metalSaleDetailBead);
                }

                // Stone Detail
                foreach ($item->stonesDetail as $item1) {
                    $metalSaleDetailStone = [
                        "metal_sale_detail_id" => $metal_sale_detail->id,
                        "category" => $item1->category ?? '',
                        "type" => $item1->type ?? '',
                        "stones" => $item1->stones,
                        "gram" => $item1->gram,
                        "carat" => $item1->carat,
                        "gram_rate" => $item1->gram_rate,
                        "carat_rate" => $item1->carat_rate,
                        "total_amount" => $item1->total_amount,
                    ];
                    $this->model_metal_sale_detail_stone->create($metalSaleDetailStone);
                }

                // Diamond Detail
                foreach ($item->diamondDetail as $item1) {
                    $metalSaleDetailDiamond = [
                        "metal_sale_detail_id" => $metal_sale_detail->id,
                        "type" => $item1->type,
                        "diamonds" => $item1->diamonds,
                        "color" => $item1->color,
                        "cut" => $item1->cut,
                        "clarity" => $item1->clarity,
                        "carat" => $item1->carat,
                        "carat_rate" => $item1->carat_rate,
                        "total_amount" => $item1->total_amount,
                    ];
                    $this->model_metal_sale_detail_diamond->create($metalSaleDetailDiamond);
                }

                $metal_product = MetalProduct::find($item->metal_product_id);
                if ($metal_product->parent_id > 0) {
                    $parent = MetalProduct::where('parent_id', $metal_product->parent_id)
                        ->where('is_saled', 0)->get();
                    if (count($parent) == 1) {
                        $parent_update = MetalProduct::find($metal_product->parent_id);
                        $parent_update->is_saled = 1;
                        $parent_update->updatedby_id = Auth::user()->id;
                        $parent_update->update();
                    }
                }
                $metal_product->is_saled = 1;
                $metal_product->updatedby_id = Auth::user()->id;
                $metal_product->update();
            }

            // foreach ($usedGold as $item) {
            //     $usedGoldObj = [
            //         "sale_id" => $obj['id'],
            //         "type" => $item->type ?? '',
            //         "weight" => $item->weight ?? 0,
            //         "kaat" => $item->kaat ?? 0,
            //         "pure_weight" => $item->pure_weight ?? 0,
            //         "karat" => $item->karat ?? 0,
            //         "rate" => $item->rate ?? 0,
            //         "amount" => $item->amount ?? 0,
            //         "description" => $item->description ?? ''
            //     ];
            //     $sale_used_gold = $this->model_metal_sale_used_gold->create($usedGoldObj);
            // }
            if (!empty($selectedAdvanceIds)) {
                CustomerPayment::whereIn('id', $selectedAdvanceIds)
                    ->update(['is_used' => 1]);
            }
            if (getRoleName() == config('enum.salesman')) {
                foreach (Admins() as $item) {
                    $data = [
                        "title" => 'New Sale',
                        "user_id" => $item,
                        "message" => 'New Metal Sale Generate by ' . Auth::user()->name
                    ];
                    $this->notification_service->save($data);
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
        return $this->model_metal_sale->getModel()::with('customer_name')->find($id);
    }

    public function metalSaleDetail($sale_id)
    {
        $metal_sale_detail = $this->model_metal_sale_detail->getModel()::with([
            'metal_product',
            'product'
        ])
            ->where('metal_sale_id', $sale_id)
            ->where('is_deleted', 0)->get();

        $data = [];
        foreach ($metal_sale_detail as $item) {
            $bead_detail = $this->model_metal_sale_detail_bead->getModel()::where('metal_sale_detail_id', $item->id)
                ->where('is_deleted', 0)->get();
            $stone_detail = $this->model_metal_sale_detail_stone->getModel()::where('metal_sale_detail_id', $item->id)
                ->where('is_deleted', 0)->get();
            $diamond_detail = $this->model_metal_sale_detail_diamond->getModel()::where('metal_sale_detail_id', $item->id)
                ->where('is_deleted', 0)->get();
            $data[] = [
                "tag_no" => $item->metal_product->tag_no ?? '',
                "product" => $item->product->name ?? '',
                "metal" => $item->metal,
                "purity" => $item->purity,
                "metal_rate" => $item->metal_rate,
                "scale_weight" => $item->scale_weight,
                "bead_weight" => $item->bead_weight,
                "stones_weight" => $item->stones_weight,
                "diamond_weight" => $item->diamond_weight,
                "net_weight" => $item->net_weight,
                "gross_weight" => $item->gross_weight,
                "total_metal_amount" => $item->total_metal_amount,
                "other_charges" => $item->other_charges,
                "total_bead_price" => $item->total_bead_price,
                "total_stones_price" => $item->total_stones_price,
                "total_diamond_price" => $item->total_diamond_price,
                "total_amount" => $item->total_amount,
                "bead_detail" => $bead_detail,
                "stone_detail" => $stone_detail,
                "diamond_detail" => $diamond_detail
            ];
        }

        return $data;
    }

    public function postMetalSale($obj)
    {

        try {
            DB::beginTransaction();

            $journal_entry_id = null;
            $jv_id = null;
            $company_setting = CompanySetting::find(1);
            $metal_sale_account = Account::find($company_setting->sale_account_id);
            foreach ($obj['sale'] as $item) {
                $metal_sale = MetalSale::with('customer_name')->find($item);
                $customer = Customer::find($metal_sale->customer_id);
                $customer_account = Account::find($customer->account_id);

                $journal = Journal::find(config('enum.SV'));
                $metal_sale_date = date("Y-m-d", strtotime(str_replace('/', '-', $metal_sale->metal_sale_date)));
                // Add journal entry
                $data = [
                    "date" => $metal_sale_date,
                    "prefix" => $journal->prefix,
                    "journal_id" => $journal->id
                ];
                $entryNum = $this->journal_entry_service->generateJournalEntryNum($data);

                $journal_entry = new JournalEntry;
                $journal_entry->journal_id = $journal->id;
                $journal_entry->customer_id = $metal_sale->customer_id;
                $journal_entry->metal_sale_id = $metal_sale->id;
                $journal_entry->date_post = date("Y-m-d", strtotime(str_replace('/', '-', $metal_sale->metal_sale_date)));
                $journal_entry->reference = 'Date :' . $metal_sale->metal_sale_date . ' Metal Sale ' . $metal_sale->sale_no . '. Customer is ' . $metal_sale->customer_name;
                $journal_entry->entryNum = $entryNum;
                $journal_entry->createdby_id = Auth::User()->id;
                $journal_entry->save();

                $journal_entry_id = $journal_entry->id ?? null;
                // credit to customer
                if ($metal_sale->total > 0) {
                    $credit_amount = str_replace(',', '', $metal_sale->total ?? 0);
                    // PKR (Debit)
                    $this->journal_entry_service->saveJVDetail(
                        0, // currency 0 for PKR, 1 for AU, 2 for Dollar
                        $journal_entry_id, // journal entry id
                        'Credit Amount From Metal Sale Debit Entry To ' . $customer_account->name ?? '', //explaination
                        $metal_sale->id, //bill no
                        0, // check no or 0
                        $metal_sale->metal_sale_date, //check date
                        1, // is credit flag 0 for credit, 1 for debit
                        $credit_amount, //amount
                        $customer_account->id, // account id
                        $customer_account->code, // account code
                        Auth::User()->id //created by id
                    );
                }

                // debit discount amount
                if ($metal_sale->discount_amount > 0) {
                    if ($obj['discount_account_id'] == null || $obj['discount_account_id'] == '') {
                        $msg = 'Revenue Account not select!';
                        return $msg;
                    }
                    $discount_account = Account::find($obj['discount_account_id']);
                    $discount_amount = str_replace(',', '', $metal_sale->discount_amount ?? 0);
                    // PKR (Debit)
                    $this->journal_entry_service->saveJVDetail(
                        0, // currency 0 for PKR, 1 for AU, 2 for Dollar
                        $journal_entry_id, // journal entry id
                        'Discount Amount From Metal Sale Debit Entry To ' . $discount_account->name ?? '', //explaination
                        $metal_sale->id, //bill no
                        0, // check no or 0
                        $metal_sale->sale_date, //check date
                        1, // is credit flag 0 for credit, 1 for debit
                        $discount_amount, //amount
                        $discount_account->id, // account id
                        $discount_account->code, // account code
                        Auth::User()->id //created by id
                    );
                }
                // revenue Amount
                if ($metal_sale->sub_total > 0) {
                    if ($obj['revenue_account_id'] == null || $obj['revenue_account_id'] == '') {
                        $msg = 'Revenue Account not select!';
                        return $msg;
                    }
                    $revenue_account = Account::find($obj['revenue_account_id']);
                    $revenue_amount = str_replace(',', '', $metal_sale->sub_total ?? 0);
                    // PKR (Credit)
                    $this->journal_entry_service->saveJVDetail(
                        0, // currency 0 for PKR, 1 for AU, 2 for Dollar
                        $journal_entry_id, // journal entry id
                        'Revenue From Metal Sale Credit Entry', //explaination
                        $metal_sale->id, //bill no
                        0, // check no or 0
                        $metal_sale->metal_sale_date, //check date
                        0, // is credit flag 0 for credit, 1 for debit
                        $revenue_amount, //amount
                        $revenue_account->id, // account id
                        $revenue_account->code, // account code
                        Auth::User()->id //created by id
                    );
                }

                // advance amount
                if ($metal_sale->advance_amount > 0) {
                    $Advance_Amount = str_replace(',', '', $metal_sale->advance_amount ?? 0);
                    // PKR (Debit)
                    $this->journal_entry_service->saveJVDetail(
                        0, // currency 0 for PKR, 1 for AU, 2 for Dollar
                        $journal_entry_id, // journal entry id
                        'Advance Used For Metal Sale Debit Entry', //explaination
                        $metal_sale->id, //bill no
                        0, // check no or 0
                        $metal_sale->metal_sale_date, //check date
                        1, // is credit flag 0 for credit, 1 for debit
                        $Advance_Amount, //amount
                        $customer_account->id, // account id
                        $customer_account->code, // account code
                        Auth::User()->id //created by id
                    );
                    // PKR (Credit)
                    $this->journal_entry_service->saveJVDetail(
                        0, // currency 0 for PKR, 1 for AU, 2 for Dollar
                        $journal_entry_id, // journal entry id
                        'Advance Used For Sale Credit Entry', //explaination
                        $metal_sale->id, //bill no
                        0, // check no or 0
                        $metal_sale->metal_sale_date, //check date
                        0, // is credit flag 0 for credit, 1 for debit
                        $Advance_Amount, //amount
                        $metal_sale_account->id, // account id
                        $metal_sale_account->code, // account code
                        Auth::User()->id //created by id
                    );
                }
                // if ($metal_sale->gold_impure_amount > 0) {
                //     $gold_impure_amount = str_replace(',', '', $sale->gold_impure_amount ?? 0);
                //     // PKR (Debit)
                //     $this->journal_entry_service->saveJVDetail(
                //         0, // currency 0 for PKR, 1 for AU, 2 for Dollar
                //         $journal_entry_id, // journal entry id
                //         'Gold Impurity Amount From Metal Sale Debit Entry', //explaination
                //         $metal_sale->id, //bill no
                //         0, // check no or 0
                //         $metal_sale->metal_sale_date, //check date
                //         1, // is credit flag 0 for credit, 1 for debit
                //         $gold_impure_amount, //amount
                //         $metal_sale_account->id, // account id
                //         $metal_sale_account->code, // account code
                //         Auth::User()->id //created by id
                //     );
                //     // PKR (Credit)
                //     $this->journal_entry_service->saveJVDetail(
                //         0, // currency 0 for PKR, 1 for AU, 2 for Dollar
                //         $journal_entry_id, // journal entry id
                //         'Gold Impurity Amount From Metal Sale Credit Entry', //explaination
                //         $metal_sale->id, //bill no
                //         0, // check no or 0
                //         $metal_sale->metal_sale_date, //check date
                //         0, // is credit flag 0 for credit, 1 for debit
                //         $gold_impure_amount, //amount
                //         $customer_account->id, // account id
                //         $customer_account->code, // account code
                //         Auth::User()->id //created by id
                //     );
                // }

                $metal_sale->posted = 1;
                $metal_sale->jv_id = $journal_entry_id;
                $metal_sale->update();
            }
            DB::commit();
        } catch (Exception $e) {

            DB::rollback();
            throw $e;
        }
        return true;
    }
    public function unpostMetalSale($metal_sale_id)
    {
        try {
            DB::beginTransaction();

            $metal_sale = $this->model_metal_sale->getModel()::find($metal_sale_id);

            // Journal entry delete
            $journal_entry = $this->model_journal_entry->getModel()::find($metal_sale->jv_id);
            $journal_entry->is_deleted = 1;
            $journal_entry->deletedby_id = Auth::user()->id;
            $journal_entry->update();

            // sale update
            $metal_sale->posted = 0;
            $metal_sale->jv_id = Null;
            $metal_sale->update();

            DB::commit();
        } catch (Exception $e) {

            DB::rollback();
            throw $e;
        }
        return true;
    }
    public function salePayment($obj)
    {
        try {
            DB::beginTransaction();
            $metal_sale = MetalSale::with('customer_name')->find($obj['metal_sale_id']);
            $customer = Customer::find($obj['customer_id']);
            $customer_account = Account::find($customer->account_id);
            $company_setting = CompanySetting::find(1);
            $sale_account = Account::find($company_setting->sale_account_id);

            $journal = Journal::find(config('enum.CRV'));
            $payment_date = date("Y-m-d", strtotime(str_replace('/', '-', Carbon::now())));
            // Add journal entry
            $data = [
                "date" => $payment_date,
                "prefix" => $journal->prefix,
                "journal_id" => $journal->id
            ];
            $entryNum = $this->journal_entry_service->generateJournalEntryNum($data);

            $journal_entry = new JournalEntry;
            $journal_entry->journal_id = $journal->id;
            $journal_entry->customer_id = $metal_sale->customer_id;
            $journal_entry->metal_sale_id = $metal_sale->id;
            $journal_entry->date_post = $payment_date;
            $journal_entry->reference = 'Date :' . $payment_date . ' Cash Receipt Voucher ' . $metal_sale->metal_sale_no . '. Customer is ' . $metal_sale->customer_name;
            $journal_entry->entryNum = $entryNum;
            $journal_entry->createdby_id = Auth::User()->id;
            $journal_entry->save();

            $journal_entry_id = $journal_entry->id ?? null;

            // advance amount
            if ($obj['advance_amount'] > 0) {
                $Advance_Amount = str_replace(',', '', $obj['advance_amount'] ?? 0);
                // PKR (Debit)
                $this->journal_entry_service->saveJVDetail(
                    0, // currency 0 for PKR, 1 for AU, 2 for Dollar
                    $journal_entry_id, // journal entry id
                    'Advance Used For Metal Sale Debit Entry', //explaination
                    $metal_sale->id, //bill no
                    0, // check no or 0
                    $payment_date, //check date
                    1, // is credit flag 0 for credit, 1 for debit
                    $Advance_Amount, //amount
                    $customer_account->id, // account id
                    $customer_account->code, // account code
                    Auth::User()->id //created by id
                );
                // PKR (Credit)
                $this->journal_entry_service->saveJVDetail(
                    0, // currency 0 for PKR, 1 for AU, 2 for Dollar
                    $journal_entry_id, // journal entry id
                    'Advance Used For Metal Sale Credit Entry', //explaination
                    $metal_sale->id, //bill no
                    0, // check no or 0
                    $payment_date, //check date
                    0, // is credit flag 0 for credit, 1 for debit
                    $Advance_Amount, //amount
                    $sale_account->id, // account id
                    $sale_account->code, // account code
                    Auth::User()->id //created by id
                );
            }

            // cash amount
            if ($obj['cash_amount'] > 0) {
                if ($obj['cash_account_id'] == null || $obj['cash_account_id'] == '') {
                    $msg = 'Cash Account not select but cash amount is greater then 0';
                    return $msg;
                }
                $cash_account = Account::find($obj['cash_account_id']);
                $Cash_Amount = str_replace(',', '', $obj['cash_amount'] ?? 0);
                // PKR (Debit)
                $this->journal_entry_service->saveJVDetail(
                    0, // currency 0 for PKR, 1 for AU, 2 for Dollar
                    $journal_entry_id, // journal entry id
                    'Cash Amount From Metal Sale Debit Entry', //explaination
                    $metal_sale->id, //bill no
                    0, // check no or 0
                    $payment_date, //check date
                    1, // is credit flag 0 for credit, 1 for debit
                    $Cash_Amount, //amount
                    $cash_account->id, // account id
                    $cash_account->code, // account code
                    Auth::User()->id //created by id
                );

                // PKR (Credit)
                $this->journal_entry_service->saveJVDetail(
                    0, // currency 0 for PKR, 1 for AU, 2 for Dollar
                    $journal_entry_id, // journal entry id
                    'Cash Amount From Metal Sale Credit Entry', //explaination
                    $metal_sale->id, //bill no
                    0, // check no or 0
                    $payment_date, //check date
                    0, // is credit flag 0 for credit, 1 for debit
                    $Cash_Amount, //amount
                    $customer_account->id, // account id
                    $customer_account->code, // account code
                    Auth::User()->id //created by id
                );

                $this->customer_payment_service->saveCustomerPaymentWithoutTax(
                    $customer->id, //customer id
                    0,
                    $cash_account->id,
                    $payment_date,
                    $obj['cash_reference'],
                    $Cash_Amount,
                    $journal_entry
                );
            }

            // Bank Transfer
            if ($obj['bank_transfer_amount'] > 0) {
                if ($obj['bank_transfer_account_id'] == null || $obj['bank_transfer_account_id'] == '') {
                    $msg = 'Bank Transfer Account not select but bank transfer amount is greater then 0';
                    return $msg;
                }
                $bank_transfer_account = Account::find($obj['bank_transfer_account_id']);
                $bank_transfer_Amount = str_replace(',', '', $obj['bank_transfer_amount'] ?? 0);
                // PKR (Debit)
                $this->journal_entry_service->saveJVDetail(
                    0, // currency 0 for PKR, 1 for AU, 2 for Dollar
                    $journal_entry_id, // journal entry id
                    'Bank Amount Transfer From Metal Sale Debit Entry', //explaination
                    $metal_sale->id, //bill no
                    0, // check no or 0
                    $payment_date, //check date
                    1, // is credit flag 0 for credit, 1 for debit
                    $bank_transfer_Amount, //amount
                    $bank_transfer_account->id, // account id
                    $bank_transfer_account->code, // account code
                    Auth::User()->id //created by id
                );

                // PKR (Credit)
                $this->journal_entry_service->saveJVDetail(
                    0, // currency 0 for PKR, 1 for AU, 2 for Dollar
                    $journal_entry_id, // journal entry id
                    'Bank Transfer Amount From Metal Sale Credit Entry', //explaination
                    $metal_sale->id, //bill no
                    0, // check no or 0
                    $payment_date, //check date
                    0, // is credit flag 0 for credit, 1 for debit
                    $bank_transfer_Amount, //amount
                    $customer_account->id, // account id
                    $customer_account->code, // account code
                    Auth::User()->id //created by id
                );

                $this->customer_payment_service->saveCustomerPaymentWithoutTax(
                    $customer->id, //customer id
                    0, // currency
                    $bank_transfer_account->id, // recieved account
                    $payment_date, // date
                    $obj['cash_reference'], //reference
                    $bank_transfer_Amount, //amount
                    $journal_entry // journal entries
                );
            }

            // Card Amount
            if ($obj['card_amount'] > 0) {
                if ($obj['card_account_id'] == null || $obj['card_account_id'] == '') {
                    $msg = 'Card Account not select but card amount is greater then 0';
                    return $msg;
                }
                $card_account = Account::find($obj['card_account_id']);
                $card_amount = str_replace(',', '', $obj['card_amount'] ?? 0);
                // PKR (Debit)
                $this->journal_entry_service->saveJVDetail(
                    0, // currency 0 for PKR, 1 for AU, 2 for Dollar
                    $journal_entry_id, // journal entry id
                    'Card Amount From Metal Sale Debit Entry', //explaination
                    $metal_sale->id, //bill no
                    0, // check no or 0
                    $payment_date, //check date
                    1, // is credit flag 0 for credit, 1 for debit
                    $card_amount, //amount
                    $card_account->id, // account id
                    $card_account->code, // account code
                    Auth::User()->id //created by id
                );
                // PKR (Credit)
                $this->journal_entry_service->saveJVDetail(
                    0, // currency 0 for PKR, 1 for AU, 2 for Dollar
                    $journal_entry_id, // journal entry id
                    'Card Amount From Metal Sale Credit Entry', //explaination
                    $metal_sale->id, //bill no
                    0, // check no or 0
                    $payment_date, //check date
                    0, // is credit flag 0 for credit, 1 for debit
                    $card_amount, //amount
                    $customer_account->id, // account id
                    $customer_account->code, // account code
                    Auth::User()->id //created by id
                );

                $this->customer_payment_service->saveCustomerPaymentWithoutTax(
                    $customer->id, //customer id
                    0, // currency
                    $card_account->id, // recieved account
                    $payment_date, // date
                    $obj['card_reference'], //reference
                    $card_amount, //amount
                    $journal_entry // journal entries
                );
            }

            
            $metal_sale->advance_amount = $metal_sale->advance_amount + $obj['advance_amount'] ?? 0;
            $metal_sale->cash_amount = $metal_sale->cash_amount + $obj['cash_amount'] ?? 0;
            $metal_sale->bank_transfer_amount = $metal_sale->bank_transfer_amount + $obj['bank_transfer_amount'] ?? 0;
            $metal_sale->card_amount = $metal_sale->card_amount + $obj['card_amount'] ?? 0;
            // $sale->gold_impure_amount = $sale->gold_impure_amount + $obj['gold_impurity_amount'] ?? 0;
            $metal_sale->total_received = $metal_sale->total_received + $obj['total_received'];
            $metal_sale->update();
            // if ($obj['sale_order_id'] != '' && $obj['sale_order_id'] != 0) {
            //     $sale_order = SaleOrder::find($obj['sale_order_id']);
            //     $sale_order->is_saled = 1;
            //     $sale_order->is_complete = 1;
            //     $sale_order->update();
            // }
            DB::commit();
        } catch (Exception $e) {

            DB::rollback();
            throw $e;
        }
        return true;
    }
    public function deleteMetalSaleById($metal_sale_id)
    {
        try {
            DB::beginTransaction();

            $metal_sale = $this->model_metal_sale->getModel()::find($metal_sale_id);

            if ($metal_sale->jv_id != null && $metal_sale->jv_id != '') {
                // Journal entry delete
                $journal_entry = $this->model_journal_entry->getModel()::find($metal_sale->jv_id);
                $journal_entry->is_deleted = 1;
                $journal_entry->deletedby_id = Auth::user()->id;
                $journal_entry->update();
            }

            // sale update
            $metal_sale->is_deleted = 1;
            $metal_sale->deletedby_id = Auth::user()->id;
            $metal_sale->posted = 0;
            $metal_sale->jv_id = Null;
            $metal_sale->update();

            DB::commit();
        } catch (Exception $e) {

            DB::rollback();
            throw $e;
        }
        return true;
    }

    public function statusById($id)
    {
        $metal_sale = $this->model_metal_sale->getModel()::find($id);
        if ($metal_sale->is_active == 0) {
            $metal_sale->is_active = 1;
        } else {
            $metal_sale->is_active = 0;
        }
        $metal_sale->updatedby_id = Auth::user()->id;
        $metal_sale->update();

        if ($metal_sale)
            return true;

        return false;
    }

    public function deleteById($id)
    {
        $metal_sale = $this->model_metal_sale->getModel()::find($id);

        $metal_purchase_detail = MetalPurchaseDetail::find($metal_sale->metal_purchase_detail_id);
        $metal_purchase_detail->is_finish_product = 0;
        $metal_purchase_detail->update();

        $metal_sale->is_deleted = 1;
        $metal_sale->deletedby_id = Auth::user()->id;
        $metal_sale->update();

        if ($metal_sale)
            return true;

        return false;
    }
}
