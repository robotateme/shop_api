<?php

namespace App\Dto;

final class CalculatePriceInputDto
{
    /**
     * @var int
     */
    public int $product;
    /**
     * @var string|null
     */
    public ?string $couponCode = null;
    /**
     * @var string
     */
    public string $taxNumber;
}
