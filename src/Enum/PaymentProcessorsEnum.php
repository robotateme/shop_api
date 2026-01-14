<?php

namespace App\Enum;

enum PaymentProcessorsEnum: string
{
    case Paypal = 'paypal';
    case Stripe = 'stripe';
}
