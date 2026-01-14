<?php

namespace App\Service;

use App\Dto\CalculatePriceOutput;
use App\Enum\PaymentProcessorsEnum;
use App\Service\Exceptions\PurchaseException;
use Exception;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

readonly class PurchaseScenario
{
    /**
     * @throws PurchaseException
     */
    public function handle(CalculatePriceOutput $input, string $paymentProcessor): bool
    {
        switch (true) {
            case $paymentProcessor === PaymentProcessorsEnum::Paypal->value:
                $payPalProcess = new PaypalPaymentProcessor();
                try {
                    $payPalProcess->pay($input->finalPrice);
                } catch (Exception $e) {
                    throw new PurchaseException($e->getMessage());
                }
                return true;
            case $paymentProcessor === PaymentProcessorsEnum::Stripe->value:
                $stripeProcess = new StripePaymentProcessor();
                return $stripeProcess->processPayment($input->finalPrice);
            default:
                throw new PurchaseException('Unknown payment processor');
        }
    }
}
