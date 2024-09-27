<?php

namespace App\Services\Concrete;

use App\Models\DollarRate;
use App\Models\GoldRate;
use App\Repository\Repository;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class GoldRateService
{
    // initialize protected model variables
    protected $model_gold_rate;
    protected $model_dollar_rate;

    public function __construct()
    {
        // set the model
        $this->model_gold_rate = new Repository(new GoldRate);
        $this->model_dollar_rate = new Repository(new DollarRate);
    }

    public function recentGoldRate(){
        return $this->model_gold_rate->getModel()::orderBy('created_at','DESC')->first();
    }

    public function getGoldRateSource()
    {
        $model = $this->model_gold_rate->getModel()::orderBy('created_at','DESC');
        $data = DataTables::of($model)->make(true);
        return $data;
    }

    public function save($obj)
    {
        $saved_obj = $this->model_gold_rate->create($obj);

        if (!$saved_obj)
            return false;

        return $saved_obj;
    }

    // Dollar rate
    public function recentDollarRate(){
        return $this->model_dollar_rate->getModel()::orderBy('created_at','DESC')->first();
    }

    public function saveDollarRate($obj)
    {
        $saved_obj = $this->model_dollar_rate->create($obj);

        if (!$saved_obj)
            return false;

        return $saved_obj;
    }
}
