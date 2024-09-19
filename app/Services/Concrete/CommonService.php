<?php

namespace App\Services\Concrete;

use App\Models\RattiKaat;
use App\Repository\Repository;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CommonService
{
    protected $model_ratti_kaat;
    public function __construct()
    {
        // set the model
        $this->model_ratti_kaat = new Repository(new RattiKaat);
    }

    public function generateRattiKaatNo()
      {
            $ratti_kaat = RattiKaat::orderby('id', 'desc')->first();

            if (!$ratti_kaat) {
                  return "RK-". date('dmY') . "-0001";
            }

            $mystring = $ratti_kaat->ratti_kaat_no;

            $mystring = substr($mystring, strrpos($mystring, "-") + 1);

            $mystring += 1;

            $lenZero = "";

            for ($i = 1; $i <= 4  - strlen($mystring); $i += 1) {
                  $lenZero = "0" . $lenZero;
            }

            $mystring = $lenZero . $mystring;

            return "RK-" . date('dmY') . "-" . $mystring;
      }
}
