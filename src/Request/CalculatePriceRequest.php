<?php

namespace App\Request;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator as CustomAssert;

class CalculatePriceRequest extends Contract\AbstractRequest
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

    /**
     * @inheritDoc
     */
    public static function fromHttpRequest(Request $request): static
    {
        $self = new static();
        $self->product = $request->getPayload()->get('product');
        $self->couponCode = $request->getPayload()->get('couponCode');
        $self->taxNumber = $request->getPayload()->get('taxNumber');
        return $self;
    }
}
