<?php

namespace App\Dto;

final class TaxDto
{
    public function __construct(public string $number, public int $rate)
    {
    }
}
