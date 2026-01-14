<?php

namespace App\Enum;

enum CouponTypesEnum: string
{
    case TypeFixed = 'fixed';
    case TypePercent = 'percent';
    case TypeDefault = 'no-discount';
}
