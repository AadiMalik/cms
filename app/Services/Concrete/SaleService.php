<?php

namespace App\Services\Concrete;

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

    public function getSaleSource()
    {
        $model = $this->model_sale->getModel()::with('customer_name')->where('is_deleted', 0);

        $data = DataTables::of($model)
            ->addColumn('customer', function ($item) {
                return $item->customer_name->name ?? '';
            })
            
            ->addColumn('action', function ($item) {
                $action_column = '';
                $edit_column    = "<a class='text-success mr-2' href='sale/edit/" . $item->id . "'><i title='Edit' class='nav-icon mr-2 fa fa-edit'></i>Edit</a>";
                $view_column    = "<a class='text-warning mr-2' href='sale/view/" . $item->id . "'><i title='Add' class='nav-icon mr-2 fa fa-eye'></i>View</a>";
                $delete_column    = "<a class='text-danger mr-2' id='deleteSale' href='javascript:void(0)' data-toggle='tooltip'  data-id='" . $item->id . "' data-original-title='Delete'><i title='Delete' class='nav-icon mr-2 fa fa-trash'></i>Delete</a>";

                if (Auth::user()->can('customers_edit'))
                    $action_column .= $edit_column;

                if (Auth::user()->can('customers_edit'))
                    $action_column .= $view_column;


                if (Auth::user()->can('customers_delete'))
                    $action_column .= $delete_column;

                return $action_column;
            })
            ->rawColumns(['customer', 'action'])
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

        $obj['createdby_id'] = Auth::user()->id;
        $saved_obj = $this->model_sale->create($obj);

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
