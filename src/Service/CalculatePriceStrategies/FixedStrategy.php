<?php
declare(strict_types=1);
namespace App\Service\CalculatePriceStrategies;

use App\Dto\CalculatePriceOutputDto;
use App\Service\CalculatePriceStrategies\Contract\AbstractStrategy;
use App\Service\Exception\CalculatePriceException;
use App\Value\AddPercentValue;
use App\Value\PriceValue;
use Symfony\Component\VarExporter\Exception\ExceptionInterface;
use Symfony\Component\VarExporter\Instantiator;

final class FixedStrategy extends AbstractStrategy
{
    /**
     * @return CalculatePriceOutputDto
     * @throws CalculatePriceException
     * @throws ExceptionInterface
     */
    public function handle(): CalculatePriceOutputDto
    {
        $price = new PriceValue($this->product->getPrice());
        $taxedPrice = new AddPercentValue($price->getValue(), $this->tax->getRate());
        $couponValue = new PriceValue($this->coupon->getValue());
        $finalPrice = $taxedPrice->getValue() - $couponValue->getValue();


        if ($finalPrice <= 0) {
            throw new CalculatePriceException("The price of the item is less than or equal to zero.");
        }

        return Instantiator::instantiate(CalculatePriceOutputDto::class, [
            'price' => $price->getValue(),
            'taxRate' => $this->tax->getRate(),
            'couponValue' => $this->coupon->getValue(),
            'couponType' => $this->coupon->getType(),
            'finalPrice' => $finalPrice
        ]);
    }
}
