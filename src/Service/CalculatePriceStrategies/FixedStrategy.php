<?php
declare(strict_types=1);
namespace App\Service\CalculatePriceStrategies;

use App\Dto\CalculatePriceOutput;
use App\Service\CalculatePriceStrategies\Contract\AbstractStrategy;
use App\Service\Exceptions\CalculatePriceException;
use App\Value\AddPercentValue;
use App\Value\PriceValue;
use Symfony\Component\VarExporter\Exception\ExceptionInterface;
use Symfony\Component\VarExporter\Instantiator;

class FixedStrategy extends AbstractStrategy
{
    /**
     * @return CalculatePriceOutput
     * @throws CalculatePriceException
     * @throws ExceptionInterface
     */
    public function handle(): CalculatePriceOutput
    {
        if ((int) $this->product->getPrice() <= 0) {
            throw new CalculatePriceException("The price of the item is less than or equal to zero.");
        }

        $price = new PriceValue($this->product->getPrice());
        $taxedPrice = new AddPercentValue($price->getValue(), $this->tax->getRate());
        $couponValue = new PriceValue($this->coupon->getValue());
        $finalPrice = $taxedPrice->getValue() - $couponValue->getValue();

        return Instantiator::instantiate(CalculatePriceOutput::class, [
            'price' => $price->getValue(),
            'taxRate' => $this->tax->getRate(),
            'couponValue' => $this->coupon->getValue(),
            'couponType' => $this->coupon->getType(),
            'finalPrice' => $finalPrice
        ]);
    }
}
