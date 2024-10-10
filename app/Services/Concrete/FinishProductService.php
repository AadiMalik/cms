<?php

namespace App\Services\Concrete;

use App\Repository\Repository;
use App\Models\FinishProduct;
use App\Models\FinishProductBead;
use App\Models\FinishProductDiamond;
use App\Models\FinishProductStone;
use App\Models\RattiKaatDetail;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class FinishProductService
{
    // initialize protected model variables
    protected $model_finish_product;
    protected $model_finish_product_bead;
    protected $model_finish_product_stone;
    protected $model_finish_product_diamond;

    public function __construct()
    {
        // set the model
        $this->model_finish_product = new Repository(new FinishProduct);
        $this->model_finish_product_bead = new Repository(new FinishProductBead);
        $this->model_finish_product_stone = new Repository(new FinishProductStone);
        $this->model_finish_product_diamond = new Repository(new FinishProductDiamond);
    }

    public function getFinishProductSource()
    {
        $model = $this->model_finish_product->getModel()::with(['product', 'warehouse'])->where('is_deleted', 0);

        $data = DataTables::of($model)
            ->addColumn('product', function ($item) {
                return $item->product->name ?? '';
            })
            ->addColumn('warehouse', function ($item) {
                return $item->warehouse->name ?? '';
            })
            ->addColumn('status', function ($item) {
                if ($item->is_active == 1) {
                    $status = '<label class="switch pr-5 switch-primary mr-3"><input type="checkbox" checked="checked" id="status" data-id="' . $item->id . '"><span class="slider"></span></label>';
                } else {
                    $status = '<label class="switch pr-5 switch-primary mr-3"><input type="checkbox" id="status" data-id="' . $item->id . '"><span class="slider"></span></label>';
                }
                return $status;
            })

            ->addColumn('action', function ($item) {
                $action_column = '';
                $view_column    = "<a class='text-warning mr-2' href='finish-product/view/" . $item->id . "'><i title='Add' class='nav-icon mr-2 fa fa-eye'></i>View</a>";
                $delete_column    = "<a class='text-danger mr-2' id='deleteFinishProduct' href='javascript:void(0)' data-toggle='tooltip'  data-id='" . $item->id . "' data-original-title='Delete'><i title='Delete' class='nav-icon mr-2 fa fa-trash'></i>Delete</a>";

                if (Auth::user()->can('customers_edit'))
                    $action_column .= $view_column;


                if (Auth::user()->can('customers_delete'))
                    $action_column .= $delete_column;

                return $action_column;
            })
            ->rawColumns(['product', 'warehouse', 'status', 'action'])
            ->make(true);
        return $data;
    }

    public function getAllActiveFinishProduct()
    {
        return $this->model_finish_product->getModel()::with(['product', 'warehouse'])
            ->where('is_deleted', 0)
            ->where('is_active', 1)
            ->get();
    }

    public function save($obj)
    {
        try {
            DB::beginTransaction();
            $finishProduct = [
                "tag_no" => $obj['tag_no'],
                "ratti_kaat_id" => $obj['ratti_kaat_id'],
                "ratti_kaat_detail_id" => $obj['ratti_kaat_detail_id'],
                "product_id" => $obj['product_id'],
                "warehouse_id" => $obj['warehouse_id'],
                "gold_carat" => $obj['gold_carat'],
                "scale_weight" => $obj['scale_weight'],
                "net_weight" => $obj['net_weight'],
                "bead_weight" => $obj['bead_weight'],
                "stones_weight" => $obj['stones_weight'],
                "diamond_weight" => $obj['diamond_weight'],
                "waste_per" => $obj['waste_per'],
                "waste" => $obj['waste'],
                "gross_weight" => $obj['gross_weight'],
                "laker" => $obj['laker'],
                "making_gram" => $obj['making_gram'],
                "making" => $obj['making'],
                "total_bead_price" => $obj['total_bead_price'],
                "total_stones_price" => $obj['total_stones_price'],
                "total_diamond_price" => $obj['total_diamond_price'],
                "other_amount" => $obj['other_amount'],
                "gold_rate" => $obj['gold_rate'],
                "total_gold_price" => $obj['total_gold_price'],
                "total_amount" => $obj['total_amount'],
                "picture" => $obj['picture'],
                "barcode" => $obj['barcode'],
                "createdby_id" => Auth::user()->id
            ];
            $saved_obj = $this->model_finish_product->create($finishProduct);

            $beadDetail = json_decode($obj['beadDetail']);
            foreach ($beadDetail as $item) {
                $finishProductBead = [
                    "finish_product_id" => $saved_obj->id,
                    "type" => $item->type,
                    "beads" => $item->beads,
                    "gram" => $item->gram,
                    "carat" => $item->carat,
                    "gram_rate" => $item->gram_rate,
                    "carat_rate" => $item->carat_rate,
                    "total_amount" => $item->total_amount,
                ];
                $this->model_finish_product_bead->create($finishProductBead);
            }

            // Stone Detail
            $stoneDetail = json_decode($obj['stonesDetail']);
            foreach ($stoneDetail as $item) {
                $finishProductStone = [
                    "finish_product_id" => $saved_obj->id,
                    "category" => $item->category,
                    "type" => $item->type,
                    "stones" => $item->stones,
                    "gram" => $item->gram,
                    "carat" => $item->carat,
                    "gram_rate" => $item->gram_rate,
                    "carat_rate" => $item->carat_rate,
                    "total_amount" => $item->total_amount,
                ];
                $this->model_finish_product_stone->create($finishProductStone);
            }

            // Diamond Detail
            $diamondDetail = json_decode($obj['diamondDetail']);
            foreach ($diamondDetail as $item) {
                $finishProductDiamond = [
                    "finish_product_id" => $saved_obj->id,
                    "type" => $item->type,
                    "diamonds" => $item->diamonds,
                    "color" => $item->color,
                    "cut" => $item->cut,
                    "clarity" => $item->clarity,
                    "carat" => $item->carat,
                    "carat_rate" => $item->carat_rate,
                    "total_amount" => $item->total_amount,
                ];
                $this->model_finish_product_diamond->create($finishProductDiamond);
            }


            $ratti_kaat_detail = RattiKaatDetail::find($obj['ratti_kaat_detail_id']);
            $ratti_kaat_detail->is_finish_product = 1;
            $ratti_kaat_detail->updatedby_id = Auth::user()->id;
            $ratti_kaat_detail->update();

            DB::commit();
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    public function getById($id)
    {
        return $this->model_finish_product->getModel()::with([
            'ratti_kaat',
            'ratti_kaat_detail',
            'product',
            'warehouse'
        ])->find($id);
    }

    public function getByTagNo($tag_no)
    {
        return $this->model_finish_product->getModel()::with([
            'ratti_kaat',
            'ratti_kaat_detail',
            'product',
            'warehouse'
        ])->where('tag_no',$tag_no)->first();
    }

    public function getBeadByFinishProductId($finish_product_id)
    {
        return $this->model_finish_product_bead->getModel()::with('finish_product')
            ->where('finish_product_id', $finish_product_id)
            ->where('is_deleted', 0)
            ->get();
    }
    public function getStoneByFinishProductId($finish_product_id)
    {
        return $this->model_finish_product_stone->getModel()::with('finish_product')
            ->where('finish_product_id', $finish_product_id)
            ->where('is_deleted', 0)
            ->get();
    }
    public function getDiamondByFinishProductId($finish_product_id)
    {
        return $this->model_finish_product_diamond->getModel()::with('finish_product')
            ->where('finish_product_id', $finish_product_id)
            ->where('is_deleted', 0)
            ->get();
    }

    public function statusById($id)
    {
        $finish_product = $this->model_finish_product->getModel()::find($id);
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
        try {
            DB::beginTransaction();
            $finish_product = $this->model_finish_product->getModel()::find($id);

            $ratti_kaat_detail = RattiKaatDetail::find($finish_product->ratti_kaat_detail_id);
            $ratti_kaat_detail->is_finish_product = 0;
            $ratti_kaat_detail->update();

            $finish_product->is_deleted = 1;
            $finish_product->deletedby_id = Auth::user()->id;
            $finish_product->update();

            $finish_product_beads = $this->model_finish_product_bead->getModel()::where('finish_product_id', $id)->get();
            foreach ($finish_product_beads as $item) {
                $finish_product_bead = $this->model_finish_product_bead->getModel()::find($item->id);
                $finish_product_bead->is_deleted = 1;
                $finish_product_bead->deletedby_id = Auth::user()->id;
                $finish_product_bead->update();
            }

            $finish_product_stones = $this->model_finish_product_stone->getModel()::where('finish_product_id', $id)->get();
            foreach ($finish_product_stones as $item) {
                $finish_product_stone = $this->model_finish_product_stone->getModel()::find($item->id);
                $finish_product_stone->is_deleted = 1;
                $finish_product_stone->deletedby_id = Auth::user()->id;
                $finish_product_stone->update();
            }

            $finish_product_diamonds = $this->model_finish_product_diamond->getModel()::where('finish_product_id', $id)->get();
            foreach ($finish_product_diamonds as $item) {
                $finish_product_diamond = $this->model_finish_product_diamond->getModel()::find($item->id);
                $finish_product_diamond->is_deleted = 1;
                $finish_product_diamond->deletedby_id = Auth::user()->id;
                $finish_product_diamond->update();
            }

            DB::commit();
        } catch (Exception $e) {
            return false;
        }

        return true;
    }
}
