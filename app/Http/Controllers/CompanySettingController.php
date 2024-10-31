<?php

namespace App\Http\Controllers;

use App\Services\Concrete\AccountService;
use App\Services\Concrete\CompanySettingService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanySettingController extends Controller
{
    protected $company_setting_service;
    protected $account_service;

    public function __construct(
        CompanySettingService $company_setting_service,
        AccountService $account_service
    ) {
        $this->company_setting_service = $company_setting_service;
        $this->account_service = $account_service;
    }
    public function index()
    {
        $company_setting = $this->company_setting_service->getSetting();
        $accounts = $this->account_service->getAllActiveChild();
        return view('company.setting', compact('company_setting','accounts'));
    }
    public function store(Request $request)
    {
        try {
            $obj = $request->all();
            $company_setting = $this->company_setting_service->save($obj);
            if (!$company_setting)
                return redirect()->back()->with('error', config('enum.error'));


            return redirect('company-setting')->with('success', config('enum.saved'));
        } catch (Exception $e) {
            return redirect()->back()->with('error',  $e->getMessage());
        }
    }
}
