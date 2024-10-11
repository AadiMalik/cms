<?php

namespace App\Services\Concrete;

use App\Models\Customer;
use App\Models\FinishProduct;
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
                if ($item->is_posted != 1)
                    return '<input type="checkbox" class="sub_chk" value="' . $item->id . '" data-id="' . $item->id . '" >';
            })
            ->addColumn('posted', function ($item) {
                $badge_color = $item->is_posted == 0 ? 'badge-danger' : 'badge-success';
                $badge_text = $item->is_posted == 0 ? 'Unposted' : 'Posted';
                return '<span class="badge ' . $badge_color . '">' . $badge_text . '</span>';
            })
            ->addColumn('action', function ($item) {

                $jvs = '';
                if ($item->jv_id != null)
                    $jvs .= "filter[]=" . $item->jv_id . "";

                $action_column = '';
                // $edit_column    = "<a class='text-success mr-2' href='sale/edit/" . $item->id . "'><i title='Edit' class='nav-icon mr-2 fa fa-edit'></i>Edit</a>";
                $view_column    = "<a class='text-warning mr-2' href='sale/view/" . $item->id . "'><i title='Add' class='nav-icon mr-2 fa fa-eye'></i>View</a>";
                $all_print_column    = "<a class='text-info mr-2' id='Ref' href='javascript:void(0)' data-toggle='tooltip'  data-filter='" . $jvs . "' data-original-title='Accounting'><i title='Accounting' class='nav-icon mr-2 fa fa-eye'></i>Accounting</a>";
                $delete_column    = "<a class='text-danger mr-2' id='deleteSale' href='javascript:void(0)' data-toggle='tooltip'  data-id='" . $item->id . "' data-original-title='Delete'><i title='Delete' class='nav-icon mr-2 fa fa-trash'></i>Delete</a>";

                // if (Auth::user()->can('customers_edit'))
                //     $action_column .= $edit_column;

                if (Auth::user()->can('customers_edit'))
                    $action_column .= $view_column;
                if (Auth::user()->can('ratti_kaat_access') && $item->is_posted == 1)
                    $action_column .= $all_print_column;

                if (Auth::user()->can('customers_delete'))
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
                    "finish_product_id" => $item->finish_product_id ?? '',
                    "ratti_kaat_id" => $item->ratti_kaat_id ?? '',
                    "ratti_kaat_detail_id" => $item->ratti_kaat_detail_id ?? '',
                    "product_id" => $item->product_id ?? '',
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

    public function statusById($id)
    {
        $finish_product = $this->model_sale->getModel()::find($id);
        if ($finish_product->is_active == 0) {
            $finish_product->is_active = 1;
        } else {
            $finish_product->is_active = 0;
        }
        $finish_product->updatedby_id = Auth::user()->id;
        $finish_product->update();

        if ($finish_product)
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
