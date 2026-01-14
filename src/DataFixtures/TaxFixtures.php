<?php

namespace App\DataFixtures;

use App\Dto\TaxDto;
use App\Entity\Tax;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TaxFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $taxes = [
            new TaxDto('DE123456789', 19),
            new TaxDto('IT12345678900', 22),
            new TaxDto('GR123456789', 24),
            new TaxDto('FRAN123456789', 20),
        ];

        foreach ($taxes as $taxData) {
            $tax = new Tax();
            $tax->setNumber($taxData->number);
            $tax->setRate($taxData->rate);
            $manager->persist($tax);
        }

        $manager->flush();
    }
}
