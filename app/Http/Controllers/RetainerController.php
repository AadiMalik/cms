<?php

namespace App\Http\Controllers;

use App\Services\Concrete\AccountService;
use App\Services\Concrete\JournalService;
use App\Services\Concrete\RetainerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\JsonResponse;
use Exception;

class RetainerController extends Controller
{
    use JsonResponse;
    protected $retainer_service;
    protected $journal_service;
    protected $account_service;

    public function __construct(
        RetainerService $retainer_service,
        JournalService $journal_service,
        AccountService $account_service
    ) {
        $this->retainer_service = $retainer_service;
        $this->journal_service = $journal_service;
        $this->account_service = $account_service;
    }

    public function index(Request $request)
    {
        // abort_if(Gate::denies('retainer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $accounts = $this->account_service->getAllActiveChild();
        $journals = $this->journal_service->getAllJournal();
        return view('retainer.index', compact('accounts', 'journals'));
    }

    public function getData()
    {
        // abort_if(Gate::denies('retainer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            return $this->retainer_service->getSource();
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    public function store(Request $request)
    {

        // abort_if(Gate::denies('retainer_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $validation = Validator::make(
            $request->all(),
            [
                'title' => 'required|max:191',
                'day_of_month' => 'required|in:1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31',
                'journal_id' => 'required|exists:journals,id',
                'debit_account_id' => 'required|exists:accounts,id',
                'credit_account_id' => 'required|exists:accounts,id',
                'amount' => 'required',
                'currency' => 'required|in:0,1,2',
            ],
            $this->validationMessage()
        );

        if ($validation->fails()) {
            $validation_error = "";
            foreach ($validation->errors()->all() as $message) {
                $validation_error .= $message;
            }
            return $this->validationResponse(
                $validation_error
            );
        }
        try {
            if (isset($request->id)) {
                $obj = [
                    'id' => $request->id,
                    'title' => $request->title,
                    'day_of_month' => $request->day_of_month,
                    'journal_id' => $request->journal_id,
                    'debit_account_id' => $request->debit_account_id,
                    'credit_account_id' => $request->credit_account_id,
                    'amount' => $request->amount,
                    'currency' => $request->currency
                ];
                $response = $this->retainer_service->update($obj);
                return  $this->success(
                    config("enum.updated"),
                    $response
                );
            } else {
                $obj = [
                    'title' => $request->title,
                    'day_of_month' => $request->day_of_month,
                    'journal_id' => $request->journal_id,
                    'debit_account_id' => $request->debit_account_id,
                    'credit_account_id' => $request->credit_account_id,
                    'amount' => $request->amount,
                    'currency' => $request->currency
                ];
                $response = $this->retainer_service->save($obj);
                return  $this->success(
                    config("enum.saved"),
                    $response
                );
            }
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    public function edit($id)
    {
        // abort_if(Gate::denies('retainer_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            return  $this->success(
                config('enum.success'),
                $this->retainer_service->getById($id),
                false
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    public function active($id)
    {
        // abort_if(Gate::denies('retainer_active'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $retainer = $this->retainer_service->activeById($id);
            return $this->success(
                config("enum.status"),
                $retainer,
                true
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    public function destroy($id)
    {
        // abort_if(Gate::denies('retainer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $retainer = $this->retainer_service->deleteById($id);
            return $this->success(
                config("enum.delete"),
                $retainer,
                true
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }
    public function status(Request $request)
    {
        // abort_if(Gate::denies('retainer_status'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $obj = $request->all();
        try {
            $retainer = $this->retainer_service->status($obj);
            if ($retainer)
                return $this->success(
                    config('enum.success'),
                    [],
                    false

                );
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
