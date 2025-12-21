<?php

namespace App\Services\Concrete;

use App\Repository\Repository;
use App\Models\MetalProduct;
use App\Models\MetalProductBead;
use App\Models\MetalProductDiamond;
use App\Models\FinishProductLocation;
use App\Models\MetalProductStone;
use App\Models\JobPurchaseDetail;
use App\Models\MetalPurchaseDetail;
use App\Models\RattiKaatDetail;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class MetalProductService
{
    // initialize protected model variables
    protected $model_metal_product;
    protected $model_metal_product_bead;
    protected $model_metal_product_stone;
    protected $model_metal_product_diamond;
    protected $model_finish_product_location;

    public function __construct()
    {
        // set the model
        $this->model_metal_product = new Repository(new MetalProduct);
        $this->model_metal_product_bead = new Repository(new MetalProductBead);
        $this->model_metal_product_stone = new Repository(new MetalProductStone);
        $this->model_metal_product_diamond = new Repository(new MetalProductDiamond);
        $this->model_finish_product_location = new Repository(new FinishProductLocation);
    }

    public function getMetalProductSource()
    {
        $locations = $this->model_finish_product_location->getModel()::where('is_active', 1)->where('is_deleted', 0)->get();
        $model = $this->model_metal_product->getModel()::with(['product', 'warehouse', 'parent_name'])->where('is_deleted', 0);

        $data = DataTables::of($model)
            ->addColumn('product', function ($item) {
                return $item->product->name ?? '';
            })
            ->addColumn('warehouse', function ($item) {
                return $item->warehouse->name ?? '';
            })
            ->addColumn('parent', function ($item) {

                return $item->parent_name->tag_no ?? '';
            })
            ->addColumn('is_parent', function ($item) {
                if ($item->is_parent == 1) {
                    $parent = '<span class=" badge badge-success mr-3">Yes</span>';
                } else {
                    $parent = '<span class=" badge badge-danger mr-3">No</span>';
                }
                return $parent;
            })
            ->addColumn('saled', function ($item) {
                if ($item->is_saled == 1) {
                    $saled = '<span class=" badge badge-success mr-3">Yes</span>';
                } else {
                    $saled = '<span class=" badge badge-danger mr-3">No</span>';
                }
                return $saled;
            })
            ->addColumn('status', function ($item) {
                if (Auth::user()->can('tagging_metal_product_create')) {
                    if ($item->is_active == 1) {
                        $status = '<label class="switch pr-2 switch-primary mr-1"><input type="checkbox" checked="checked" id="status" data-id="' . $item->id . '"><span class="slider"></span></label>';
                    } else {
                        $status = '<label class="switch pr-2 switch-primary mr-1"><input type="checkbox" id="status" data-id="' . $item->id . '"><span class="slider"></span></label>';
                    }
                    return $status;
                } else {
                    return 'N/A';
                }
            })
            ->addColumn('location', function ($item) use ($locations) {
                $dropdown = '<select id="location-dropdown" style="width:150px;" class="form-control" data-id="' . $item->id . '">';
                $dropdown .= '<option value="">Select Location</option>';

                foreach ($locations as $location) {
                    $selected = ($item->finish_product_location_id == $location->id) ? 'selected' : '';
                    $dropdown .= '<option value="' . $location->id . '" ' . $selected . '>' . $location->name . '</option>';
                }

                $dropdown .= '</select>';
                return $dropdown;
            })
            ->addColumn('action', function ($item) {
                $action_column = '';
                $view_column    = "<a class='text-warning mr-2' href='metal-product/view/" . $item->id . "'><i title='Add' class='nav-icon mr-2 fa fa-eye'></i>View</a>";
                $print_column    = "<a class='text-info mr-2' href='metal-product/print/" . $item->id . "'><i title='Print' class='nav-icon mr-2 fa fa-print'></i>Tag Print</a>";
                $delete_column    = "<a class='text-danger mr-2' id='deleteMetalProduct' href='javascript:void(0)' data-toggle='tooltip'  data-id='" . $item->id . "' data-original-title='Delete'><i title='Delete' class='nav-icon mr-2 fa fa-trash'></i>Delete</a>";

                if (Auth::user()->can('tagging_metal_product_view'))
                    $action_column .= $view_column;


                if (Auth::user()->can('tagging_metal_product_delete'))
                    $action_column .= $delete_column;

                // if (Auth::user()->can('tagging_metal_product_view'))
                //     $action_column .= $print_column;

                return $action_column;
            })
            ->rawColumns(['product', 'warehouse', 'parent', 'is_parent', 'saled', 'status', 'location', 'action'])
            ->make(true);
        return $data;
    }
    public function getActiveMetalProduct()
    {
        return $this->model_metal_product->getModel()::with(['product', 'warehouse'])
            ->where('is_deleted', 0)
            ->where('is_active', 1)
            ->get();
    }
    public function getAllActiveMetalProduct()
    {
        return $this->model_metal_product->getModel()::with(['product', 'warehouse'])
            ->where('is_deleted', 0)
            ->where('is_active', 1)
            ->where('is_saled', 0)
            ->get();
    }

    public function getAllActiveParentMetalProduct()
    {
        return $this->model_metal_product->getModel()::with(['product', 'warehouse'])
            ->where('is_deleted', 0)
            ->where('is_active', 1)
            ->where('is_saled', 0)
            ->where('is_parent', 1)
            ->get();
    }

    public function getAllSaledMetalProduct()
    {
        return $this->model_metal_product->getModel()::with(['product', 'warehouse'])
            ->where('is_deleted', 0)
            ->where('is_active', 1)
            ->where('is_saled', 1)
            ->where('is_parent', 0)
            ->get();
    }
    public function getAllMolProductId($product_id)
    {
        return MetalProduct::select(
            'products.id',
            'products.name',
            'products.mol',
            DB::raw('COUNT(metal_products.id) as total_quantity')
        )
            ->leftJoin('metal_products', 'products.id', '=', 'metal_products.product_id')
            ->where('products.id', $product_id)
            ->where('products.is_deleted', 0)
            ->where('products.is_active', 1)
            ->where('metal_products.is_deleted', 0)
            ->where('metal_products.is_active', 1)
            ->where('metal_products.is_saled', 1)
            ->where('metal_products.is_parent', 0)
            ->groupBy('products.id', 'products.name', 'products.mol')
            ->havingRaw('total_quantity <= mol')
            ->first();
    }

    public function save($obj)
    {
        try {
            DB::beginTransaction();
            $metalProduct = [
                "tag_no" => $obj['tag_no'],
                "parent_id" => $obj['parent_id'] ?? 0,
                "is_parent" => $obj['is_parent'],
                // "job_purchase_id" => $obj['job_purchase_id'] ?? null,
                // "job_purchase_detail_id" => $obj['job_purchase_detail_id'] ?? null,
                "metal_purchase_id" => $obj['metal_purchase_id'] ?? null,
                "metal_purchase_detail_id" => $obj['metal_purchase_detail_id'] ?? null,
                "product_id" => $obj['product_id'] ?? null,
                "warehouse_id" => $obj['warehouse_id'] ?? null,
                "purity" => $obj['purity'] ?? 0,
                "metal" => $obj['metal'] ?? '',
                "metal_rate" => $obj['metal_rate'] ?? 0,
                "scale_weight" => $obj['scale_weight'] ?? 0,
                "net_weight" => $obj['net_weight'] ?? 0,
                "bead_weight" => $obj['bead_weight'] ?? 0,
                "stones_weight" => $obj['stones_weight'] ?? 0,
                "diamond_weight" => $obj['diamond_weight'] ?? 0,
                "gross_weight" => $obj['gross_weight'] ?? 0,
                "total_metal_amount" => $obj['total_metal_amount'] ?? 0,
                "total_bead_amount" => $obj['total_bead_amount'] ?? 0,
                "total_stones_amount" => $obj['total_stones_amount'] ?? 0,
                "total_diamond_amount" => $obj['total_diamond_amount'] ?? 0,
                "other_charges" => $obj['other_charges'] ?? 0,
                "total_amount" => $obj['total_amount'] ?? 0,
                "picture" => $obj['picture'] ?? null,
                "barcode" => $obj['barcode'] ?? null,
                "createdby_id" => Auth::user()->id,
                "finish_product_location_id" => 1
            ];
            $saved_obj = $this->model_metal_product->create($metalProduct);

            $beadDetail = json_decode($obj['beadDetail']);
            foreach ($beadDetail as $item) {
                $metalProductBead = [
                    "metal_product_id" => $saved_obj->id,
                    "type" => $item->type,
                    "beads" => $item->beads,
                    "gram" => $item->gram,
                    "carat" => $item->carat,
                    "gram_rate" => $item->gram_rate,
                    "carat_rate" => $item->carat_rate,
                    "total_amount" => $item->total_amount,
                ];
                $this->model_metal_product_bead->create($metalProductBead);
            }

            // Stone Detail
            $stoneDetail = json_decode($obj['stonesDetail']);
            foreach ($stoneDetail as $item) {
                $metalProductStone = [
                    "metal_product_id" => $saved_obj->id,
                    "category" => $item->category,
                    "type" => $item->type,
                    "stones" => $item->stones,
                    "gram" => $item->gram,
                    "carat" => $item->carat,
                    "gram_rate" => $item->gram_rate,
                    "carat_rate" => $item->carat_rate,
                    "total_amount" => $item->total_amount,
                ];
                $this->model_metal_product_stone->create($metalProductStone);
            }

            // Diamond Detail
            $diamondDetail = json_decode($obj['diamondDetail']);
            foreach ($diamondDetail as $item) {
                $metalProductDiamond = [
                    "metal_product_id" => $saved_obj->id,
                    "type" => $item->type,
                    "diamonds" => $item->diamonds,
                    "color" => $item->color,
                    "cut" => $item->cut,
                    "clarity" => $item->clarity,
                    "carat" => $item->carat,
                    "carat_rate" => $item->carat_rate,
                    "total_amount" => $item->total_amount,
                ];
                $this->model_metal_product_diamond->create($metalProductDiamond);
            }

            if ($obj['metal_purchase_detail_id'] != null) {
                $metal_purchase_detail = MetalPurchaseDetail::find($obj['metal_purchase_detail_id']);
                $metal_purchase_detail->is_metal_product = 1;
                $metal_purchase_detail->updatedby_id = Auth::user()->id;
                $metal_purchase_detail->update();
            }
            //  elseif ($obj['job_purchase_detail_id'] != null) {
            //     $job_purchase_detail = JobPurchaseDetail::find($obj['job_purchase_detail_id']);
            //     $job_purchase_detail->is_metal_product = 1;
            //     $job_purchase_detail->updatedby_id = Auth::user()->id;
            //     $job_purchase_detail->update();
            // }

            DB::commit();
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    public function getById($id)
    {
        return $this->model_metal_product->getModel()::with([
            'metal_purchase',
            'metal_purchase_detail',
            'product',
            'warehouse'
        ])->find($id);
    }

    public function getByIds($ids)
    {
        if (!is_array($ids)) {
            $ids = explode(',', $ids);
        }
        return $this->model_metal_product->getModel()::with([
            'metal_purchase',
            'metal_purchase_detail',
            'product',
            'warehouse'
        ])->whereIn('id', $ids)->get();
    }

    public function getByTagNo($tag_no)
    {
        $metal_product = $this->model_metal_product->getModel()::with([
            'metal_purchase',
            'metal_purchase_detail',
            'product',
            'warehouse'
        ])->where('tag_no', $tag_no)
            ->first();
        if ($metal_product->is_parent == 1) {
            $metal_products = $this->model_metal_product->getModel()::with([
                'metal_purchase',
                'metal_purchase_detail',
                'product',
                'warehouse'
            ])->where('parent_id', $metal_product->id)->get();
            $data = [];
            foreach ($metal_products as $item) {
                $beadDetail = $this->model_metal_product_bead->getModel()::select('type', 'metal_product_id', 'beads', 'gram', 'carat', 'gram_rate', 'carat_rate', 'total_amount')
                    ->where('metal_product_id', $item->id)
                    ->where('is_deleted', 0)->get();
                $stonesDetail = $this->model_metal_product_stone->getModel()::select('category', 'type', 'metal_product_id', 'stones', 'gram', 'carat', 'gram_rate', 'carat_rate', 'total_amount')
                    ->where('metal_product_id', $item->id)
                    ->where('is_deleted', 0)->get();
                $diamondDetail = $this->model_metal_product_diamond->getModel()::select('diamonds', 'type', 'metal_product_id', 'color', 'cut', 'clarity', 'carat', 'carat_rate', 'total_amount', 'total_dollar')
                    ->where('metal_product_id', $item->id)
                    ->where('is_deleted', 0)->get();
                $data[] = [
                    "tag_no" => $item->tag_no ?? '',
                    "metal_product_id" => $item->id,
                    "metal_purchase_id" => $item->metal_purchase_id ?? '',
                    "metal_purchase_detail_id" => $item->metal_purchase_detail_id ?? '',
                    // "job_purchase_detail_id" => $item->job_purchase_detail_id ?? '',
                    "product" => $item->product->name ?? '',
                    "product_id" => $item->product_id ?? '',
                    "purity" => $item->purity ?? 0,
                    "metal_rate" => $item->metal_rate ?? 0,
                    "metal" => $item->metal ?? '',
                    "scale_weight" => $item->scale_weight ?? 0,
                    "bead_weight" => $item->bead_weight ?? 0,
                    "stones_weight" => $item->stones_weight ?? 0,
                    "diamond_weight" => $item->diamond_weight ?? 0,
                    "net_weight" => $item->net_weight ?? 0,
                    "gross_weight" => $item->gross_weight ?? 0,
                    "total_metal_amount" => $item->total_metal_amount ?? 0,
                    "other_charges" => $item->other_charges ?? 0,
                    "total_bead_amount" => $item->total_bead_amount ?? 0,
                    "total_stones_amount" => $item->total_stones_amount ?? 0,
                    "total_diamond_amount" => $item->total_diamond_amount ?? 0,
                    "total_amount" => $item->total_amount ?? 0,
                    "beadDetail" => $beadDetail,
                    "stonesDetail" => $stonesDetail,
                    "diamondDetail" => $diamondDetail
                ];
            }
            return $data;
        }
        return $metal_product;
    }

    public function getBeadByMetalProductId($metal_product_id)
    {
        return $this->model_metal_product_bead->getModel()::with('metal_product')
            ->where('metal_product_id', $metal_product_id)
            ->where('is_deleted', 0)
            ->get();
    }
    public function getStoneByMetalProductId($metal_product_id)
    {
        return $this->model_metal_product_stone->getModel()::with('metal_product')
            ->where('metal_product_id', $metal_product_id)
            ->where('is_deleted', 0)
            ->get();
    }
    public function getDiamondByMetalProductId($metal_product_id)
    {
        return $this->model_metal_product_diamond->getModel()::with('metal_product')
            ->where('metal_product_id', $metal_product_id)
            ->where('is_deleted', 0)
            ->get();
    }

    public function statusById($id)
    {
        $metal_product = $this->model_metal_product->getModel()::find($id);
        if ($metal_product->is_active == 0) {
            $metal_product->is_active = 1;
        } else {
            $metal_product->is_active = 0;
        }
        $metal_product->updatedby_id = Auth::user()->id;
        $metal_product->update();

        if ($metal_product)
            return true;

        return false;
    }

    public function deleteById($id)
    {
        try {
            DB::beginTransaction();
            $metal_product = $this->model_metal_product->getModel()::find($id);

            if ($metal_product->is_parent != 1) {
                $metal_purchase_detail = MetalPurchaseDetail::find($metal_product->metal_purchase_detail_id);
                $metal_purchase_detail->is_metal_product = 0;
                $metal_purchase_detail->update();
            }
            $metal_product->is_deleted = 1;
            $metal_product->deletedby_id = Auth::user()->id;
            $metal_product->update();

            $metal_product_beads = $this->model_metal_product_bead->getModel()::where('metal_product_id', $id)->get();
            foreach ($metal_product_beads as $item) {
                $metal_product_bead = $this->model_metal_product_bead->getModel()::find($item->id);
                $metal_product_bead->is_deleted = 1;
                $metal_product_bead->deletedby_id = Auth::user()->id;
                $metal_product_bead->update();
            }

            $metal_product_stones = $this->model_metal_product_stone->getModel()::where('metal_product_id', $id)->get();
            foreach ($metal_product_stones as $item) {
                $metal_product_stone = $this->model_metal_product_stone->getModel()::find($item->id);
                $metal_product_stone->is_deleted = 1;
                $metal_product_stone->deletedby_id = Auth::user()->id;
                $metal_product_stone->update();
            }

            $metal_product_diamonds = $this->model_metal_product_diamond->getModel()::where('metal_product_id', $id)->get();
            foreach ($metal_product_diamonds as $item) {
                $metal_product_diamond = $this->model_metal_product_diamond->getModel()::find($item->id);
                $metal_product_diamond->is_deleted = 1;
                $metal_product_diamond->deletedby_id = Auth::user()->id;
                $metal_product_diamond->update();
            }

            DB::commit();
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    public function updateLocation($obj)
    {
        $metal_product = $this->model_metal_product->getModel()::find($obj['id']);
        $metal_product->finish_product_location_id = $obj['finish_product_location_id'];
        $metal_product->update();
        return true;
    }

    public function updatePicture($obj)
    {
        $metal_product = $this->model_metal_product->getModel()::find($obj['id']);
        $metal_product->picture = $obj['picture'];
        $metal_product->update();
        return true;
    }

    public function getMetalProductByDate($obj)
    {
        return $this->model_metal_product->getModel()::where('is_deleted', 0)
            ->whereDate('created_at', '>=', $obj['start_date'])
            ->whereDate('created_at', '<=', $obj['end_date'])
            ->get();
    }
}
