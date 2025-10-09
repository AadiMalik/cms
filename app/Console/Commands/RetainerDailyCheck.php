<?php

namespace App\Console\Commands;

use App\Models\Journal;
use App\Models\JournalEntry;
use App\Models\Notification;
use App\Models\Retainer;
use App\Services\Concrete\JournalEntryService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RetainerDailyCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'retainer:daily-check';
    protected $description = 'Check retainers daily, send notification or auto-create JV if needed';

    protected $journal_entry_service;
    public function __construct(JournalEntryService $journal_entry_service)
    {
        parent::__construct();
        $this->journal_entry_service = $journal_entry_service;
    }
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        // ✅ 1. Send new notifications if day matches
        $this->sendRetainerNotifications($today);

        // ✅ 2. Auto-create JV for unconfirmed retainers from yesterday
        $this->autoCreateJVForPending($yesterday);

        $this->info('Retainer daily check completed successfully.');
    }

    protected function sendRetainerNotifications($today)
    {
        $retainers = Retainer::whereDay('day', $today->day)
            ->get();

        foreach ($retainers as $retainer) {
            // Skip if already notified today
            if ($retainer->notification_at && Carbon::parse($retainer->notification_at)->isSameDay($today)) {
                continue;
            }

            // Create notification (Universal notification system)
            Notification::create([
                'title' => 'Retainer Confirmation Needed',
                'message' => 'Please confirm the retainer for ' . $retainer->name,
                'user_id' => $retainer->createdby_id,
                'play_sound' => 1,
            ]);

            // Update retainer notification date and set status to pending
            $retainer->update([
                'status' => 'pending',
                'notification_at' => now(),
            ]);
        }
    }
    protected function autoCreateJVForPending($yesterday)
    {
        $pendingRetainers = Retainer::with([
            'journal',
            'debit_account',
            'credit_account'
        ])->whereDay('day', $yesterday->day)
            ->where('status', 'pending')
            ->get();

        foreach ($pendingRetainers as $retainer) {
            DB::transaction(function () use ($retainer) {
                // Create JV entry
                $payment_date = date("Y-m-d", strtotime(str_replace('/', '-', Carbon::now())));
                $data = [
                    "date" => $payment_date,
                    "prefix" => $retainer->journal->prefix,
                    "journal_id" => $retainer->journal->id
                ];
                $entryNum = $this->journal_entry_service->generateJournalEntryNum($data);

                $journal_entry = new JournalEntry;
                $journal_entry->journal_id = $retainer->journal_id;
                $journal_entry->date_post = now();
                $journal_entry->reference = 'Automatically Created for Retainer: ' . $retainer->name;
                $journal_entry->entryNum = $entryNum;
                $journal_entry->createdby_id = 1;
                $journal_entry->save();
                $amount = str_replace(',', '', $retainer->amount ?? 0);
                //for debit
                $this->journal_entry_service->saveJVDetail(
                    $retainer->currency, // currency 0 for PKR, 1 for AU, 2 for Dollar
                    $journal_entry->id, // journal entry id
                    'Retainer Debit Entry', //explaination
                    '', //bill no
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
                    '', //bill no
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
                    'last_jv_id' => $journal_entry->id ?? null,
                ]);
            });
        }
    }
}
