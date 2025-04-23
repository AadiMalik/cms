<?php

namespace App\Services\Concrete;

use App\Models\DiamondTransaction;
use App\Repository\Repository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DiamondStockService
{
      protected $model_diamond_stock;
      public function __construct()
      {
            // set the model
            $this->model_diamond_stock = new Repository(new DiamondTransaction);
      }
      //Bead type
      public function getSource()
      {
            $model = DB::table('diamond_transactions as dt')
                  ->join('diamond_types as t', 'dt.diamond_type_id', '=', 't.id')
                  ->join('diamond_cuts as c', 'dt.diamond_cut_id', '=', 'c.id')
                  ->join('diamond_colors as col', 'dt.diamond_color_id', '=', 'col.id')
                  ->join('diamond_clarities as cl', 'dt.diamond_clarity_id', '=', 'cl.id')
                  ->join('warehouses as w', 'dt.warehouse_id', '=', 'w.id')
                  ->select(
                        'dt.diamond_type_id',
                        'dt.diamond_cut_id',
                        'dt.diamond_color_id',
                        'dt.diamond_clarity_id',
                        'dt.warehouse_id',
                        't.name as diamond_type',
                        'c.name as diamond_cut',
                        'col.name as diamond_color',
                        'cl.name as diamond_clarity',
                        'w.name as warehouse',
                        DB::raw("SUM(CASE WHEN dt.type = 0 THEN dt.qty ELSE -dt.qty END) as total_qty"),
                        DB::raw("SUM(CASE WHEN dt.type = 0 THEN dt.carat ELSE -dt.carat END) as total_carat")
                  )
                  ->where('dt.is_deleted', 0)
                  ->groupBy(
                        'dt.diamond_type_id',
                        'dt.diamond_cut_id',
                        'dt.diamond_color_id',
                        'dt.diamond_clarity_id',
                        'dt.warehouse_id',
                        't.name',
                        'c.name',
                        'col.name',
                        'cl.name',
                        'w.name'
                  );

            $data = DataTables::of($model)
                  ->addColumn('action', function ($item) {
                        $action_column = 'N/A';
                        // $delete_column = "<a class='text-danger mr-2' id='deleteStockType' href='javascript:void(0)' data-toggle='tooltip'  data-id='" . $item->id . "' data-original-title='delete'><i title='Delete' class='nav-icon mr-2 fa fa-trash'></i>Delete</a>";
                        // if (Auth::user()->can('diamond_stock_delete'))
                        //       $action_column .= $delete_column;
                        return $action_column;
                  })
                  ->rawColumns(['action'])
                  ->make(true);

            return $data;
      }
}
