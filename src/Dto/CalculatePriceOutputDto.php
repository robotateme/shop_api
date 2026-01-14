<?php
declare(strict_types=1);
namespace App\Dto;

use App\Enum\CouponTypesEnum;

final class CalculatePriceOutputDto
{
    public float $price;
    public float $taxRate;
    public float $finalPrice;
    public ?float $couponValue = null;
    public ?CouponTypesEnum $couponType = null;
}
