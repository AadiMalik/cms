<?php

use App\Services\Concrete\GoldRateService;

function GoldRate(){
    $gold_rate_service = new GoldRateService();

    return $gold_rate_service->recentGoldRate();
}

function DollarRate(){
    $gold_rate_service = new GoldRateService();

    return $gold_rate_service->recentDollarRate();
}