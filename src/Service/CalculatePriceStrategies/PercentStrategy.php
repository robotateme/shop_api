<?php
declare(strict_types=1);
namespace App\Service\CalculatePriceStrategies;

use App\Dto\CalculatePriceOutput;
use App\Service\CalculatePriceStrategies\Contract\AbstractStrategy;
use App\Value\AddPercentValue;
use App\Value\PriceValue;
use App\Value\SubPercentValue;
use Symfony\Component\VarExporter\Exception\ExceptionInterface;
use Symfony\Component\VarExporter\Instantiator;

final class PercentStrategy extends AbstractStrategy
{
    /**
     * @return CalculatePriceOutput
     * @throws ExceptionInterface
     */
    public function handle(): CalculatePriceOutput
    {
        $price = new PriceValue($this->product->getPrice())->getValue();
        $taxedPrice = new AddPercentValue($price, $this->tax->getRate())->getValue();
        $discountPrice = new SubPercentValue($taxedPrice, $this->coupon->getValue())->getValue();

        return Instantiator::instantiate(CalculatePriceOutput::class, [
            'price' => $price,
            'taxRate' => $this->tax->getRate(),
            'couponValue' => $this->coupon->getValue(),
            'couponType' => $this->coupon->getType(),
            'finalPrice' => $discountPrice
        ]);
    }
}
