<?php

namespace App\Dto;

use App\Enum\PaymentProcessorsEnum;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator as CustomAssert;

final class PurchaseInputDto
{
    #[Assert\Type('integer')]
    #[Assert\Positive]
    public ?int $product;

    #[Assert\Type('string')]
    public ?string $couponCode = null;

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[CustomAssert\TaxNumber]
    public ?string $taxNumber;

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[Assert\Choice(callback: [PaymentProcessorsEnum::class, 'getValues'])]
    public ?string $paymentProcessor = null;
}
