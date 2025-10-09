<?php

namespace App\Services\Concrete;

use App\Models\JournalEntry;
use App\Models\Retainer;
use App\Repository\Repository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Services\Concrete\JournalEntryService;
use Yajra\DataTables\Facades\DataTables;

class RetainerService
{
      protected $model_retainer;
      protected $journal_entry_service;
      public function __construct()
      {
            // set the model
            $this->model_retainer = new Repository(new Retainer);
            $this->journal_entry_service = new JournalEntryService();
      }
      //Other Product
      public function getSource()
      {
            $model = $this->model_retainer->getModel()::with([
                  'journal',
                  'debit_account',
                  'credit_account',
                  'jv',
                  'created_by'
            ])->orderBy('created_at', 'DESC')->get();
            $data = DataTables::of($model)
                  ->addColumn('is_active', function ($item) {
                        // if (Auth::user()->can('retainer_status')) {
                        if ($item->is_active == 1) {
                              $status = '<label class="switch pr-5 switch-primary mr-3"><input type="checkbox" checked="checked" id="status" data-id="' . $item->id . '"><span class="slider"></span></label>';
                        } else {
                              $status = '<label class="switch pr-5 switch-primary mr-3"><input type="checkbox" id="status" data-id="' . $item->id . '"><span class="slider"></span></label>';
                        }
                        return $status;
                        // } else {
                        //       return 'N/A';
                        // }
                  })
                  ->addColumn('status', function ($item) {
                        $disabled = $item->status == 'confirmed' ? 'disabled' : '';
                        $dropdown = '<select id="status" style="width:150px;" class="form-control" data-id="' . $item->id . '" ' . $disabled . '>';
                        if ($item->status == 'pending') {
                              $dropdown .= '<option value="pending" selected>Pending</option>';
                              $dropdown .= '<option value="confirmed">Confirmed</option>';
                        } else {
                              $dropdown .= '<option value="pending">Pending</option>';
                              $dropdown .= '<option value="confirmed" selected>Confirmed</option>';
                        }
                        $dropdown .= '</select>';
                        return $dropdown;
                  })
                  ->addColumn('currency', function ($item) {
                        return $item->currency == 0 ? 'PKR' : ($item->currency == 1 ? 'Gold (AU)' : 'Dollar ($)');
                  })
                  ->addColumn('journal', function ($item) {
                        return $item->journal->name ?? '';
                  })
                  ->addColumn('debit_account', function ($item) {
                        return $item->debit_account->name ?? '';
                  })
                  ->addColumn('credit_account', function ($item) {
                        return $item->credit_account->name ?? '';
                  })
                  ->addColumn('jv', function ($item) {
                        return $item->jv->entryNum ?? '';
                  })
                  ->addColumn('created_by', function ($item) {
                        return $item->created_by->name ?? '';
                  })
                  ->addColumn('created_at', function ($item) {
                        return $item->created_at->format('d-m-Y g:i A');
                  })
                  ->addColumn('action', function ($item) {
                        $action_column = '';
                        // $edit_column    = "<a class='text-success mr-2' id='editRetainer' href='javascript:void(0)' data-toggle='tooltip'  data-id='" . $item->id . "' data-original-title='Edit'><i title='Add' class='nav-icon mr-2 fa fa-edit'></i>Edit</a>";
                        $delete_column    = "<a class='text-danger mr-2' id='deleteRetainer' href='javascript:void(0)' data-toggle='tooltip'  data-id='" . $item->id . "' data-original-title='delete'><i title='Delete' class='nav-icon mr-2 fa fa-trash'></i>Delete</a>";
                        // if (Auth::user()->can('retainer_edit'))
                        //       $action_column .= $edit_column;
                        // if (Auth::user()->can('retainer_delete'))
                        $action_column .= $delete_column;

                        return $action_column;
                  })
                  ->rawColumns([
                        'is_active',
                        'created_at',
                        'currency',
                        'journal',
                        'debit_account',
                        'credit_account',
                        'jv',
                        'created_by',
                        'action',
                        'status'
                  ])
                  ->make(true);
            return $data;
      }
      // save 
      public function save($obj)
      {

            $obj['createdby_id'] = Auth::User()->id;

            $saved_obj = $this->model_retainer->create($obj);

            if (!$saved_obj)
                  return false;

            return $saved_obj;
      }

