<?php

namespace App\Service\CalculatePriceStrategies;

use App\Dto\CalculatePriceOutputDto;
use App\Entity\Coupon;
use App\Entity\Product;
use App\Entity\Tax;
use App\Service\CalculatePriceStrategies\Contract\AbstractStrategy;
use App\Service\CalculatePriceStrategies\Contract\StrategyInterface;
use App\Value\AddPercentValue;
use App\Value\PriceValue;
use Symfony\Component\VarExporter\Exception\ExceptionInterface;
use Symfony\Component\VarExporter\Hydrator;
use Symfony\Component\VarExporter\Instantiator;

class NoDiscountStrategy extends AbstractStrategy
{

    /**
     * @return CalculatePriceOutputDto
     * @throws ExceptionInterface
     */
    public function handle(): CalculatePriceOutputDto
    {
        $price = new PriceValue($this->product->getPrice());
        $taxedPrice = new AddPercentValue($price->getValue(), $this->tax->getRate());

        return Instantiator::instantiate(CalculatePriceOutputDto::class, [
            'price' => $price->getValue(),
            'taxRate' => $this->tax->getRate(),
            'couponValue' => 0,
            'couponType' => null,
            'finalPrice' => $taxedPrice->getValue(),
        ]);
    }
}
