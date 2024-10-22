<?php

namespace App\Services\Concrete;

use App\Models\JournalEntry;
use App\Models\Product;
use App\Repository\Repository;
use Illuminate\Support\Facades\Auth;

class ReportService
{
      protected $model_product;
      protected $model_journal_entry;
      public function __construct()
      {
            // set the model
            $this->model_product = new Repository(new Product);
            $this->model_journal_entry = new Repository(new JournalEntry);
      }

      // Ledger Report
      public function ledgerReport($obj)
      {
            $opening_balance = [];
            $wh = [];
            $whIn = [];
            if (isset($obj['vendor_id']) && $obj['vendor_id'] != 0 && $obj['vendor_id'] != "") {
                  $wh[] = ['journal_entries.vendor_id', '=', $obj['vendor_id']];
            }
            if (isset($obj['project_id']) && $obj['project_id'] != 0 && $obj['project_id'] != "") {
                  $wh[] = ['journal_entries.project_id', '=', $obj['project_id']];
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
                  $opening_balance = JournalEntry::with(['supplier_name', 'customer_name', 'journal_name'])
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
                  $opening_balance = JournalEntry::with(['supplier_name', 'customer_name', 'journal_name'])
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
}
