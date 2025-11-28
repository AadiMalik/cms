<?php

namespace App\Services\Concrete;

use App\Models\Account;
use App\Models\Journal;
use App\Models\JournalEntry;
use App\Models\MetalPurchase;
use App\Models\MetalPurchaseDetailBead;
use App\Models\MetalPurchaseDetail;
use App\Models\MetalPurchaseDetailDiamond;
use App\Models\MetalPurchaseDetailStone;
use App\Models\Supplier;
use App\Models\SupplierPayment;
use App\Repository\Repository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class MetalPurchaseService
{
    protected $model_metal_purchase;
    protected $model_metal_purchase_detail;
    protected $model_metal_purchase_detail_bead;
    protected $model_metal_purchase_detail_stone;
    protected $model_metal_purchase_detail_diamond;

    protected $common_service;
    protected $journal_entry_service;
    protected $supplier_payment_service;
    public function __construct()
    {
        // set the model
        $this->model_metal_purchase = new Repository(new MetalPurchase());
        $this->model_metal_purchase_detail = new Repository(new MetalPurchaseDetail());
        $this->model_metal_purchase_detail_bead = new Repository(new MetalPurchaseDetailBead());
        $this->model_metal_purchase_detail_stone = new Repository(new MetalPurchaseDetailStone());
        $this->model_metal_purchase_detail_diamond = new Repository(new MetalPurchaseDetailDiamond());

        $this->common_service = new CommonService();
        $this->journal_entry_service = new JournalEntryService();
        $this->supplier_payment_service = new SupplierPaymentService();
    }
    //Metal Purchase
    public function getMetalPurchaseSource($obj)
    {
        $wh = [];
        if ($obj['posted'] != '') {
            $wh[] = ['is_posted', $obj['posted']];
        }
        if ($obj['supplier_id'] != '') {
            $wh[] = ['supplier_id', $obj['supplier_id']];
        }
        $model = $this->model_metal_purchase->getModel()::has('MetalPurchaseDetail')->with([
            'supplier_name',
            'purchase_account_name',
            'paid_account_name'
        ])
            ->whereBetween('purchase_date', [date("Y-m-d", strtotime(str_replace('/', '-', $obj['start']))), date("Y-m-d", strtotime(str_replace('/', '-', $obj['end'])))])
            ->where('is_deleted', 0)
            ->where($wh);
        $data = DataTables::of($model)
            ->addColumn('check_box', function ($item) {
                if ($item->is_posted != 1)
                    return '<input type="checkbox" class="sub_chk" value="' . $item->id . '" data-id="' . $item->id . '" >';
            })
            ->addColumn('supplier', function ($item) {
                return $item->supplier_name->name ?? '';
            })
            ->addColumn('purchase_account', function ($item) {
                $code = $item->purchase_account_name->code ?? '';
                $name = $item->purchase_account_name->name ?? '';
                return  $code . '-' . $name;
            })
            // ->addColumn('paid_account', function ($item) {
            //     return $item->paid_account_name->code ?? '' . '-' . $item->paid_account_name->name ?? '';
            // })
            ->addColumn('posted', function ($item) {
                $badge_color = $item->is_posted == 0 ? 'badge-danger' : 'badge-success';
                $badge_text = $item->is_posted == 0 ? 'Unposted' : 'Posted';
                return '<span class="badge ' . $badge_color . '">' . $badge_text . '</span>';
            })
            ->addColumn('action', function ($item) {

                $jvs = '';
                if ($item->jv_id != null)
                    $jvs .= "filter[]=" . $item->jv_id . "";

                if ($item->paid_jv_id != null)
                    $jvs .= "&filter[]=" . $item->paid_jv_id . "";

                if ($item->paid_dollar_jv_id != null)
                    $jvs .= "&filter[]=" . $item->paid_dollar_jv_id . "";

                $action_column = '';
                $edit_column    = "<a class='text-success mr-2' href='metal-purchase/edit/" . $item->id . "' data-toggle='tooltip'  data-id='" . $item->id . "' data-original-title='Edit'><i title='Edit' class='nav-icon mr-2 fa fa-edit'></i>Edit</a>";
                $unpost_column    = "<a class='text-primary mr-2' id='unpost' href='javascript:void(0)' data-toggle='tooltip'  data-id='" . $item->id . "' data-original-title='Unpost'><i title='Unpost' class='nav-icon mr-2 fa fa-refresh'></i>Unpost</a>";
                $all_print_column    = "<a class='text-info mr-2' id='Ref' href='javascript:void(0)' data-toggle='tooltip'  data-filter='" . $jvs . "' data-original-title='Accounting'><i title='Accounting' class='nav-icon mr-2 fa fa-eye'></i>Accounting</a>";
                $delete_column    = "<a class='text-danger mr-2' id='deleteMetalPurchase' href='javascript:void(0)' data-toggle='tooltip'  data-id='" . $item->id . "' data-original-title='Delete'><i title='Delete' class='nav-icon mr-2 fa fa-trash'></i>Delete</a>";
                if (Auth::user()->can('metal_purchase_edit') && $item->is_posted == 0)
                    $action_column .= $edit_column;
                if (Auth::user()->can('metal_purchase_post') && $item->is_posted == 1)
                    $action_column .= $unpost_column;
                if (Auth::user()->can('metal_purchase_jvs') && $item->is_posted == 1)
                    $action_column .= $all_print_column;
                if (Auth::user()->can('metal_purchase_delete'))
                    $action_column .= $delete_column;


                return $action_column;
            })
            ->rawColumns(['check_box', 'supplier', 'purchase_account', 'posted', 'action'])
            ->addIndexColumn()
            ->make(true);
        return $data;
    }
    // save Metal Purchase
    public function saveMetalPurchase()
    {
        try {
            DB::beginTransaction();
            $obj = [
                'metal_purchase_no' => $this->common_service->generateMetalPurchaseNo(),
                'createdby_id' => Auth::User()->id
            ];
            $saved_obj = $this->model_metal_purchase->create($obj);

            DB::commit();
        } catch (Exception $e) {

            DB::rollback();
            throw $e;
        }
        return $saved_obj;
    }

    // update Metal Purchase
    public function updateMetalPurchase($obj)
    {
        try {
            DB::beginTransaction();
            $obj['updatedby_id'] = Auth::User()->id;
            $this->model_metal_purchase->update($obj, $obj['id']);
            $saved_obj = $this->model_metal_purchase->find($obj['id']);

            $this->model_metal_purchase_detail->getModel()::where('metal_purchase_id', $obj['id'])
                ->update(['is_deleted' => 1, 'deletedby_id' => Auth::User()->id]);

            $total = 0;
            $total_dollar = 0;
            $purchaseDetail = json_decode($obj['purchaseDetail'], true);
            foreach ($purchaseDetail as $key => $item) {
                $total += $item['total_amount'];
                $total_dollar += $item['total_dollar'];
                $detail = [
                    "metal_purchase_id" => $obj['id'],
                    "product_id" => $item['product_id'],
                    "metal" => $item['metal'],
                    "purity" => $item['purity'],
                    "description" => $item['description'],
                    "scale_weight" => $item['scale_weight'],
                    "bead_weight" => $item['bead_weight'],
                    "stone_weight" => $item['stone_weight'],
                    "diamond_weight" => $item['diamond_weight'],
                    "net_weight" => $item['net_weight'],
                    "metal_rate" => $item['metal_rate'],
                    "metal_amount" => $item['total_metal_amount'],
                    "other_charges" => ($item['other_charges'] != '') ? $item['other_charges'] : 0,
                    "bead_amount" => ($item['total_bead_amount'] != '') ? $item['total_bead_amount'] : 0,
                    "stone_amount" => ($item['total_stones_amount'] != '') ? $item['total_stones_amount'] : 0,
                    "diamond_amount" => ($item['total_diamond_amount'] != '') ? $item['total_diamond_amount'] : 0,
                    "total_dollar_amount" => ($item['total_dollar'] != '') ? $item['total_dollar'] : 0,
                    "total_amount" => ($item['total_amount'] != '') ? $item['total_amount'] : 0,
                    "createdby_id" => Auth::User()->id,
                    "created_at" => Carbon::now()
                ];
                $metal_purchase_detail = $this->model_metal_purchase_detail->getModel()::create($detail);

                // Beads
                $this->model_metal_purchase_detail_bead->getModel()::where('metal_purchase_detail_id', $metal_purchase_detail->id)
                    ->update(['is_deleted' => 1, 'deletedby_id' => Auth::User()->id]);
                foreach ($item['beadData'] as $key => $bead) {
                    $objBead = [
                        "type" => $bead['type'] ?? '',
                        "beads" => $bead['beads'] ?? 0,
                        "gram" => $bead['gram'] ?? 0,
                        "carat" => $bead['carat'] ?? 0,
                        "gram_rate" => $bead['gram_rate'] ?? 0,
                        "carat_rate" => $bead['carat_rate'] ?? 0,
                        "total_amount" => $bead['total_amount'] ?? 0,
                        "metal_purchase_detail_id" => $metal_purchase_detail->id,
                        "createdby_id" => Auth::User()->id
                    ];
                    $this->model_metal_purchase_detail_bead->getModel()::create($objBead);
                }

                // Stones
                $this->model_metal_purchase_detail_stone->getModel()::where('metal_purchase_detail_id', $metal_purchase_detail->id)
                    ->update(['is_deleted' => 1, 'deletedby_id' => Auth::User()->id]);
                foreach ($item['stoneData'] as $key => $stone) {
                    $objStone = [
                        "category" => $stone['category'] ?? '',
                        "type" => $stone['type'] ?? '',
                        "stones" => $stone['stones'] ?? 0,
                        "gram" => $stone['gram'] ?? 0,
                        "carat" => $stone['carat'] ?? 0,
                        "gram_rate" => $stone['gram_rate'] ?? 0,
                        "carat_rate" => $stone['carat_rate'] ?? 0,
                        "total_amount" => $stone['total_amount'] ?? 0,
                        "metal_purchase_detail_id" => $metal_purchase_detail->id,
                        "createdby_id" => Auth::User()->id
                    ];
                    $this->model_metal_purchase_detail_stone->getModel()::create($objStone);
                }

                // Diamonds
                $this->model_metal_purchase_detail_diamond->getModel()::where('metal_purchase_detail_id', $metal_purchase_detail->id)
                    ->update(['is_deleted' => 1, 'deletedby_id' => Auth::User()->id]);
                foreach ($item['diamondData'] as $key => $diamond) {
                    $objDiamond = [
                        "type" => $diamond['type'] ?? '',
                        "cut" => $diamond['cut'] ?? '',
                        "color" => $diamond['color'] ?? '',
                        "clarity" => $diamond['clarity'] ?? '',
                        "diamonds" => $diamond['diamonds'] ?? 0,
                        "carat" => $diamond['carat'] ?? 0,
                        "carat_rate" => $diamond['carat_rate'] ?? 0,
                        "total_amount" => $diamond['total_amount'] ?? 0,
                        "total_dollar" => $diamond['total_dollar'] ?? 0,
                        "metal_purchase_detail_id" => $metal_purchase_detail->id,
                        "createdby_id" => Auth::User()->id
                    ];
                    $this->model_metal_purchase_detail_diamond->getModel()::create($objDiamond);
                }
            }


            $this->model_metal_purchase->update(['total_dollar' => $total_dollar, 'total' => $total], $obj['id']);
            if (!$saved_obj)
                return false;
            DB::commit();
        } catch (Exception $e) {

            DB::rollback();
            throw $e;
        }
        return $saved_obj;
    }

    // post Metal Purchase
    public function postMetalPurchase($obj)
    {
        try {
            DB::beginTransaction();

            $journal_entry_id = null;
            $paid_jv = null;
            $paid_dollar_jv = Null;
            $supplier_payment = null;
            $supplier_dollar_payment = null;

            $purchase_account_id = $obj['purchase_account_id'];
            $paid_account_id = $obj['paid_account_id'];
            $paid_account_dollar_id = $obj['paid_account_dollar_id'];

            foreach ($obj['metal_purchase'] as $item) {
                $metal_purchase = MetalPurchase::with('supplier_name')->find($item);
                $supplier = Supplier::find($metal_purchase->supplier_id);

                $journal = Journal::find(config('enum.PV'));
                $purchase_date = date("Y-m-d", strtotime(str_replace('/', '-', $metal_purchase->purchase_date)));
                // Add journal entry
                $data = [
                    "date" => $purchase_date,
                    "prefix" => $journal->prefix,
                    "journal_id" => $journal->id
                ];
                $entryNum = $this->journal_entry_service->generateJournalEntryNum($data);

                $journal_entry = new JournalEntry;
                $journal_entry->journal_id = $journal->id;
                $journal_entry->supplier_id = $metal_purchase->supplier_id;
                $journal_entry->date_post = date("Y-m-d", strtotime(str_replace('/', '-', $metal_purchase->purchase_date)));
                $journal_entry->reference = 'Date :' . $metal_purchase->purchase_date . ' Against ' . $metal_purchase->metal_purchase_no . '. From ' . $metal_purchase->supplier_name->name;
                $journal_entry->entryNum = $entryNum;
                $journal_entry->createdby_id = Auth::User()->id;
                $journal_entry->save();

                $journal_entry_id = $journal_entry->id ?? null;

                if ($supplier->account_id == null) {
                    $message = "This Supplier/Karigar have  not COA account. please update then post again.!";
                    return $message;
                }

                $purchase_account = Account::find($purchase_account_id);
                $supplir_account = Account::find($supplier->account_id);

                // Journal Entry Detail

                //PKR Metal Purchase
                if ($metal_purchase->total > 0) {
                    $PKR_Amount = str_replace(',', '', $metal_purchase->total ?? 0);
                    // PKR (Debit)
                    $this->journal_entry_service->saveJVDetail(
                        0, // currency 0 for PKR, 1 for AU, 2 for Dollar
                        $journal_entry_id, // journal entry id
                        'Metal Purchase PKR Debit Entry', //explaination
                        $metal_purchase->id, //bill no
                        0, // check no or 0
                        $metal_purchase->purchase_date, //check date
                        1, // is credit flag 0 for credit, 1 for debit
                        $PKR_Amount, //amount
                        $purchase_account->id, // account id
                        $purchase_account->code, // account code
                        Auth::User()->id //created by id
                    );
                    // PKR (Credit)
                    $this->journal_entry_service->saveJVDetail(
                        0, // currency 0 for PKR, 1 for AU, 2 for Dollar
                        $journal_entry_id, // journal entry id
                        'Metal Purchase PKR Supplier/Karigar Credit Entry', //explaination
                        $metal_purchase->id, //bill no
                        0, // check no or 0
                        $metal_purchase->purchase_date, //check date
                        0, // is credit flag 0 for credit, 1 for debit
                        $PKR_Amount, //amount
                        $supplir_account->id, // account id
                        $supplir_account->code, // account code
                        Auth::User()->id //created by id
                    );
                }

                //Dollar Metal Purchase
                // if ($metal_purchase->total_dollar > 0) {
                //     $Dollar_Amount = str_replace(',', '', $metal_purchase->total_dollar ?? 0);

                //     // Dollar (Debit)
                //     $this->journal_entry_service->saveJVDetail(
                //         2, // currency 0 for PKR, 1 for AU, 2 for Dollar
                //         $journal_entry_id, // journal entry id
                //         'Metal Purchase Dollar($) Debit Entry', //explaination
                //         $metal_purchase->id, //bill no
                //         0, // check no or 0
                //         $metal_purchase->purchase_date, //check date
                //         1, // is credit flag 0 for credit, 1 for debit
                //         $Dollar_Amount, //amount
                //         $purchase_account->id, // account id
                //         $purchase_account->code, // account code
                //         Auth::User()->id //created by id
                //     );

                //     // Dollar (Credit)
                //     $this->journal_entry_service->saveJVDetail(
                //         2, // currency 0 for PKR, 1 for AU, 2 for Dollar
                //         $journal_entry_id, // journal entry id
                //         'Metal Purchase Dollar($) Supplier/Karigar Credit Entry', //explaination
                //         $metal_purchase->id, //bill no
                //         0, // check no or 0
                //         $metal_purchase->purchase_date, //check date
                //         0, // is credit flag 0 for credit, 1 for debit
                //         $Dollar_Amount, //amount
                //         $supplir_account->id, // account id
                //         $supplir_account->code, // account code
                //         Auth::User()->id //created by id
                //     );
                // }


                if ($metal_purchase->paid > 0 && $paid_account_id != null) {
                    $Paid_Amount = str_replace(',', '', $metal_purchase->paid ?? 0);

                    $paid_account = Account::find($paid_account_id);
                    $paid_jv = $this->PaidtoSupplier($metal_purchase->metal_purchase_no, $metal_purchase->purchase_date, $metal_purchase->id, $supplier, $paid_account, $supplir_account, $Paid_Amount);
                    // Supplier PKR payment
                    $supplier_payment = $this->supplier_payment_service->saveSupplierPaymentWithoutTax(
                        $supplier->id,
                        0,
                        $paid_account_id,
                        $metal_purchase->purchase_date,
                        null,
                        $Paid_Amount,
                        $paid_jv
                    );
                }

                // Dollar Payment JV
                // if ($metal_purchase->paid_dollar > 0  && $paid_account_dollar_id != null) {
                //     $Paid_dollar_Amount = str_replace(',', '', $metal_purchase->paid_dollar ?? 0);

                //     $paid_dollar_account = Account::find($paid_account_dollar_id);
                //     $paid_dollar_jv = $this->PaidDollartoSupplier($metal_purchase->metal_purchase_no, $metal_purchase->purchase_date, $metal_purchase->id, $supplier, $paid_dollar_account, $supplir_account, $Paid_dollar_Amount);
                //     // Supplier Dollar payment
                //     $supplier_dollar_payment = $this->supplier_payment_service->saveSupplierPaymentWithoutTax(
                //         $supplier->id,
                //         2,
                //         $paid_account_dollar_id,
                //         $metal_purchase->purchase_date,
                //         null,
                //         $Paid_dollar_Amount,
                //         $paid_dollar_jv
                //     );
                // }

                // Purchase Update
                $metal_purchase->purchase_account_id = $purchase_account_id;
                $metal_purchase->paid_account_id = $paid_account_id;
                $metal_purchase->paid_account_dollar_id = $paid_account_dollar_id;
                $metal_purchase->is_posted = 1;
                $metal_purchase->jv_id = $journal_entry_id;
                $metal_purchase->paid_jv_id = ($paid_jv != null) ? $paid_jv->id : null;
                $metal_purchase->paid_dollar_jv_id = ($paid_dollar_jv != null) ? $paid_dollar_jv->id : null;
                $metal_purchase->supplier_payment_id = ($supplier_payment != null) ? $supplier_payment->id : null;
                $metal_purchase->supplier_dollar_payment_id = ($supplier_dollar_payment != null) ? $supplier_dollar_payment->id : null;
                $metal_purchase->update();
            }
            DB::commit();
        } catch (Exception $e) {

            DB::rollback();
            throw $e;
        }
        return true;
    }

    // PKR paid to supplier
    public function PaidtoSupplier($metal_purchase_no, $purchase_date, $bill_no, $supplier, $paid_account, $supplir_account, $Paid_Amount)
    {
        $journal_type = ($paid_account->is_cash_account == 1) ? config('enum.CPV') : config('enum.BPV');
        $journal = Journal::find($journal_type);
        $data = ["date" => $purchase_date, "prefix" => $journal->prefix, "journal_id" => $journal->id];
        $entryNum = $this->journal_entry_service->generateJournalEntryNum($data);

        $journal_entry = new JournalEntry;
        $journal_entry->journal_id = $journal->id;
        $journal_entry->supplier_id = $supplier->id;
        $journal_entry->date_post = date("Y-m-d", strtotime(str_replace('/', '-', $purchase_date)));
        $journal_entry->reference = 'Date :' . $purchase_date . ' PKR Payment Against RK. ' . $metal_purchase_no;
        $journal_entry->entryNum = $entryNum;
        $journal_entry->createdby_id = Auth::User()->id;
        $journal_entry->save();

        $paid_jv_id = $journal_entry->id;

        // Journal Entry Detail
        $Paid_Amount = str_replace(',', '', $Paid_Amount);

        // Journal entry detail (Debit)
        $this->journal_entry_service->saveJVDetail(
            0,
            $paid_jv_id, // journal entry id
            'Paid PKR Payment Debit Against Metal Purchase. ' . $metal_purchase_no, //explaination
            $bill_no, //bill no
            0, // check no or 0
            $purchase_date, //check date
            1, // is credit flag 0 for credit, 1 for debit
            $Paid_Amount, //amount
            $supplir_account->id, // account id
            $supplir_account->code, // account code
            Auth::User()->id //created by id
        );

        // Journal entry detail (Credit)
        $this->journal_entry_service->saveJVDetail(
            0, // 0 for PKR, 1 for AU, 2 for Dollar
            $paid_jv_id, // journal entry id
            'Paid PKR Payment Credit Against Metal Purchase. ' . $metal_purchase_no, //explaination
            $bill_no, //bill no
            0, // check no or 0
            $purchase_date, //check date
            0, // is credit flag 0 for credit, 1 for debit
            $Paid_Amount, //amount
            $paid_account->id, // account id
            $paid_account->code, // account code
            Auth::User()->id //created by id
        );

        return $journal_entry;
    }

    // Dollar paid to supplier
    public function PaidDollartoSupplier($metal_purchase_no, $purchase_date, $bill_no, $supplier, $paid_dollar_account, $supplir_account, $Paid_dollar_Amount)
    {
        $journal_type = ($paid_dollar_account->is_cash_account == 1) ? config('enum.CPV') : config('enum.BPV');
        $journal = Journal::find($journal_type);
        $data = ["date" => $purchase_date, "prefix" => $journal->prefix, "journal_id" => $journal->id];
        $entryNum = $this->journal_entry_service->generateJournalEntryNum($data);

        $journal_entry = new JournalEntry;
        $journal_entry->journal_id = $journal->id;
        $journal_entry->supplier_id = $supplier->id;
        $journal_entry->date_post = date("Y-m-d", strtotime(str_replace('/', '-', $purchase_date)));
        $journal_entry->reference = 'Date :' . $purchase_date . ' Dollar payment Against RK. ' . $metal_purchase_no;
        $journal_entry->entryNum = $entryNum;
        $journal_entry->createdby_id = Auth::User()->id;
        $journal_entry->save();

        $dollar_jv_id = $journal_entry->id;

        // Journal Entry Detail
        $Paid_dollar_Amount = str_replace(',', '', $Paid_dollar_Amount);

        // Journal entry detail (Debit)
        $this->journal_entry_service->saveJVDetail(
            2,
            $dollar_jv_id, // journal entry id
            'Paid Dollar Payment Debit Against Metal Purchase. ' . $metal_purchase_no, //explaination
            $bill_no, //bill no
            0, // check no or 0
            $purchase_date, //check date
            1, // is credit flag 0 for credit, 1 for debit
            $Paid_dollar_Amount, //amount
            $supplir_account->id, // account id
            $supplir_account->code, // account code
            Auth::User()->id //created by id
        );

        // Journal entry detail (Credit)
        $this->journal_entry_service->saveJVDetail(
            2, // 0 for PKR, 1 for dollar, 2 for Dollar
            $dollar_jv_id, // journal entry id
            'Paid Dollar Payment Credit Against Metal Purchase. ' . $metal_purchase_no, //explaination
            $bill_no, //bill no
            0, // check no or 0
            $purchase_date, //check date
            0, // is credit flag 0 for credit, 1 for debit
            $Paid_dollar_Amount, //amount
            $paid_dollar_account->id, // account id
            $paid_dollar_account->code, // account code
            Auth::User()->id //created by id
        );

        return $journal_entry;
    }

    // get by id
    public function getMetalPurchaseById($id)
    {
        $metal_purchase = $this->model_metal_purchase->getModel()::find($id);

        if (!$metal_purchase)
            return false;

        return $metal_purchase;
    }

    //ratti kaat detail 
    public function getMetalPurchaseDetail($metal_purchase_id)
    {
        $metal_purchase_detail = $this->model_metal_purchase_detail->getModel()::with('product_name')->where('metal_purchase_id', $metal_purchase_id)->orderBy('id', 'DESC')->where('is_deleted', 0)->get();
        $data = [];
        foreach ($metal_purchase_detail as $item) {
            $item['beadData'] = $this->model_metal_purchase_detail_bead->getModel()::where('metal_purchase_detail_id', $item->id)->where('is_deleted', 0)->get();
            $item['stoneData'] = $this->model_metal_purchase_detail_stone->getModel()::where('metal_purchase_detail_id', $item->id)->where('is_deleted', 0)->get();
            $item['diamondData'] = $this->model_metal_purchase_detail_diamond->getModel()::where('metal_purchase_detail_id', $item->id)->where('is_deleted', 0)->get();
            $data[] = $item;
        }
        return $data;
    }

    // status by id
    public function statusById($id)
    {
        $metal_purchase = $this->model_metal_purchase->getModel()::find($id);
        if ($metal_purchase->is_active == 0) {
            $metal_purchase->is_active = 1;
        } else {
            $metal_purchase->is_active = 0;
        }
        $metal_purchase->updatedby_id = Auth::user()->id;
        $metal_purchase->update();

        if ($metal_purchase)
            return true;

        return false;
    }
    // unpost by id
    public function unpostMetalPurchaseById($id)
    {
        try {
            DB::beginTransaction();
            $metal_purchase = $this->model_metal_purchase->find($id);
            $metal_purchase->is_posted = 0;
            $metal_purchase->updatedby_id = Auth::User()->id;
            $metal_purchase->update();

            if ($metal_purchase->jv_id != null) {
                $journal_entry = JournalEntry::find($metal_purchase->jv_id);
                $journal_entry->is_deleted = 1;
                $journal_entry->deletedby_id = Auth::User()->id;
                $journal_entry->update();
            }

            if ($metal_purchase->paid_jv_id != null) {
                $paid_jv = JournalEntry::find($metal_purchase->paid_jv_id);
                $paid_jv->is_deleted = 1;
                $paid_jv->deletedby_id = Auth::User()->id;
                $paid_jv->update();
            }
            if ($metal_purchase->paid_dollar_jv_id != null) {
                $paid_dollar_jv = JournalEntry::find($metal_purchase->paid_dollar_jv_id);
                $paid_dollar_jv->is_deleted = 1;
                $paid_dollar_jv->deletedby_id = Auth::User()->id;
                $paid_dollar_jv->update();
            }

            //payment delete
            if ($metal_purchase->supplier_payment_id != null) {
                $supplier_payment = SupplierPayment::find($metal_purchase->supplier_payment_id);
                $supplier_payment->is_deleted = 1;
                $supplier_payment->deletedby_id = Auth::User()->id;
                $supplier_payment->update();
            }
            if ($metal_purchase->supplier_dollar_payment_id != null) {
                $supplier_dollar_payment = SupplierPayment::find($metal_purchase->supplier_dollar_payment_id);
                $supplier_dollar_payment->is_deleted = 1;
                $supplier_dollar_payment->deletedby_id = Auth::User()->id;
                $supplier_dollar_payment->update();
            }

            DB::commit();
        } catch (Exception $e) {

            DB::rollback();
            throw $e;
        }
        return true;
    }
    // delete by id
    public function deleteMetalPurchaseById($id)
    {
        try {
            DB::beginTransaction();
            $metal_purchase = $this->model_metal_purchase->find($id);
            $metal_purchase->is_deleted = 1;
            $metal_purchase->deletedby_id = Auth::User()->id;
            $metal_purchase->update();

            if ($metal_purchase->jv_id != null) {
                $journal_entry = JournalEntry::find($metal_purchase->jv_id);
                $journal_entry->is_deleted = 1;
                $journal_entry->deletedby_id = Auth::User()->id;
                $journal_entry->update();
            }

            if ($metal_purchase->paid_jv_id != null) {
                $paid_jv = JournalEntry::find($metal_purchase->paid_jv_id);
                $paid_jv->is_deleted = 1;
                $paid_jv->deletedby_id = Auth::User()->id;
                $paid_jv->update();
            }
            if ($metal_purchase->paid_dollar_jv_id != null) {
                $paid_dollar_jv = JournalEntry::find($metal_purchase->paid_dollar_jv_id);
                $paid_dollar_jv->is_deleted = 1;
                $paid_dollar_jv->deletedby_id = Auth::User()->id;
                $paid_dollar_jv->update();
            }

            //payment delete
            if ($metal_purchase->supplier_payment_id != null) {
                $supplier_payment = SupplierPayment::find($metal_purchase->supplier_payment_id);
                $supplier_payment->is_deleted = 1;
                $supplier_payment->deletedby_id = Auth::User()->id;
                $supplier_payment->update();
            }
            if ($metal_purchase->supplier_dollar_payment_id != null) {
                $supplier_dollar_payment = SupplierPayment::find($metal_purchase->supplier_dollar_payment_id);
                $supplier_dollar_payment->is_deleted = 1;
                $supplier_dollar_payment->deletedby_id = Auth::User()->id;
                $supplier_dollar_payment->update();
            }

            DB::commit();
        } catch (Exception $e) {

            DB::rollback();
            throw $e;
        }
        return true;
    }

    // get by product id
    public function getMetalPurchaseByProductId($product_id)
    {
        try {
            DB::beginTransaction();

            $metal_purchase = $this->model_metal_purchase->getModel()::join('metal_purchase_details', 'metal_purchase_details.metal_purchase_id', 'metal_purchases.id')
                ->join('products', 'metal_purchase_details.product_id', 'products.id')
                ->select(
                    'metal_purchases.id as metal_purchase_id',
                    'metal_purchases.metal_purchase_no',
                    'metal_purchase_details.id as metal_purchase_detail_id',
                    'products.prefix'
                )
                ->where('metal_purchase_details.product_id', $product_id)
                ->where('metal_purchases.is_posted', 1)
                ->where('metal_purchase_details.is_deleted', 0)
                ->get();

            return $metal_purchase;
            DB::commit();
        } catch (Exception $e) {

            DB::rollback();
            throw $e;
        }
        return true;
    }

    // get ratti kaat detail by id
    public function getMetalPurchaseDetailById($detail_id)
    {
        try {
            DB::beginTransaction();

            $metal_purchase_detail = $this->model_metal_purchase_detail->find($detail_id);
            return $metal_purchase_detail;

            DB::commit();
        } catch (Exception $e) {

            DB::rollback();
            throw $e;
        }
        return true;
    }

    // get beads weight
    public function getBeadWeight($metal_purchase_id)
    {
        return $this->model_metal_purchase_detail_bead->getModel()::with(['metal_purchase_detail', 'product_name'])
            ->where('metal_purchase_detail_id', $metal_purchase_id)
            ->where('is_deleted', 0)
            ->get();
    }
    public function saveBeadWeight($obj)
    {
        try {
            DB::beginTransaction();
            $obj['createdby_id'] = Auth::User()->id;

            $saved_obj = $this->model_metal_purchase_detail_bead->create($obj);

            DB::commit();
        } catch (Exception $e) {

            DB::rollback();
            throw $e;
        }

        return $saved_obj;
    }

    // delete bead by id
    public function deleteBeadWeightById($id)
    {
        $metal_purchase_bead = $this->model_metal_purchase_detail_bead->getModel()::find($id);
        $metal_purchase_bead->is_deleted = 1;
        $metal_purchase_bead->deletedby_id = Auth::user()->id;
        $metal_purchase_bead->update();

        if (!$metal_purchase_bead)
            return false;

        return $metal_purchase_bead;
    }

    // get stones weight
    public function getStoneWeight($metal_purchase_detail_id)
    {
        return $this->model_metal_purchase_detail_stone->getModel()::with(['metal_purchase_detail', 'product_name'])
            ->where('metal_purchase_detail_id', $metal_purchase_detail_id)
            ->where('is_deleted', 0)
            ->get();
    }
    public function saveStoneWeight($obj)
    {
        try {
            DB::beginTransaction();
            $obj['createdby_id'] = Auth::User()->id;

            $saved_obj = $this->model_metal_purchase_detail_stone->create($obj);

            DB::commit();
        } catch (Exception $e) {

            DB::rollback();
            throw $e;
        }

        return $saved_obj;
    }

    // delete stone by id
    public function deleteStoneWeightById($id)
    {
        $metal_purchase_stone = $this->model_metal_purchase_detail_stone->getModel()::find($id);
        $metal_purchase_stone->is_deleted = 1;
        $metal_purchase_stone->deletedby_id = Auth::user()->id;
        $metal_purchase_stone->update();

        if (!$metal_purchase_stone)
            return false;

        return $metal_purchase_stone;
    }


    // get diamonds Carat
    public function getDiamondCarat($metal_purchase_detail_id)
    {
        return $this->model_metal_purchase_detail_diamond->getModel()::with(['metal_purchase_detail', 'product_name'])
            ->where('metal_purchase_detail_id', $metal_purchase_detail_id)
            ->where('is_deleted', 0)
            ->get();
    }
    // public function saveDiamondCarat($obj)
    // {
    //     try {
    //         DB::beginTransaction();
    //         $obj['createdby_id'] = Auth::User()->id;

    //         $saved_obj = $this->model_metal_purchase_diamond->create($obj);

    //         DB::commit();
    //     } catch (Exception $e) {

    //         DB::rollback();
    //         throw $e;
    //     }

    //     return $saved_obj;
    // }

    // delete diamond by id
    public function deleteDiamondCaratById($id)
    {
        $metal_purchase_diamond = $this->model_metal_purchase_detail_diamond->getModel()::find($id);
        $metal_purchase_diamond->is_deleted = 1;
        $metal_purchase_diamond->deletedby_id = Auth::user()->id;
        $metal_purchase_diamond->update();

        if (!$metal_purchase_diamond)
            return false;

        return $metal_purchase_diamond;
    }
}
