<?php

namespace App\Services\Concrete;

use App\Models\FinishProduct;
use App\Models\FinishProductBead;
use App\Models\FinishProductDiamond;
use App\Models\FinishProductStone;
use App\Models\JournalEntry;
use App\Models\Product;
use App\Models\RattiKaatDetail;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\SaleDetailBead;
use App\Models\SaleDetailDiamond;
use App\Models\SaleDetailStone;
use App\Repository\Repository;
use Illuminate\Support\Facades\Auth;

class ReportService
{
      protected $model_product;
      protected $model_journal_entry;
      protected $model_finish_product;
      protected $model_finish_product_bead;
      protected $model_finish_product_stone;
      protected $model_finish_product_diamond;
      protected $model_sale;
      protected $model_sale_detail;
      protected $model_sale_detail_bead;
      protected $model_sale_detail_stone;
      protected $model_sale_detail_diamond;
      public function __construct()
      {
            // set the model
            $this->model_product = new Repository(new Product);
            $this->model_journal_entry = new Repository(new JournalEntry);
            $this->model_finish_product = new Repository(new FinishProduct);
            $this->model_finish_product_bead = new Repository(new FinishProductBead);
            $this->model_finish_product_stone = new Repository(new FinishProductStone);
            $this->model_finish_product_diamond = new Repository(new FinishProductDiamond);
            $this->model_sale = new Repository(new Sale);
            $this->model_sale_detail = new Repository(new SaleDetail);
            $this->model_sale_detail_bead = new Repository(new SaleDetailBead);
            $this->model_sale_detail_stone = new Repository(new SaleDetailStone);
            $this->model_sale_detail_diamond = new Repository(new SaleDetailDiamond);
      }

      // Ledger Report
      public function ledgerReport($obj)
      {
            $opening_balance = [];
            $wh = [];
            $whIn = [];
            if (isset($obj['supplier_id']) && $obj['supplier_id'] != 0 && $obj['supplier_id'] != "") {
                  $wh[] = ['journal_entries.supplier_id', '=', $obj['supplier_id']];
            }
            if (isset($obj['customer_id']) && $obj['customer_id'] != 0 && $obj['customer_id'] != "") {
                  $wh[] = ['journal_entries.customer_id', '=', $obj['customer_id']];
            }
            if (isset($obj['currency']) && $obj['currency'] != "") {
                  $wh[] = ['journal_entry_details.currency', '=', $obj['currency']];
            }
            if (isset($obj['account_id']) && $obj['account_id'] != 0 && $obj['account_id'] != "") {
                  $journal_entry = $this->model_journal_entry->getModel()::with(['supplier_name', 'customer_name', 'journal_name'])
                        ->where('journal_entries.date_post', '>=', date("Y-m-d", strtotime(str_replace('/', '-', $obj['start_date']))))
                        ->where('journal_entries.date_post', '<=', date("Y-m-d", strtotime(str_replace('/', '-', $obj['end_date']))))
                        ->join('journal_entry_details', 'journal_entry_details.journal_entry_id', 'journal_entries.id')
                        ->join('accounts', 'journal_entry_details.account_id', 'accounts.id')
                        ->whereIn('journal_entry_details.account_id', $obj['account_id'])
                        ->where($wh)
                        ->where('journal_entries.is_deleted', 0)
                        ->orderBy('journal_entries.date_post', 'ASC')
                        ->orderBy('journal_entry_details.journal_entry_id', 'ASC')
                        ->get();
                  $opening_balance = $this->model_journal_entry->getModel()::with(['supplier_name', 'customer_name', 'journal_name'])
                        ->where('journal_entries.date_post', '<', date("Y-m-d", strtotime(str_replace('/', '-', $obj['start_date']))))
                        ->join('journal_entry_details', 'journal_entry_details.journal_entry_id', 'journal_entries.id')
                        ->whereIn('journal_entry_details.account_id', $obj['account_id'])
                        ->where($wh)
                        ->where('journal_entries.is_deleted', 0)
                        ->orderBy('journal_entries.date_post', 'ASC')
                        ->orderBy('journal_entry_details.journal_entry_id', 'ASC')
                        ->get();
                  return [
                        "journal_entry" => $journal_entry,
                        "opening_balance" => $opening_balance
                  ];
            } else {
                  $journal_entry = $this->model_journal_entry->getModel()::with(['supplier_name', 'customer_name', 'journal_name'])
                        ->where('journal_entries.date_post', '>=', date("Y-m-d", strtotime(str_replace('/', '-', $obj['start_date']))))
                        ->where('journal_entries.date_post', '<=', date("Y-m-d", strtotime(str_replace('/', '-', $obj['end_date']))))
                        ->join('journal_entry_details', 'journal_entry_details.journal_entry_id', 'journal_entries.id')
                        ->join('accounts', 'journal_entry_details.account_id', 'accounts.id')
                        ->where($wh)
                        ->where('journal_entries.is_deleted', 0)
                        ->orderBy('journal_entries.date_post', 'ASC')
                        ->orderBy('journal_entry_details.journal_entry_id', 'ASC')
                        ->get();
                  $opening_balance = $this->model_journal_entry->getModel()::with(['supplier_name', 'customer_name', 'journal_name'])
                        ->where('journal_entries.date_post', '<', date("Y-m-d", strtotime(str_replace('/', '-', $obj['start_date']))))
                        ->join('journal_entry_details', 'journal_entry_details.journal_entry_id', 'journal_entries.id')
                        ->where($wh)
                        ->where('journal_entries.is_deleted', 0)
                        ->orderBy('journal_entries.date_post', 'ASC')
                        ->orderBy('journal_entry_details.journal_entry_id', 'ASC')
                        ->get();
                  return [
                        "journal_entry" => $journal_entry,
                        "opening_balance" => $opening_balance
                  ];
            }
      }

