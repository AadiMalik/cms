<?php

namespace App\Services\Concrete;

use App\Models\Account;
use App\Models\Customer;
use App\Models\FinishProduct;
use App\Models\Journal;
use App\Models\JournalEntry;
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

class SaleService
{
    // initialize protected model variables
    protected $model_sale;
    protected $model_sale_detail;
    protected $model_sale_detail_bead;
    protected $model_sale_detail_stone;
    protected $model_sale_detail_diamond;
    protected $model_journal_entry;

    protected $common_service;
    protected $journal_entry_service;
    public function __construct()
    {
        // set the model
        $this->model_sale = new Repository(new Sale);
        $this->model_sale_detail = new Repository(new SaleDetail);
        $this->model_sale_detail_bead = new Repository(new SaleDetailBead);
        $this->model_sale_detail_stone = new Repository(new SaleDetailStone);
        $this->model_sale_detail_diamond = new Repository(new SaleDetailDiamond);
        $this->model_journal_entry = new Repository(new JournalEntry);

        $this->common_service = new CommonService();
        $this->journal_entry_service = new JournalEntryService();
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
        $model = $this->model_sale->getModel()::has('SaleDetail')->where('is_deleted', 0)
            ->whereBetween('sale_date', [date("Y-m-d", strtotime(str_replace('/', '-', $obj['start']))), date("Y-m-d", strtotime(str_replace('/', '-', $obj['end'])))])
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
                $unpost = '<a class="text text-danger" id="unpost_sale" data-toggle="tooltip" data-id="' . $item->id . '" data-original-title="Unpost" href="javascript:void(0)"><i class="fa fa-repeat"></i>Unpost</a>';
                $print_column    = "<a class='text-info mr-2' href='sale/print/" . $item->id . "'><i title='Add' class='nav-icon mr-2 fa fa-print'></i>Print</a>";
                $all_print_column    = "<a class='text-info mr-2' id='Ref' href='javascript:void(0)' data-toggle='tooltip'  data-filter='" . $jvs . "' data-original-title='Accounting'><i title='Accounting' class='nav-icon mr-2 fa fa-eye'></i>Accounting</a>";
                $delete_column    = "<a class='text-danger mr-2' id='deleteSale' href='javascript:void(0)' data-toggle='tooltip'  data-id='" . $item->id . "' data-original-title='Delete'><i title='Delete' class='nav-icon mr-2 fa fa-trash'></i>Delete</a>";

                // if (Auth::user()->can('customers_edit'))
                //     $action_column .= $edit_column;

                if (Auth::user()->can('sale_print'))
                    $action_column .= $print_column;
                if (Auth::user()->can('sale_unpost') && $item->posted == 1)
                    $action_column .= $unpost;
                if (Auth::user()->can('sale_jvs') && $item->posted == 1)
                    $action_column .= $all_print_column;

                if (Auth::user()->can('sale_delete'))
                    $action_column .= $delete_column;

                return $action_column;
            })
            ->rawColumns(['check_box', 'posted', 'action'])
            ->addIndexColumn()
            ->make(true);
        return $data;
    }

    public function getAllSale()
    {
        return $this->model_sale->getModel()::with('customer_name')
            ->where('is_deleted', 0)
            ->get();
    }
    public function saveSale()
    {
        try {
            DB::beginTransaction();
            $obj = [
                'sale_no' => $this->common_service->generateSaleNo(),
                'createdby_id' => Auth::User()->id
            ];
            $saved_obj = $this->model_sale->create($obj);

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
            $saleDetail = json_decode($obj['productDetail']);
            $saleObj = [
                "sale_date" => $obj['sale_date'],
                "customer_id" => $obj['customer_id'],
                "customer_name" => $customer->name ?? '',
                "customer_cnic" => $customer->cnic ?? '',
                "customer_contact" => $customer->contact ?? '',
                "customer_address" => $customer->address ?? '',
                "total_qty" => count($saleDetail) ?? 0,
                "total" => $obj['total'],
                "cash_amount" => $obj['cash_amount'] ?? 0,
                "bank_transfer_amount" => $obj['bank_transfer_amount'] ?? 0,
                "card_amount" => $obj['card_amount'] ?? 0,
                "advance_amount" => $obj['advance_amount'] ?? 0,
                "gold_impure_amount" => $obj['gold_impure_amount'] ?? 0,
                "total_received" => $obj['cash_amount'] + $obj['bank_transfer_amount'] + $obj['card_amount'] + $obj['advance_amount'] + $obj['gold_impure_amount'],
                "updatedby_id" => Auth::user()->id
            ];
            $sale = $this->model_sale->update($saleObj, $obj['id']);

            foreach ($saleDetail as $item) {
                $saleDetailObj = [
                    "sale_id" => $obj['id'],
                    "finish_product_id" => ($item->finish_product_id != '') ? $item->finish_product_id : null,
                    "ratti_kaat_id" => ($item->ratti_kaat_id != '') ? $item->ratti_kaat_id : null,
                    "ratti_kaat_detail_id" => ($item->ratti_kaat_detail_id != '') ? $item->ratti_kaat_detail_id : null,
                    "job_purchase_detail_id" => ($item->job_purchase_detail_id != '') ? $item->job_purchase_detail_id : null,
                    "product_id" => ($item->product_id != '') ? $item->product_id : null,
                    "gold_carat" => $item->gold_carat,
                    "scale_weight" => $item->scale_weight,
                    "bead_weight" => $item->bead_weight,
                    "stones_weight" => $item->stones_weight,
                    "diamond_weight" => $item->diamond_weight,
                    "net_weight" => $item->net_weight,
                    "gross_weight" => $item->gross_weight,
                    "waste" => $item->waste,
                    "making" => $item->making,
                    "gold_rate" => $item->gold_rate,
                    "total_gold_price" => $item->total_gold_price,
                    "other_amount" => $item->other_amount,
                    "total_bead_price" => $item->total_bead_price,
                    "total_stones_price" => $item->total_stones_price,
                    "total_diamond_price" => $item->total_diamond_price,
                    "total_amount" => $item->total_amount,
                    "createdby_id" => Auth::user()->id
                ];
                $sale_detail = $this->model_sale_detail->create($saleDetailObj);

                foreach ($item->beadDetail as $item1) {
                    $saleDetailBead = [
                        "sale_detail_id" => $sale_detail->id,
                        "type" => $item1->type,
                        "beads" => $item1->beads,
                        "gram" => $item1->gram,
                        "carat" => $item1->carat,
                        "gram_rate" => $item1->gram_rate,
                        "carat_rate" => $item1->carat_rate,
                        "total_amount" => $item1->total_amount,
                    ];
                    $this->model_sale_detail_bead->create($saleDetailBead);
                }

                // Stone Detail
                foreach ($item->stonesDetail as $item1) {
                    $saleDetailStone = [
                        "sale_detail_id" => $sale_detail->id,
                        "category" => $item1->category ?? '',
                        "type" => $item1->type ?? '',
                        "stones" => $item1->stones,
                        "gram" => $item1->gram,
                        "carat" => $item1->carat,
                        "gram_rate" => $item1->gram_rate,
                        "carat_rate" => $item1->carat_rate,
                        "total_amount" => $item1->total_amount,
                    ];
                    $this->model_sale_detail_stone->create($saleDetailStone);
                }

                // Diamond Detail
                foreach ($item->diamondDetail as $item1) {
                    $saleDetailDiamond = [
                        "sale_detail_id" => $sale_detail->id,
                        "type" => $item1->type,
                        "diamonds" => $item1->diamonds,
                        "color" => $item1->color,
                        "cut" => $item1->cut,
                        "clarity" => $item1->clarity,
                        "carat" => $item1->carat,
                        "carat_rate" => $item1->carat_rate,
                        "total_amount" => $item1->total_amount,
                    ];
                    $this->model_sale_detail_diamond->create($saleDetailDiamond);
                }

                $finish_product = FinishProduct::find($item->finish_product_id);
                if ($finish_product->parent_id > 0) {
                    $parent = FinishProduct::where('parent_id', $finish_product->parent_id)
                        ->where('is_saled', 0)->get();
                    if (count($parent)==1) {
                        $parent_update = FinishProduct::find($finish_product->parent_id);
                        $parent_update->is_saled = 1;
                        $parent_update->updatedby_id = Auth::user()->id;
                        $parent_update->update();
                    }
                }
                $finish_product->is_saled = 1;
                $finish_product->updatedby_id = Auth::user()->id;
                $finish_product->update();
            }

            DB::commit();
        } catch (Exception $e) {
            return $e;
        }

        return true;
    }

    public function getById($id)
    {
        return $this->model_sale->getModel()::with('customer_name')->find($id);
    }

    public function saleDetail($sale_id)
    {
        $sale_detail = $this->model_sale_detail->getModel()::with([
            'finish_product',
            'product'
        ])
            ->where('sale_id', $sale_id)
            ->where('is_deleted', 0)->get();

        $data = [];
        foreach ($sale_detail as $item) {
            $bead_detail = $this->model_sale_detail_bead->getModel()::where('sale_detail_id', $item->id)
                ->where('is_deleted', 0)->get();
            $stone_detail = $this->model_sale_detail_stone->getModel()::where('sale_detail_id', $item->id)
                ->where('is_deleted', 0)->get();
            $diamond_detail = $this->model_sale_detail_diamond->getModel()::where('sale_detail_id', $item->id)
                ->where('is_deleted', 0)->get();
            $data[] = [
                "tag_no" => $item->finish_product->tag_no ?? '',
                "product" => $item->product->name ?? '',
                "gold_carat" => $item->gold_carat,
                "scale_weight" => $item->scale_weight,
                "bead_weight" => $item->bead_weight,
                "stones_weight" => $item->stones_weight,
                "diamond_weight" => $item->diamond_weight,
                "net_weight" => $item->net_weight,
                "gross_weight" => $item->gross_weight,
                "waste" => $item->waste,
                "making" => $item->making,
                "gold_rate" => $item->gold_rate,
                "total_gold_price" => $item->total_gold_price,
                "other_amount" => $item->other_amount,
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

    public function postSale($obj)
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
    public function unpostSale($sale_id)
    {
        try {
            DB::beginTransaction();

            $sale = $this->model_sale->getModel()::find($sale_id);

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

    public function deleteSaleById($sale_id)
    {
        try {
            DB::beginTransaction();

            $sale = $this->model_sale->getModel()::find($sale_id);

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
        $sale = $this->model_sale->getModel()::find($id);
        if ($sale->is_active == 0) {
            $sale->is_active = 1;
        } else {
            $sale->is_active = 0;
        }
        $sale->updatedby_id = Auth::user()->id;
        $sale->update();

        if ($sale)
            return true;

        return false;
    }

    public function deleteById($id)
    {
        $finish_product = $this->model_sale->getModel()::find($id);

        $ratti_kaat_detail = RattiKaatDetail::find($finish_product->ratti_kaat_detail_id);
        $ratti_kaat_detail->is_finish_product = 0;
        $ratti_kaat_detail->update();

        $finish_product->is_deleted = 1;
        $finish_product->deletedby_id = Auth::user()->id;
        $finish_product->update();

        if ($finish_product)
            return true;

        return false;
    }
}
