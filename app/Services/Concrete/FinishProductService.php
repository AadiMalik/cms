<?php

namespace App\Services\Concrete;

use App\Repository\Repository;
use App\Models\FinishProduct;
use App\Models\RattiKaatDetail;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class FinishProductService
{
    // initialize protected model variables
    protected $model_finish_product;

    public function __construct()
    {
        // set the model
        $this->model_finish_product = new Repository(new FinishProduct);
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

        $obj['createdby_id'] = Auth::user()->id;
        $saved_obj = $this->model_finish_product->create($obj);

        $ratti_kaat_detail = RattiKaatDetail::find($obj['ratti_kaat_detail_id']);
        $ratti_kaat_detail->is_finish_product = 1;
        $ratti_kaat_detail->updatedby_id = Auth::user()->id;
        $ratti_kaat_detail->update();

        if (!$saved_obj)
            return false;

        return true;
    }

    public function getById($id)
    {
        return $this->model_finish_product->getModel()::find($id);
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
        $finish_product = $this->model_finish_product->getModel()::find($id);
        $finish_product->is_deleted = 1;
        $finish_product->deletedby_id = Auth::user()->id;
        $finish_product->update();

        if ($finish_product)
            return true;

        return false;
    }
}
