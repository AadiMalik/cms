<?php

namespace App\Http\Controllers;

use App\Services\Concrete\StockService;
use App\Services\Concrete\WarehouseService;
use App\Traits\JsonResponse;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class StockController extends Controller
{
    use JsonResponse;
    protected $stock_service;
    protected $warehouse_service;

    public function __construct(
        StockService $stock_service,
        WarehouseService $warehouse_service
    ) {
        $this->stock_service = $stock_service;
        $this->warehouse_service = $warehouse_service;
    }

    public function index(Request $request)
    {
        $warehouses = $this->warehouse_service->getAll();
        return view('stock.index', compact('warehouses'));
    }

    public function getData(Request $request)
    {
        try {
            $warehouse_id = $request['warehouse_id'] ?? '';
            $obj = [
                "warehouse_id" => $warehouse_id
            ];
            return $this->stock_service->getSource($obj);
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    public function getDetail(Request $request)
    {
        $obj = $request->all();
        $stock_detail = $this->stock_service->getStockDetail($obj);
        return $stock_detail;
    }
}
