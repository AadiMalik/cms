<?php

namespace App\Http\Controllers;

use App\Services\Concrete\AccountService;
use App\Services\Concrete\CustomerService;
use App\Traits\JsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CustomerController extends Controller
{
    use JsonResponse;
    protected $customer_service;
    protected $account_service;


    public function __construct(
        CustomerService $customer_service,
        AccountService $account_service
    ) {
        $this->customer_service = $customer_service;
        $this->account_service = $account_service;
    }

    public function index()
    {
        abort_if(Gate::denies('customers_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('customers.index');
    }


    public function getData(Request $request)
    {
        abort_if(Gate::denies('customers_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return $this->customer_service->getCustomerSource();
    }

    public function create()
    {
        abort_if(Gate::denies('customers_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $accounts = $this->account_service->getAllActiveChild();
        return view('customers.create', compact('accounts'));
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('customers_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            if ($request->id == null) {
                $validator = Validator::make($request->all(), [
                    'name' => ['required', 'string', 'max:191'],
                    'cnic' => ['required', 'string'],
                    'contact' => ['required', 'string'],
                    'cnic_images' => ['required', 'array', 'min:3'],
                    'cnic_images.*' => ['mimes:jpg,jpeg,png,bmp', 'max:2048']
                ]);
            } else {
                $validator = Validator::make($request->all(), [
                    'cnic_images.*' => ['mimes:jpg,jpeg,png,bmp','max:2048']
                ]);
            }

            if ($validator->fails()) {

                return redirect()->back()->withErrors($validator)->withInput();
            }

            $obj = $request->all();
            $imagePaths = [];

            if ($request->hasFile('cnic_images')) {
                foreach ($request->file('cnic_images') as $image) {
                    $fileName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('cnic_images'), $fileName);
                    $imagePaths[] = 'cnic_images/' . $fileName;
                }
                $obj['cnic_images'] = json_encode($imagePaths);
            }
            $customer = $this->customer_service->save($obj);

            if (!$customer)
                return redirect()->back()->with('error', config('enum.error'));


            return redirect('customers')->with('success', config('enum.saved'));
        } catch (Exception $e) {
            return redirect()->back()->with('error',  $e->getMessage());
        }
    }

    public function edit($id)
    {
        abort_if(Gate::denies('customers_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $customer = $this->customer_service->getById($id);
        $accounts = $this->account_service->getAllActiveChild();
        return view('customers.create', compact('customer', 'accounts'));
    }


    public function status($id)
    {
        abort_if(Gate::denies('customers_status'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $customer = $this->customer_service->statusById($id);

            if ($customer)
                return $this->success(
                    config('enum.status'),
                    []

                );
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function destroy($id)
    {
        abort_if(Gate::denies('customers_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $customer = $this->customer_service->deleteById($id);

            if ($customer)
                return $this->success(
                    config('enum.delete'),
                    []

                );
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
