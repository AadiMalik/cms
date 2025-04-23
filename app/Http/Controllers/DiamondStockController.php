<?php

namespace App\Http\Controllers;

use App\Services\Concrete\DiamondStockService;
use App\Traits\JsonResponse;
use Exception;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class DiamondStockController extends Controller
{
    use JsonResponse;
    protected $diamond_stock_service;

    public function __construct(DiamondStockService $diamond_stock_service)
    {
        $this->diamond_stock_service = $diamond_stock_service;
    }

    public function index()
    {
        abort_if(Gate::denies('diamond_stock_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('diamond_stock.index');
    }

    public function getData()
    {
        abort_if(Gate::denies('diamond_stock_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            return $this->diamond_stock_service->getSource();
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }
}
