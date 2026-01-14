<?php
declare(strict_types=1);

namespace App\Value;

use BcMath\Number;

final readonly class AddPercentValue
{
    private float $value;

    public function __construct(
        int|float $value,
        int $percent
    )
    {
        $value = new Number((string) $value);
        $percent = new Number($percent);
        $this->value = (float) $value->mul($percent->div(100)
            ->add(1))
            ->round(2)->value;
    }

    public function getValue(): float
    {
        return $this->value;
    }
}
