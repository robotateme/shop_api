<?php
declare(strict_types=1);
namespace App\Dto;

use App\Enum\PaymentProcessorsEnum;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator as CustomAssert;

final class CalculatePriceInputDto
{
    #[Assert\NotBlank]
    #[Assert\Type('integer')]
    #[Assert\Positive]
    public ?int $product = null;

    #[Assert\Type('string')]
    public ?string $couponCode;

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[CustomAssert\TaxNumber]
    public ?string $taxNumber = null;
}
