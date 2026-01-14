<?php

namespace App\DataFixtures;

use App\Dto\CouponDto;
use App\Entity\Coupon;
use App\Enum\CouponTypesEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CouponFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $coupons = [
            new CouponDto('P20', 20, CouponTypesEnum::TypePercent),
            new CouponDto('P50', 50, CouponTypesEnum::TypePercent),
            new CouponDto('P10', 10, CouponTypesEnum::TypePercent),
            new CouponDto('F80', 800, CouponTypesEnum::TypeFixed),
            new CouponDto('F1000', 1000, CouponTypesEnum::TypeFixed),
        ];

        foreach ($coupons as $couponData) {
            $coupon = new Coupon();
            $coupon->setCode($couponData->code);
            $coupon->setValue($couponData->value);
            $coupon->setType($couponData->type);
            $manager->persist($coupon);
        }

        $manager->flush();
    }
}
