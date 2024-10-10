<?php

namespace App\Services\Concrete;

use App\Models\FinishProduct;
use App\Models\RattiKaat;
use App\Models\Sale;
use App\Repository\Repository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CommonService
{
      protected $model_ratti_kaat;
      protected $model_finish_product;
      public function __construct()
      {
            // set the model
            $this->model_ratti_kaat = new Repository(new RattiKaat);
            $this->model_finish_product = new Repository(new FinishProduct);
      }

      public function generateRattiKaatNo()
      {
            $ratti_kaat = RattiKaat::orderby('id', 'desc')->first();

            if (!$ratti_kaat) {
                  return "RK-" . date('dmY') . "-0001";
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

      public function generateSaleNo()
      {
            $sale = Sale::orderby('id', 'desc')->first();

            if (!$sale) {
                  return "SL-" . date('dmY') . "-0001";
            }

            $mystring = $sale->sale_no;

            $mystring = substr($mystring, strrpos($mystring, "-") + 1);

            $mystring += 1;

            $lenZero = "";

            for ($i = 1; $i <= 4  - strlen($mystring); $i += 1) {
                  $lenZero = "0" . $lenZero;
            }

            $mystring = $lenZero . $mystring;

            return "SL-" . date('dmY') . "-" . $mystring;
      }

      public function generateFinishProductTagNo($prefix)
      {
            do {
                  $randomNumber = $prefix . mt_rand(10000, 99999);

                  $exists = DB::table('finish_products')->where('tag_no', $randomNumber)->exists();
            } while ($exists);

            return $randomNumber;
      }
}
