<?php

namespace App\Enum;

enum PaymentProcessorsEnum: string
{
    case Paypal = 'paypal';
    case Stripe = 'stripe';

    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
