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
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\VarExporter\Exception\ExceptionInterface;
use Symfony\Component\VarExporter\Hydrator;

class CalculatePriceScenarioTest extends TestCase
{
    /**
     * @throws CalculatePriceException
     * @throws Exception
     * @throws ExceptionInterface
     */
    public function testCalculate(): void
    {
        $dto = Hydrator::hydrate(new CalculatePriceInputDto, [
            'product' => 1,
            'couponCode' => 'P20',
            'taxNumber' => 'FRAN123456789',
        ]);

        $product = new Product();
        $product->setPrice(12000)
            ->setTitle('Product#1');

        $coupon = new Coupon();
        $coupon->setCode('P20');
        $coupon->setType(CouponTypesEnum::TypePercent);
        $coupon->setValue(20);

        $tax = new Tax();
        $tax->setNumber('FRAN123456789');
        $tax->setRate(20);

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

        $resultDto = $service->handle($dto);
        $this->assertEquals(115.20, $resultDto->finalPrice);
    }
}
