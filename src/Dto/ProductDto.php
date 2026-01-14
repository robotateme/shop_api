<?php

namespace App\Dto;

final class ProductDto
{
    public function __construct(public string $title, public float $price)
    {
    }
}
