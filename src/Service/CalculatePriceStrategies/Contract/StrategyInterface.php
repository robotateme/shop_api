<?php

namespace App\Service\CalculatePriceStrategies\Contract;

use App\Entity\Coupon;
use App\Entity\Product;
use App\Entity\Tax;

interface StrategyInterface
{
    public function handle();

}
