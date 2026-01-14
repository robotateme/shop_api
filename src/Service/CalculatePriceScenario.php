<?php
declare(strict_types=1);
namespace App\Service;

use App\Dto\CalculatePriceInputDto;
use App\Dto\CalculatePriceOutputDto;
use App\Dto\PurchaseInputDto;
use App\Enum\CouponTypesEnum;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;
use App\Repository\TaxRepository;
use App\Service\CalculatePriceStrategies\FixedStrategy;
use App\Service\CalculatePriceStrategies\NoDiscountStrategy;
use App\Service\CalculatePriceStrategies\PercentStrategy;
use App\Service\Exceptions\CalculatePriceException;
use Symfony\Component\VarExporter\Exception\ExceptionInterface;

readonly class CalculatePriceScenario
{
    public function __construct(
        private ProductRepository $productRepository,
        private CouponRepository  $couponRepository,
        private TaxRepository     $taxRepository,
    )
    {
    }

    /**
     * @throws CalculatePriceException
     * @throws ExceptionInterface
     */
    public function handle(CalculatePriceInputDto|PurchaseInputDto $input): CalculatePriceOutputDto
    {
        $product = $this->productRepository->find($input->product);
        if ($product === null) {
            throw new CalculatePriceException('Product not found');
        }

        $tax = $this->taxRepository->findOneBy(['number' => $input->taxNumber]);

        if ($tax === null) {
            throw new CalculatePriceException('Tax not found');
        }

        if (!is_null($input->couponCode)) {
            $coupon = $this->couponRepository->findOneBy(['code' => $input->couponCode]);
            if ($coupon === null) {
                throw new CalculatePriceException('Coupon not found');
            }

            switch (true) {
                case ($coupon->getType() === CouponTypesEnum::TypeFixed) :
                    return new FixedStrategy($product, $tax, $coupon)->handle();
                case ($coupon->getType() === CouponTypesEnum::TypePercent) :
                    return new PercentStrategy($product, $tax, $coupon)->handle();
            }
        }

        return new NoDiscountStrategy($product, $tax, $coupon ?? null)->handle();
    }

}
