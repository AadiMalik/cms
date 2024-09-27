<?php

namespace App\Http\Controllers;

use App\Services\Concrete\GoldRateService;
use App\Traits\JsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GoldRateController extends Controller
{
    use JsonResponse;
    protected $gold_rate_service;


    public function __construct(
        GoldRateService $gold_rate_service
    ) {
        $this->gold_rate_service = $gold_rate_service;
    }

    public function index()
    {
        $gold_rate = $this->gold_rate_service->recentGoldRate();
        $gold = 100;
        $impurity = 0;
        $ratti = 96;
        $ratti_impurity = 0;
        $rate = $gold_rate->rate;
        $rate_gram = $gold_rate->rate / 11.664;

        $gold_array = [];
        $impurity_array = [];
        $ratti_array = [];
        $rate_array = [];
        $rate_gram_array = [];
        for ($i = 24; $i > 0; $i--) {
            if ($i == 24) {
                $gold_array[] = $gold;
                $impurity_array[] = $impurity;
                $ratti_array[] = $ratti;
                $rate_array[] = $rate;
                $rate_gram_array[] = $rate_gram;
            } else {
                $gold = ($gold / $i) * ($i - 1);
                $gold = ($gold / $i) * ($i - 1);
            }

            $gold_array[] = $gold;
            $impurity_array[] = $impurity;
            $ratti_array[] = $ratti;
            $rate_array[] = $rate;
            $rate_gram_array[] = $rate_gram;
        }
    }


    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'gold_rate' => 'required'
            ],
            $this->validationMessage()
        );

        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {

            $obj = [
                'rate_tola' => $request->gold_rate,
                'rate_gram' => $request->gold_rate/11.664,
                'createdby_id' => Auth::user()->id
            ];
            $response = $this->gold_rate_service->save($obj);
            if (!$response)
                return redirect()->back()->with('error', config('enum.error'));


            return redirect()->back()->with('success', config('enum.updated'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', config('enum.error'));
        }
    }

    // Dollar Rate
    public function dollarLog(){

    }
    public function storeDollar(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'dollar_rate' => 'required'
            ],
            $this->validationMessage()
        );

        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {

            $obj = [
                'rate' => $request->dollar_rate,
                'createdby_id' => Auth::user()->id
            ];
            $response = $this->gold_rate_service->saveDollarRate($obj);
            if (!$response)
                return redirect()->back()->with('error', config('enum.error'));


            return redirect()->back()->with('success', config('enum.updated'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', config('enum.error'));
        }
    }
}
