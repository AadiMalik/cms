<?php

use App\Services\Concrete\GoldRateService;
use App\Services\Concrete\UserService;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Switch_;

function getRoleName()
{
      return Auth::User()->roles[0]->name;
}
function Admins()
{
      $user_service = new UserService();
      return $user_service->getAdminIdsOnly();
}

function GoldRate(){
    $gold_rate_service = new GoldRateService();

    return $gold_rate_service->recentGoldRate();
}

function DollarRate(){
    $gold_rate_service = new GoldRateService();

    return $gold_rate_service->recentDollarRate();
}

function Currency($currency_type_id){
    switch ($currency_type_id) {
        case 0:
            $currency = 'PKR';
            break;
        case 1:
            $currency = 'AU';
            break;
        case 2:
            $currency = '$';
            break;
        default:
            $currency = 'Unknown';
    }
    return $currency;
}