      // Tag History Report
      public function tagHistoryReport($obj)
      {
            $finish_products = $this->model_finish_product->getModel()::with(
                  [
                        'product',
                        'warehouse',
                        'created_by'
                  ]
            )
                  ->where('created_at', '>=', date("Y-m-d", strtotime(str_replace('/', '-', $obj['start_date']))))
                  ->where('created_at', '<=', date("Y-m-d", strtotime(str_replace('/', '-', $obj['end_date']))))
                  ->where('is_deleted', 0)
                  ->orderBy('created_at', 'ASC')
                  ->get();
            $data = [];
            foreach ($finish_products as $item) {
                  $data[] = [
                        "product_name" => $item->product->name ?? '',
                        "tag_no" => $item->tag_no ?? '',
                        "scale_weight" => $item->scale_weight ?? 0,
                        "gross_weight" => $item->gross_weight ?? 0,
                        "bead_weight" => $item->bead_weight ?? 0,
                        "total_bead_price" => $item->total_bead_price ?? 0,
                        "stones_weight" => $item->stones_weight ?? 0,
                        "total_stones_price" => $item->total_stones_price ?? 0,
                        "diamond_weight" => $item->diamond_weight ?? 0,
                        "total_diamond_price" => $item->total_diamond_price ?? 0,
                        "waste" => $item->waste ?? 0,
                        "quantity" => 1,
                        "createdby" => $item->created_by->name ?? '',
                        "date_time" => $item->created_at->format('d M Y h:i:s A'),
                        "f_beads" => $this->model_finish_product_bead->getModel()::where('finish_product_id', $item->id)->where('is_deleted', 0)->get(),
                        "f_stones" => $this->model_finish_product_stone->getModel()::where('finish_product_id', $item->id)->where('is_deleted', 0)->get(),
                        "f_diamonds" => $this->model_finish_product_diamond->getModel()::where('finish_product_id', $item->id)->where('is_deleted', 0)->get(),
                        "sale_detail" => $this->model_sale_detail->getModel()::with('sale')->where('finish_product_id', $item->id)->where('is_deleted', 0)->first(),
                  ];
            }
            return $data;
      }
}
