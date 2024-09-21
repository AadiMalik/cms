<?php

namespace App\Services\Concrete;

use App\Models\JournalEntry;
use App\Models\RattiKaat;
use App\Models\RattiKaatBead;
use App\Models\RattiKaatDetail;
use App\Models\RattiKaatDiamond;
use App\Models\RattiKaatStone;
use App\Repository\Repository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class RattiKaatService
{
    protected $model_ratti_kaat;
    protected $model_ratti_kaat_detail;
    protected $model_ratti_kaat_bead;
    protected $model_ratti_kaat_stone;
    protected $model_ratti_kaat_diamond;

    protected $common_service;
    protected $journal_entry_service;
    public function __construct()
    {
        // set the model
        $this->model_ratti_kaat = new Repository(new RattiKaat());
        $this->model_ratti_kaat_detail = new Repository(new RattiKaatDetail());
        $this->model_ratti_kaat_bead = new Repository(new RattiKaatBead());
        $this->model_ratti_kaat_stone = new Repository(new RattiKaatStone());
        $this->model_ratti_kaat_diamond = new Repository(new RattiKaatDiamond());

        $this->common_service = new CommonService();
        $this->journal_entry_service = new JournalEntryService();
    }
    //Ratti Kaat
    public function getRattiKaatSource($obj)
    {
        $wh = [];
        if ($obj['posted'] != '') {
            $wh[] = ['is_posted', $obj['posted']];
        }
        if ($obj['supplier_id'] != '') {
            $wh[] = ['supplier_id', $obj['supplier_id']];
        }
        $model = RattiKaat::has('RattiKaatDetail')->with(['supplier_name', 'purchase_account_name', 'paid_account_name'])
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
                $action_column = '';
                $edit_column    = "<a class='text-success mr-2' href='ratti-kaats/edit/" . $item->id . "' data-toggle='tooltip'  data-id='" . $item->id . "' data-original-title='Edit'><i title='Edit' class='nav-icon mr-2 fa fa-edit'></i>Edit</a>";
                $delete_column    = "<a class='text-danger mr-2' id='deletePurchase' href='javascript:void(0)' data-toggle='tooltip'  data-id='" . $item->id . "' data-original-title='Delete'><i title='Delete' class='nav-icon mr-2 fa fa-trash'></i>Delete</a>";
                if (Auth::user()->can('ratti_kaat_edit'))
                    $action_column .= $edit_column;
                if (Auth::user()->can('ratti_kaat_delete'))
                    $action_column .= $delete_column;

                return $action_column;
            })
            ->rawColumns(['check_box', 'supplier', 'purchase_account', 'posted', 'action'])
            ->addIndexColumn()
            ->make(true);
        return $data;
    }
    // save Ratti Kaat
    public function saveRattiKaat()
    {
        try {
            DB::beginTransaction();
            $obj = [
                'ratti_kaat_no' => $this->common_service->generateRattiKaatNo(),
                'createdby_id' => Auth::User()->id
            ];
            $saved_obj = $this->model_ratti_kaat->create($obj);

            DB::commit();
        } catch (Exception $e) {

            DB::rollback();
            throw $e;
        }
        return $saved_obj;
    }

    // update Ratti Kaat
    public function updateRattiKaat($obj)
    {
        try {
            DB::beginTransaction();
            $obj['updatedby_id'] = Auth::User()->id;
            $this->model_ratti_kaat->update($obj, $obj['id']);
            $saved_obj = $this->model_ratti_kaat->find($obj['id']);

            $this->model_ratti_kaat_detail->getModel()::where('ratti_kaat_id', $obj['id'])
                ->update(['is_deleted' => 1, 'deletedby_id' => Auth::User()->id]);

            $total = 0;
            $purchaseDetail = json_decode($obj['purchaseDetail'],true);
            $detail=[];
            foreach ($purchaseDetail as $key => $item) {
                $total += $item['total_amount'];
                $detail[]=[
                    "ratti_kaat_id"=>$obj['id'],
                    "product_id"=>$item['product_id'],
                    "description"=>$item['description'],
                    "scale_weight"=>$item['scale_weight'],
                    "bead_weight"=>$item['bead_weight'],
                    "stones_weight"=>$item['stones_weight'],
                    "diamond_carat"=>$item['diamond_carat'],
                    "net_weight"=>$item['net_weight'],
                    "supplier_kaat"=>$item['supplier_kaat'],
                    "kaat"=>$item['kaat'],
                    "approved_by"=>$item['approved_by'],
                    "pure_payable"=>$item['pure_payable'],
                    "other_charge"=>$item['other_charge'],
                    "total_bead_amount"=>$item['total_bead_amount'],
                    "total_stones_amount"=>$item['total_stones_amount'],
                    "total_diamond_amount"=>$item['total_diamond_amount'],
                    "total_amount"=>$item['total_amount'],
                    "createdby_id"=>Auth::User()->id,
                    "created_at"=>Carbon::now()
                ];

            }
            $this->model_ratti_kaat_detail->getModel()::insert($detail);

            $this->model_ratti_kaat->update(['total' => $total], $obj['id']);
            if (!$saved_obj)
                return false;
            DB::commit();
        } catch (Exception $e) {

            DB::rollback();
            throw $e;
        }
        return $saved_obj;
    }

    // post Ratti Kaat
    // public function postedRattiKaat($obj)
    //   {
    //         try {
    //               DB::beginTransaction();

    //               $journal_entry_id = null;
    //               $fare_jv_id = null;
    //               $paid_jv_id = Null;
    //               $vendor_payment_id = null;
    //               foreach ($obj['purchase'] as $item) {
    //                     $data2 = [];
    //                     $purchase = Purchase::with('vendor')->find($item);
    //                     $vendor = Users::find($purchase->vendorId);

    //                     if ($restaurant->account == 1 && $purchase->purchase_account > 0) {
    //                           $journal = Journal::find(config('global.PV'));
    //                           // Add journal entry
    //                           $data = [
    //                                 "date" => $purchase->poDate,
    //                                 "prefix" => $journal->prefix,
    //                                 "journalId" => $journal->id
    //                           ];
    //                           $entryNum = $this->journal_entry_service->generateJournalEntryNum($data);

    //                           $journal_entry = new JournalEntry;
    //                           $journal_entry->journal_id = $journal->id;
    //                           $journal_entry->vendor_id = $purchase->vendorId;
    //                           $journal_entry->date_post = date("Y-m-d", strtotime(str_replace('/', '-', $purchase->poDate)));
    //                           $journal_entry->reference = 'Date :' . $purchase->poDate . ' Against P.O. ' . $purchase->poNum . '. From ' . $purchase->vendor->first_name;
    //                           $journal_entry->entryNum = $entryNum;
    //                           $journal_entry->restaurant_id =  Auth::guard('admin_user')->User()->userRestaurant->restaurant_id;
    //                           $journal_entry->createdby_id = Auth::guard('admin_user')->User()->id;
    //                           $journal_entry->save();

    //                           $journal_entry_id = $journal_entry->id ?? null;
    //                     }
    //                     $total = 0;
    //                     $purchase_detail = PurchaseDetail::with('package_name')->where('poId', $purchase->id)->get();
    //                     $data1 = [];
    //                     foreach ($purchase_detail as $index => $item2) {
    //                           $total += $item2->subTotal;
    //                           // if ($purchase->status != 0) {
    //                           $transaction = [
    //                                 "purchase_id" => $item2->poId,
    //                                 "transaction_date" => $purchase->poDate ?? Carbon::now(),
    //                                 "bill_no" => $purchase->bill_no,
    //                                 "restaurant_id" => Auth::guard('admin_user')->User()->userRestaurant->restaurant_id,
    //                                 "warehouse_id" => $purchase->warehouse_id,
    //                                 "product_id" => $item2->productId,
    //                                 "package_id" => $item2->package,
    //                                 "bundle_qty" => $item2->package_name->qty,
    //                                 "recieved_qty" => $item2->productQty,
    //                                 "unit_price" => ($item2->subTotal - $item2->tax_amount)/$item2->productQty??1,
    //                                 "created_by" => Auth::guard('admin_user')->User()->id,
    //                                 "type" => 0,
    //                                 "created_at" => Carbon::now(),
    //                                 "updated_at" => Carbon::now()
    //                           ];
    //                           $transation_id = Transaction::create($transaction);
    //                           $transation_id->Purchases()->attach($item2->poId);

    //                           // End
    //                     }
    //                     if ($restaurant->account == 1 && $purchase->purchase_account > 0) {
    //                           $account = AccountHead::find($purchase->purchase_account);

    //                           // Journal Entry Detail
    //                           $Debit = str_replace(',', '', $purchase->sub_total);
    //                           // $data1[] = [
    //                           //       'credit' => 0.00,
    //                           //       'journal_entry_id' => $journal_entry_id,
    //                           //       'explanation' => 'Purchase Entry Debit',
    //                           //       'bill_no' => $purchase->bill_no,
    //                           //       'check_no' => 0,
    //                           //       'check_date' => $purchase->poDate,
    //                           //       'debit' => $Debit,
    //                           //       'acc_head_id' => $account->id ?? '',
    //                           //       'createdBy' =>  Auth::guard('admin_user')->User()->userRestaurant->restaurant_id,
    //                           //       'amount' => $Debit,
    //                           //       'account_code' => $account->code,
    //                           //       'amount_in_words' => $this->numberToWord($Debit)
    //                           // ];

    //                           // Journal entry detail (Debit)
    //                           $journal_entry_detail->saveJVDetail(
    //                                 $journal_entry_id, // journal entry id
    //                                 'Purchase Entry Debit', //explaination
    //                                 $purchase->bill_no, //bill no
    //                                 0, // check no or 0
    //                                 $purchase->poDate, //check date
    //                                 1, // is credit flag 0 for credit, 1 for debit
    //                                 $Debit, //amount
    //                                 $account->id, // account id
    //                                 $account->code, // account code
    //                                 Auth::guard('admin_user')->User()->id //created by id
    //                           );
    //                     }
    //                     if ($restaurant->account == 1 && $purchase->tax_account > 0) {
    //                           $tax_account = AccountHead::find($purchase->tax_account);

    //                           // Journal Entry Detail
    //                           $Tax_Amount = str_replace(',', '', $purchase->total_tax);
    //                           // $data1[] = [
    //                           //       'credit' => 0.00,
    //                           //       'journal_entry_id' => $journal_entry_id,
    //                           //       'explanation' => 'Purchase Entry Tax Amount Debit',
    //                           //       'bill_no' => $purchase->bill_no,
    //                           //       'check_no' => 0,
    //                           //       'check_date' => $purchase->poDate,
    //                           //       'debit' => $Tax_Amount,
    //                           //       'acc_head_id' => $tax_account->id ?? '',
    //                           //       'createdBy' =>  Auth::guard('admin_user')->User()->userRestaurant->restaurant_id,
    //                           //       'amount' => $Tax_Amount,
    //                           //       'account_code' => $tax_account->code,
    //                           //       'amount_in_words' => $this->numberToWord($Tax_Amount)
    //                           // ];

    //                           // Journal entry detail (Debit)
    //                           $journal_entry_detail->saveJVDetail(
    //                                 $journal_entry_id, // journal entry id
    //                                 'Purchase Entry Tax Amount Debit', //explaination
    //                                 $purchase->bill_no, //bill no
    //                                 0, // check no or 0
    //                                 $purchase->poDate, //check date
    //                                 1, // is credit flag 0 for credit, 1 for debit
    //                                 $Tax_Amount, //amount
    //                                 $tax_account->id, // account id
    //                                 $tax_account->code, // account code
    //                                 Auth::guard('admin_user')->User()->id //created by id
    //                           );
    //                     }
    //                     if ($restaurant->account == 1 && $vendor->account_id > 0) {
    //                           $vendor_account = AccountHead::find($vendor->account_id);
    //                           // DB::table('journal_entry_details')->insert($data1);
    //                           // Journal Entry Detail
    //                           $Credit = str_replace(',', '', $purchase->total);
    //                           // $data2[] = [
    //                           //       'credit' => $Credit,
    //                           //       'journal_entry_id' => $journal_entry_id,
    //                           //       'explanation' => 'Purchase Entry Vendor Credit PO NO ' . $purchase->poNum,
    //                           //       'bill_no' => $purchase->bill_no,
    //                           //       'check_no' => 0,
    //                           //       'check_date' => $purchase->poDate,
    //                           //       'debit' => 0.00,
    //                           //       'acc_head_id' => $vendor_account->id ?? '',
    //                           //       'createdBy' =>  Auth::guard('admin_user')->User()->userRestaurant->restaurant_id,
    //                           //       'amount' => $Credit,
    //                           //       'account_code' => $vendor_account->code ?? '',
    //                           //       'amount_in_words' => $this->numberToWord($Credit)
    //                           // ];
    //                           // // End
    //                           // DB::table('journal_entry_details')->insert($data2);

    //                           // Journal entry detail (Credit)
    //                           $journal_entry_detail->saveJVDetail(
    //                                 $journal_entry_id, // journal entry id
    //                                 'Purchase Entry Vendor Credit PO NO ' . $purchase->poNum, //explaination
    //                                 $purchase->bill_no, //bill no
    //                                 0, // check no or 0
    //                                 $purchase->poDate, //check date
    //                                 0, // is credit flag 0 for credit, 1 for debit
    //                                 $Credit, //amount
    //                                 $vendor_account->id, // account id
    //                                 $vendor_account->code, // account code
    //                                 Auth::guard('admin_user')->User()->id //created by id
    //                           );
    //                     }

    //                     // Vendor amount update
    //                     $vendor->opening_balance = $vendor->opening_balance + $purchase->total;
    //                     $vendor->update();
    //                     if ($restaurant->account == 1 && $vendor->account_id > 0) {

    //                           // Vendor Fare Payment Add
    //                           if ($purchase->fare > 0 && $purchase->fare_account != null) {

    //                                 $fare_account = AccountHead::find($purchase->fare_account);
    //                                 $journal_type = ($fare_account->is_cash_account == 1) ? config('global.CPV') : config('global.BPV');
    //                                 $journal_fare = Journal::find($journal_type);
    //                                 // Add journal entry
    //                                 $data = [
    //                                       "date" => $purchase->poDate,
    //                                       "prefix" => $journal_fare->prefix,
    //                                       "journalId" => $journal_fare->id
    //                                 ];
    //                                 $entryNum_fare = $this->generateJournalEntryNum($data);
    //                                 $journal_entry_fare = new JournalEntry;
    //                                 $journal_entry_fare->journal_id = $journal_fare->id;
    //                                 $journal_entry_fare->vendor_id = $purchase->vendorId;
    //                                 $journal_entry_fare->date_post = date(
    //                                       "Y-m-d",
    //                                       strtotime(str_replace('/', '-', $purchase->poDate))
    //                                 );
    //                                 $journal_entry_fare->reference = 'Date :' . $purchase->poDate . ' Purchase Fare Against PO. ' . $purchase->poNum;
    //                                 $journal_entry_fare->entryNum = $entryNum_fare;
    //                                 $journal_entry_fare->restaurant_id =  Auth::guard('admin_user')->User()->userRestaurant->restaurant_id;
    //                                 $journal_entry_fare->createdby_id = Auth::guard('admin_user')->User()->id;
    //                                 $journal_entry_fare->save();
    //                                 $restaurant = Restaurant::find(Auth::guard('admin_user')->User()->userRestaurant->restaurant_id);
    //                                 $cash_account = AccountHead::find($purchase->purchase_account);
    //                                 $fare_jv_id = $journal_entry_fare->id;
    //                                 // Journal Entry Detail
    //                                 $Amount = str_replace(',', '', $purchase->fare);
    //                                 // $fare1 = [
    //                                 //       'credit' => 0.00,
    //                                 //       'journal_entry_id' => $journal_entry_fare->id,
    //                                 //       'explanation' => 'Fare Payment Against Purchase Credit',
    //                                 //       'bill_no' => $purchase->bill_no,
    //                                 //       'check_no' => 0,
    //                                 //       'check_date' => $purchase->poDate,
    //                                 //       'debit' => $Amount,
    //                                 //       'acc_head_id' => $fare_account->id ?? '',
    //                                 //       'createdBy' =>  Auth::guard('admin_user')->User()->userRestaurant->restaurant_id,
    //                                 //       'amount' => $Amount,
    //                                 //       'account_code' => $fare_account->code ?? '',
    //                                 //       'amount_in_words' => $this->numberToWord($Amount)
    //                                 // ];
                                    
    //                                 // Journal entry detail (Debit)
    //                                 $journal_entry_detail->saveJVDetail(
    //                                       $fare_jv_id, // journal entry id
    //                                       'Fare Payment Against Purchase Credit', //explaination
    //                                       $purchase->bill_no, //bill no
    //                                       0, // check no or 0
    //                                       $purchase->poDate, //check date
    //                                       1, // is credit flag 0 for credit, 1 for debit
    //                                       $Amount, //amount
    //                                       $fare_account->id, // account id
    //                                       $fare_account->code, // account code
    //                                       Auth::guard('admin_user')->User()->id //created by id
    //                                 );
    //                                 // $fare2 = [
    //                                 //       'credit' => $Amount,
    //                                 //       'journal_entry_id' => $journal_entry_fare->id,
    //                                 //       'explanation' => 'Fare Payment Against Purchase Credit',
    //                                 //       'bill_no' => $purchase->bill_no,
    //                                 //       'check_no' => 0,
    //                                 //       'check_date' => $purchase->poDate,
    //                                 //       'debit' => 0.00,
    //                                 //       'acc_head_id' => $cash_account->id,
    //                                 //       'createdBy' =>  Auth::guard('admin_user')->User()->userRestaurant->restaurant_id,
    //                                 //       'amount' => $Amount,
    //                                 //       'account_code' => $cash_account->code,
    //                                 //       'amount_in_words' => $this->numberToWord($Amount)
    //                                 // ];
    //                                 // DB::table('journal_entry_details')->insert($fare1);
    //                                 // DB::table('journal_entry_details')->insert($fare2);

    //                                 // Journal entry detail (Credit)
    //                                 $journal_entry_detail->saveJVDetail(
    //                                       $fare_jv_id, // journal entry id
    //                                       'Fare Payment Against Purchase Credit', //explaination
    //                                       $purchase->bill_no, //bill no
    //                                       0, // check no or 0
    //                                       $purchase->poDate, //check date
    //                                       0, // is credit flag 0 for credit, 1 for debit
    //                                       $Amount, //amount
    //                                       $cash_account->id, // account id
    //                                       $cash_account->code, // account code
    //                                       Auth::guard('admin_user')->User()->id //created by id
    //                                 );
    //                           }
    //                           // Vendor Payment Add
    //                           if ($purchase->paid > 0 && $purchase->paid_account != null) {
    //                                 $paid_account = AccountHead::find($purchase->paid_account);
    //                                 $journal_type = ($paid_account->is_cash_account == 1) ? config('global.CPV') : config('global.BPV');
    //                                 $journal_vendor = Journal::find($journal_type);
    //                                 // Add journal entry
    //                                 $data = [
    //                                       "date" => $purchase->poDate,
    //                                       "prefix" => $journal_vendor->prefix,
    //                                       "journalId" => $journal_vendor->id
    //                                 ];
    //                                 $entryNum_vendor = $this->generateJournalEntryNum($data);
    //                                 $journal_entry_vendor = new JournalEntry;
    //                                 $journal_entry_vendor->journal_id = $journal_vendor->id;
    //                                 $journal_entry_vendor->vendor_id = $purchase->vendorId;
    //                                 $journal_entry_vendor->date_post = date("Y-m-d", strtotime(str_replace('/', '-', $purchase->poDate)));
    //                                 $journal_entry_vendor->reference = 'Date :' . $purchase->poDate . ' Against PO. ' . $purchase->poNum;
    //                                 $journal_entry_vendor->entryNum = $entryNum_vendor;
    //                                 $journal_entry_vendor->restaurant_id =  Auth::guard('admin_user')->User()->userRestaurant->restaurant_id;
    //                                 $journal_entry_vendor->createdby_id = Auth::guard('admin_user')->User()->id;
    //                                 $journal_entry_vendor->save();
    //                                 $vendor_account = AccountHead::find($vendor->account_id);
    //                                 $paid_jv_id = $journal_entry_vendor->id;
    //                                 // Journal Entry Detail
    //                                 $Amount = str_replace(',', '', $purchase->paid);
    //                                 // $paid1 = [
    //                                 //       'credit' => $Amount,
    //                                 //       'journal_entry_id' => $journal_entry_vendor->id,
    //                                 //       'explanation' => 'Vendor Paid Payment Against Purchase Credit',
    //                                 //       'bill_no' => $purchase->bill_no,
    //                                 //       'check_no' => 0,
    //                                 //       'check_date' => $purchase->poDate,
    //                                 //       'debit' => 0.00,
    //                                 //       'acc_head_id' => $paid_account->id,
    //                                 //       'createdBy' =>  Auth::guard('admin_user')->User()->userRestaurant->restaurant_id,
    //                                 //       'amount' => $Amount,
    //                                 //       'account_code' => $paid_account->code,
    //                                 //       'amount_in_words' => $this->numberToWord($Amount)
    //                                 // ];

    //                                 // Journal entry detail (Credit)
    //                                 $journal_entry_detail->saveJVDetail(
    //                                       $paid_jv_id, // journal entry id
    //                                       'Vendor Paid Payment Against Purchase Credit', //explaination
    //                                       $purchase->bill_no, //bill no
    //                                       0, // check no or 0
    //                                       $purchase->poDate, //check date
    //                                       0, // is credit flag 0 for credit, 1 for debit
    //                                       $Amount, //amount
    //                                       $paid_account->id, // account id
    //                                       $paid_account->code, // account code
    //                                       Auth::guard('admin_user')->User()->id //created by id
    //                                 );

    //                                 // $paid2 = [
    //                                 //       'credit' => 0.00,
    //                                 //       'journal_entry_id' => $journal_entry_vendor->id,
    //                                 //       'explanation' => 'Vendor Paid Payment Against Purchase Debit',
    //                                 //       'bill_no' => $purchase->bill_no,
    //                                 //       'check_no' => 0,
    //                                 //       'check_date' => $purchase->poDate,
    //                                 //       'debit' => $Amount,
    //                                 //       'acc_head_id' => $vendor_account->id,
    //                                 //       'createdBy' =>  Auth::guard('admin_user')->User()->userRestaurant->restaurant_id,
    //                                 //       'amount' => $Amount,
    //                                 //       'account_code' => $vendor_account->code,
    //                                 //       'amount_in_words' => $this->numberToWord($Amount)
    //                                 // ];
    //                                 // DB::table('journal_entry_details')->insert($paid1);
    //                                 // DB::table('journal_entry_details')->insert($paid2);

    //                                 // Journal entry detail (Debit)
    //                                 $journal_entry_detail->saveJVDetail(
    //                                       $paid_jv_id, // journal entry id
    //                                       'Vendor Paid Payment Against Purchase Debit', //explaination
    //                                       $purchase->bill_no, //bill no
    //                                       0, // check no or 0
    //                                       $purchase->poDate, //check date
    //                                       1, // is credit flag 0 for credit, 1 for debit
    //                                       $Amount, //amount
    //                                       $vendor_account->id, // account id
    //                                       $vendor_account->code, // account code
    //                                       Auth::guard('admin_user')->User()->id //created by id
    //                                 );

    //                                 // Vendor Payment Add
    //                                 $vendor_payment_data = [
    //                                       'vendor_id' => $purchase->vendorId,
    //                                       'account_id' => $purchase->paid_account,
    //                                       'payment_date' => date('Y-m-d'),
    //                                       'cheque_ref' => 'Date :' . $purchase->poDate . ' Against PO. ' . $purchase->poNum,
    //                                       'sub_total' => $purchase->paid,
    //                                       'total' => $purchase->paid,
    //                                       'tax' => 0,
    //                                       'tax_amount' => $purchase->tax_amount ?? 0,
    //                                       'tax_account_id' => Null,
    //                                       'jv_id' => $journal_entry_vendor->id,
    //                                       'restaurant_id' => Auth::guard('admin_user')->User()->userRestaurant->restaurant_id,
    //                                       'createdby_id'=>Auth::guard('admin_user')->User()->id
    //                                 ];
    //                                 $vendor_payment =  VendorPayment::create($vendor_payment_data);
    //                                 $vendor_payment_id = $vendor_payment->id;
    //                                 // Vendor amount update
    //                                 $vendor->opening_balance = $vendor->opening_balance - $purchase->paid;
    //                                 $vendor->update();
    //                           }
    //                     }
    //                     // Purchase Update
    //                     $purchase->posted = 1;
    //                     $purchase->jv_id = $journal_entry_id;
    //                     $purchase->paid_jv_id = $paid_jv_id;
    //                     $purchase->fare_jv_id = $fare_jv_id;
    //                     $purchase->vendor_payment_id = $vendor_payment_id;
    //                     $purchase->update();
    //               }
    //               DB::commit();
    //         } catch (Exception $e) {

    //               DB::rollback();
    //               throw $e;
    //         }
    //         return true;
    //   }

    // get by id
    public function getRattiKaatById($id)
    {
        $ratti_kaat = $this->model_ratti_kaat->getModel()::find($id);

        if (!$ratti_kaat)
            return false;

        return $ratti_kaat;
    }

    //ratti kaat detail 
    public function getRattiKaatDetail($ratti_kaat_id)
    {
        return $this->model_ratti_kaat_detail->getModel()::with('product_name')->where('ratti_kaat_id', $ratti_kaat_id)->orderBy('id', 'DESC')->where('is_deleted', 0)->get();
    }

    // status by id
    public function statusById($id)
    {
        $ratti_kaat = $this->model_ratti_kaat->getModel()::find($id);
        if ($ratti_kaat->is_active == 0) {
            $ratti_kaat->is_active = 1;
        } else {
            $ratti_kaat->is_active = 0;
        }
        $ratti_kaat->updatedby_id = Auth::user()->id;
        $ratti_kaat->update();

        if ($ratti_kaat)
            return true;

        return false;
    }
    // delete by id
    public function deleteRattiKaatById($id)
    {
        $ratti_kaat = $this->model_ratti_kaat->getModel()::find($id);
        $ratti_kaat->is_deleted = 1;
        $ratti_kaat->deletedby_id = Auth::user()->id;
        $ratti_kaat->update();

        if (!$ratti_kaat)
            return false;

        return $ratti_kaat;
    }

    // get beads weight
    public function getBeadWeight($ratti_kaat_id, $product_id)
    {
        return $this->model_ratti_kaat_bead->getModel()::with(['ratti_kaat_name', 'product_name'])
            ->where('ratti_kaat_id', $ratti_kaat_id)
            ->where('product_id', $product_id)
            ->where('is_deleted', 0)
            ->get();
    }
    public function saveBeadWeight($obj)
    {
        try {
            DB::beginTransaction();
            $obj['createdby_id'] = Auth::User()->id;

            $saved_obj = $this->model_ratti_kaat_bead->create($obj);

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
        $ratti_kaat_bead = $this->model_ratti_kaat_bead->getModel()::find($id);
        $ratti_kaat_bead->is_deleted = 1;
        $ratti_kaat_bead->deletedby_id = Auth::user()->id;
        $ratti_kaat_bead->update();

        if (!$ratti_kaat_bead)
            return false;

        return $ratti_kaat_bead;
    }

    // get stones weight
    public function getStoneWeight($ratti_kaat_id, $product_id)
    {
        return $this->model_ratti_kaat_stone->getModel()::with(['ratti_kaat_name', 'product_name'])
            ->where('ratti_kaat_id', $ratti_kaat_id)
            ->where('product_id', $product_id)
            ->where('is_deleted', 0)
            ->get();
    }
    public function saveStoneWeight($obj)
    {
        try {
            DB::beginTransaction();
            $obj['createdby_id'] = Auth::User()->id;

            $saved_obj = $this->model_ratti_kaat_stone->create($obj);

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
        $ratti_kaat_stone = $this->model_ratti_kaat_stone->getModel()::find($id);
        $ratti_kaat_stone->is_deleted = 1;
        $ratti_kaat_stone->deletedby_id = Auth::user()->id;
        $ratti_kaat_stone->update();

        if (!$ratti_kaat_stone)
            return false;

        return $ratti_kaat_stone;
    }


    // get diamonds Carat
    public function getDiamondCarat($ratti_kaat_id, $product_id)
    {
        return $this->model_ratti_kaat_diamond->getModel()::with(['ratti_kaat_name', 'product_name'])
            ->where('ratti_kaat_id', $ratti_kaat_id)
            ->where('product_id', $product_id)
            ->where('is_deleted', 0)
            ->get();
    }
    public function saveDiamondCarat($obj)
    {
        try {
            DB::beginTransaction();
            $obj['createdby_id'] = Auth::User()->id;

            $saved_obj = $this->model_ratti_kaat_diamond->create($obj);

            DB::commit();
        } catch (Exception $e) {

            DB::rollback();
            throw $e;
        }

        return $saved_obj;
    }

    // delete diamond by id
    public function deleteDiamondCaratById($id)
    {
        $ratti_kaat_diamond = $this->model_ratti_kaat_diamond->getModel()::find($id);
        $ratti_kaat_diamond->is_deleted = 1;
        $ratti_kaat_diamond->deletedby_id = Auth::user()->id;
        $ratti_kaat_diamond->update();

        if (!$ratti_kaat_diamond)
            return false;

        return $ratti_kaat_diamond;
    }
}
