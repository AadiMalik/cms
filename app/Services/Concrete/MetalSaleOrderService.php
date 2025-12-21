<?php

namespace App\Services\Concrete;

use App\Models\JournalEntry;
use App\Models\MetalSaleOrder;
use App\Repository\Repository;
use App\Models\MetalSaleOrderDetail;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class MetalSaleOrderService
{
    // initialize protected model variables
    protected $model_metal_sale_order;
    protected $model_metal_sale_order_detail;
    protected $model_journal_entry;

    protected $common_service;
    protected $journal_entry_service;
    public function __construct()
    {
        // set the model
        $this->model_metal_sale_order = new Repository(new MetalSaleOrder);
        $this->model_metal_sale_order_detail = new Repository(new MetalSaleOrderDetail);
        $this->model_journal_entry = new Repository(new JournalEntry);

        $this->common_service = new CommonService();
        $this->journal_entry_service = new JournalEntryService();
    }

    public function getSource($obj)
    {
        $wh = [];
        if ($obj['customer_id'] != '') {
            $wh[] = ['customer_id', $obj['customer_id']];
        }
        $model = $this->model_metal_sale_order->getModel()::has('MetalSaleOrderDetail')
            ->with(['warehouse_name', 'customer_name'])
            ->where('is_deleted', 0)
            ->whereBetween('metal_sale_order_date', [date("Y-m-d", strtotime(str_replace('/', '-', $obj['start']))), date("Y-m-d", strtotime(str_replace('/', '-', $obj['end'])))])
            ->where($wh);

        $data = DataTables::of($model)
            ->addColumn('customer_name', function ($item) {
                return $item->customer_name->name ?? '';
            })
            ->addColumn('warehouse_name', function ($item) {
                return $item->warehouse_name->name ?? '';
            })
            ->addColumn('advance', function ($item) {
                $balance = $this->journal_entry_service->getMetalSaleOrderAdvanceById($item->id);
                return $balance ?? 0;
            })
            ->addColumn('is_purchased', function ($item) {
                if ($item->is_purchased == 1) {
                    $saled = '<span class=" badge badge-success mr-3">Yes</span>';
                } else {
                    $saled = '<span class=" badge badge-danger mr-3">No</span>';
                }
                return $saled;
            })
            ->addColumn('is_complete', function ($item) {
                if ($item->is_complete == 1) {
                    $saled = '<span class=" badge badge-success mr-3">Yes</span>';
                } else {
                    $saled = '<span class=" badge badge-danger mr-3">No</span>';
                }
                return $saled;
            })
            ->addColumn('action', function ($item) {

                $action_column = '';
                $print_column    = "<a class='text-info mr-2' href='metal-sale-order/print/" . $item->id . "'><i title='Add' class='nav-icon mr-2 fa fa-print'></i>Print</a>";
                $delete_column    = "<a class='text-danger mr-2' id='deleteMetalSaleOrder' href='javascript:void(0)' data-toggle='tooltip'  data-id='" . $item->id . "' data-original-title='Delete'><i title='Delete' class='nav-icon mr-2 fa fa-trash'></i>Delete</a>";
                $payment_column    = "<a class='text-primary mr-2' href='javascript:void(0)' id='createNewPayment' data-toggle='tooltip'  data-metal_sale_order_id='" . $item->id . "' data-metal_customer_id='" . $item->customer_id . "'><i title='Add Payment' class='nav-icon mr-2 fa fa-dollar'></i>Add Payment</a>";
                
                if (Auth::user()->can('customer_payment_create'))
                $action_column .= $payment_column;

                if (Auth::user()->can('metal_sale_order_print'))
                    $action_column .= $print_column;

                if (Auth::user()->can('metal_sale_order_delete'))
                    $action_column .= $delete_column;

                return $action_column;
            })
            ->rawColumns(['customer_name', 'warehouse_name', 'advance','is_purchased','is_complete', 'action'])
            ->addIndexColumn()
            ->make(true);
        return $data;
    }

    public function getAllMetalSaleOrder()
    {
        return $this->model_metal_sale_order->getModel()::with('customer_name')
            ->where('is_deleted', 0)
            ->get();
    }
    public function saveMetalSaleOrder()
    {
        try {
            DB::beginTransaction();
            $obj = [
                'metal_sale_order_no' => $this->common_service->generateMetalSaleOrderNo(),
                'createdby_id' => Auth::User()->id
            ];
            $saved_obj = $this->model_metal_sale_order->create($obj);

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

            $metalSaleOrderDetail = json_decode($obj['metalSaleOrderDetail'], true);
            $saleOrderObj = [
                "metal_sale_order_date" => $obj['metal_sale_order_date'],
                "metal_delivery_date" => $obj['metal_delivery_date'],
                "customer_id" => $obj['customer_id'],
                "warehouse_id" => $obj['warehouse_id'],
                "total_qty" => count($metalSaleOrderDetail) ?? 0,
                "updatedby_id" => Auth::user()->id
            ];
            $metal_sale_order = $this->model_metal_sale_order->update($saleOrderObj, $obj['id']);
            foreach ($metalSaleOrderDetail as $item) {
                $metalSaleOrderDetailObj = [
                    "metal_sale_order_id" => $obj['id'],
                    "product_id" => $item['product_id'] ?? '',
                    "metal" => $item['metal'] ?? '',
                    "rate" => $item['rate'] ?? 0,
                    "purity" => $item['purity'] ?? 0,
                    "category" => $item['category'] ?? '',
                    "design_no" => $item['design_no'] ?? '',
                    "net_weight" => $item['net_weight'] ?? 0.000,
                    "waste" => $item['waste'] ?? 0.000,
                    "gross_weight" => $item['gross_weight'] ?? 0.000,
                    "description" => $item['description'] ?? '',
                    "createdby_id" => Auth::user()->id
                ];
                $metal_sale_order_detail = $this->model_metal_sale_order_detail->create($metalSaleOrderDetailObj);
            }

            DB::commit();
        } catch (Exception $e) {

            DB::rollback();
            throw $e;
        }
        return true;
    }

    public function getById($id)
    {
        return $this->model_metal_sale_order->getModel()::with('customer_name')->find($id);
    }
    public function getMetalSaleOrderByCustomerId($customer_id)
    {
        return $this->model_metal_sale_order->getModel()::with('customer_name')
            ->where('is_deleted', 0)
            ->where('customer_id',$customer_id)
            ->where('is_complete',0)
            ->get();
    }
    public function metalSaleOrderDetail($metal_sale_order_id)
    {
        $metal_sale_order_detail = $this->model_metal_sale_order_detail->getModel()::with('product')
        ->where('metal_sale_order_id', $metal_sale_order_id)
            ->where('is_deleted', 0)->get();

        $data = [];
        foreach ($metal_sale_order_detail as $item) {
            $data[] = [
                "product_id" => $item->product_id ?? '',
                "product_name" => $item->product->name ?? '',
                "category" => $item->category ?? '',
                "design_no" => $item->design_no ?? '',
                "metal" => $item->metal ?? '',
                "rate" => $item->rate ?? '',
                "purity" => $item->purity ?? '',
                "net_weight" => $item->net_weight ?? 0.000,
                "waste" => $item->waste ?? 0.000,
                "gross_weight" => $item->gross_weight ?? 0.000,
                "description" => $item->description ?? ''
            ];
        }

        return $data;
    }


    public function deleteById($metal_sale_order_id)
    {
        try {
            DB::beginTransaction();

            $metal_sale_order = $this->model_metal_sale_order->getModel()::find($metal_sale_order_id);

            // sale update
            $metal_sale_order->is_deleted = 1;
            $metal_sale_order->deletedby_id = Auth::user()->id;
            $metal_sale_order->update();

            DB::commit();
        } catch (Exception $e) {

            DB::rollback();
            throw $e;
        }
        return true;
    }

    public function getByWarehouseId($warehouse_id)
    {
        return $this->model_metal_sale_order->getModel()::where('warehouse_id', $warehouse_id)
        ->where('is_saled',0)->where('is_complete',0)
            ->where('is_deleted', 0)->get();
    }

}
