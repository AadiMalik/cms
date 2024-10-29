<?php

namespace App\Services\Concrete;

use App\Models\OtherProduct;
use App\Repository\Repository;
use App\Models\Transaction;
use App\Models\Warehouse;
use Carbon\Carbon;
use Exception;
use Yajra\DataTables\DataTables;

class StockService
{
    // initialize protected model variables
    protected $model_transaction;
    protected $model_warehouse;
    protected $model_other_product;

    protected $common_service;
    public function __construct()
    {
        // set the model
        $this->model_transaction = new Repository(new Transaction);
        $this->model_warehouse = new Repository(new Warehouse);
        $this->model_other_product = new Repository(new OtherProduct);

        $this->common_service = new CommonService();
    }

    public function getSource($obj)
    {
        $warehouse = $this->model_warehouse->getModel()::find($obj['warehouse_id']);
        $other_products = $this->model_other_product->getModel()::with('other_product_unit')
            ->where('is_deleted', 0)
            ->orderBy('name', 'ASC')
            ->get();
        $model = [];
        foreach ($other_products as $item) {
            $stock = $this->common_service->getOtherProductStockWithWarehouse(
                $item->id, // product id
                $obj['warehouse_id'], // warehouse id
                null, // start date/ null
                null // end date /null
            );
            $model[] = [
                "id" => $item->id,
                "name" => $item->name ?? '',
                "unit" => $item->other_product_unit->name ?? '',
                "warehouse" => $warehouse->name ?? '',
                "stock" => $stock ?? 0
            ];
        }
        $data = DataTables::of($model)->make(true);
        return $data;
    }
}