      // update
      public function update($obj)
      {

            $obj['updatedby_id'] = Auth::User()->id;
            $this->model_retainer->update($obj, $obj['id']);
            $saved_obj = $this->model_retainer->find($obj['id']);

            if (!$saved_obj)
                  return false;

            return $saved_obj;
      }

      // get by id
      public function getById($id)
      {
            $retainer = $this->model_retainer->getModel()::find($id);

            if (!$retainer)
                  return false;

            return $retainer;
      }
      // status by id
      public function activeById($id)
      {
            $retainer = $this->model_retainer->getModel()::find($id);
            if ($retainer->is_active == 0) {
                  $retainer->is_active = 1;
            } else {
                  $retainer->is_active = 0;
            }
            $retainer->updatedby_id = Auth::user()->id;
            $retainer->update();

            if ($retainer)
                  return true;

            return false;
      }
      // delete by id
      public function deleteById($id)
      {
            $retainer = $this->model_retainer->getModel()::find($id);
            $retainer->delete();

            if (!$retainer)
                  return false;

            return $retainer;
      }

      //status change
      public function status($obj)
      {
            $retainer = $this->model_retainer->getModel()::find($obj['id']);
            if ($obj['status'] == 'confirmed') {
                  $payment_date = date("Y-m-d", strtotime(str_replace('/', '-', Carbon::now())));
                  $data = [
                        "date" => $payment_date,
                        "prefix" => $retainer->journal->prefix,
                        "journal_id" => $retainer->journal->id
                  ];
                  $entryNum = $this->journal_entry_service->generateJournalEntryNum($data);

                  $journal_entry = new JournalEntry();
                  $journal_entry->journal_id = $retainer->journal_id;
                  $journal_entry->date_post = now();
                  $journal_entry->reference = 'Automatically Created for Retainer: ' . $retainer->title ?? '';
                  $journal_entry->entryNum = $entryNum;
                  $journal_entry->createdby_id = 1;
                  $journal_entry->save();
                  $amount = str_replace(',', '', $retainer->amount ?? 0);
                  //for debit
                  $this->journal_entry_service->saveJVDetail(
                        $retainer->currency, // currency 0 for PKR, 1 for AU, 2 for Dollar
                        $journal_entry->id, // journal entry id
                        'Retainer Debit Entry', //explaination
                        $retainer->id, //bill no
                        0, // check no or 0
                        $payment_date, //check date
                        1, // is credit flag 0 for credit, 1 for debit
                        $amount, //amount
                        $retainer->debit_account->id, // account id
                        $retainer->debit_account->code, // account code
                        1 //created by id
                  );

                  //for credit
                  $this->journal_entry_service->saveJVDetail(
                        $retainer->currency, // currency 0 for PKR, 1 for AU, 2 for Dollar
                        $journal_entry->id, // journal entry id
                        'Retainer Credit Entry', //explaination
                        $retainer->id, //bill no
                        0, // check no or 0
                        $payment_date, //check date
                        0, // is credit flag 0 for credit, 1 for debit
                        $amount, //amount
                        $retainer->credit_account->id, // account id
                        $retainer->credit_account->code, // account code
                        1 //created by id
                  );

                  // Update retainer status to confirm
                  $retainer->update([
                        'status' => 'confirmed',
                        'confirmed_at' => now(),
                        'confirmed_by' => 1,
                        'jv_id' => $journal_entry->id ?? null,
                  ]);
                  return $journal_entry;
            } else {
                  return true;
            }
      }
}
