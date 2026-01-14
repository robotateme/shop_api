<?php

namespace App\Tests;

use App\Dto\CalculatePriceInputDto;
use App\Entity\Coupon;
use App\Entity\Product;
use App\Entity\Tax;
use App\Enum\CouponTypesEnum;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;
use App\Repository\TaxRepository;
use App\Service\CalculatePriceScenario;
use App\Service\Exceptions\CalculatePriceException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\VarExporter\Exception\ExceptionInterface;
use Symfony\Component\VarExporter\Hydrator;

class CalculatePriceScenarioTest extends TestCase
{
    public static function additionProvider(): array
    {
        return [
//            [12000, 20, 20, CouponTypesEnum::TypePercent, 115.20],
//            [12000, 20, 20, CouponTypesEnum::TypeFixed, 143.80],
//            [12000, 20, 20, CouponTypesEnum::TypeDefault, 144],
//            [10000, 10000, 20, CouponTypesEnum::TypeFixed, 20.0],
            [10000, 10000, 0, CouponTypesEnum::TypeFixed, 20.0],
        ];
    }

    /**115.20
     * @throws CalculatePriceException
     * @throws Exception
     * @throws ExceptionInterface
     */
    #[DataProvider('additionProvider')]
    public function testCalculate(
        int $price,
        int $percent,
        int $taxRate,
        CouponTypesEnum $couponType,
        float $expectedPrice): void
    {
        $dto = Hydrator::hydrate(new CalculatePriceInputDto, [
            'product' => 1,
            'couponCode' => 'P20',
            'taxNumber' => 'FRAN123456789',
        ]);

        $product = new Product();
        $product->setPrice($price)
            ->setTitle('Product#1');

        $coupon = new Coupon();
        $coupon->setCode('P20');
        $coupon->setType($couponType);
        $coupon->setValue($percent);

        $tax = new Tax();
        $tax->setNumber('FRAN123456789');
        $tax->setRate($taxRate);

        $productRepository = $this->createMock(ProductRepository::class);
        $productRepository->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn($product);

        $taxRepository = $this->createMock(TaxRepository::class);
        $taxRepository->expects($this->once())
            ->method('findOneBy')
            ->with(['number' => 'FRAN123456789'])
            ->willReturn($tax);

        $couponRepository = $this->createMock(CouponRepository::class);
        $couponRepository->expects($this->once())
            ->method('findOneBy')
            ->with(['code' => 'P20'])
            ->willReturn($coupon);

        $service = new CalculatePriceScenario(
            $productRepository,
            $couponRepository,
            $taxRepository
        );

        if($taxRate <= 0) {
            $this->expectException(CalculatePriceException::class);
        }

        $resultDto = $service->handle($dto);
        $this->assertEquals($expectedPrice, $resultDto->finalPrice);
    }
}
