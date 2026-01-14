<?php
declare(strict_types=1);
namespace App\Value;

use BcMath\Number;

final readonly class PriceValue
{
    private float $value;
    public function __construct(int $value)
    {
        $this->value = (float) new Number($value)->div(100)->value;
    }

    public function getValue(): float
    {
        return $this->value;
    }
}
