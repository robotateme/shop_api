<?php
declare(strict_types=1);

namespace App\Service\CalculatePriceStrategies\Contract;

use App\Entity\Coupon;
use App\Entity\Product;
use App\Entity\Tax;
use App\Enum\CouponTypesEnum;
use BcMath\Number;

class AbstractStrategy implements StrategyInterface
{

    public function __construct(
        protected Product $product,
        protected ?Tax $tax,
        protected ?Coupon $coupon = null
    )
    {
    }

    public function handle()
    {
        // TODO: Implement handle() method.
    }
}
