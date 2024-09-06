<?php

namespace App\Http\Controllers;

use App\Services\Concrete\JournalService;
use App\Traits\JsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JournalController extends Controller
{
    use JsonResponse;
    protected $journal_service;

    public function __construct(JournalService $journal_service)
    {
        $this->journal_service = $journal_service;
    }

    public function index(Request $request)
    {
            return view('journal.index');
    }

    public function getData()
    {
        try {
            return $this->journal_service->getJournalSource();
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }
    
    public function store(Request $request)
    {

        $validation = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'prefix' => 'required|max:3'
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
                    'name' => $request->name,
                    'prefix' => $request->prefix
                ];
                $response = $this->journal_service->updateJournal($obj);
                return  $this->success(
                    config("enum.updated"),
                    $response
                );
            } else {
                $obj = [
                    'name' => $request->name,
                    'prefix' => $request->prefix
                ];
                $response = $this->journal_service->saveJournal($obj);
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
        try {
            return  $this->success(
                config('enum.success'),
                $this->journal_service->getJournalById($id),
                false
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    public function status($id)
    {
        try {
            $journal = $this->journal_service->statusById($id);
            return $this->success(
                config("enum.status"),
                $journal,
                true
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }

    public function destroy($id)
    {
        try {
            $journal = $this->journal_service->deleteJournalById($id);
            return $this->success(
                config("enum.delete"),
                $journal,
                true
            );
        } catch (Exception $e) {
            return $this->error(config('enum.error'));
        }
    }
}
