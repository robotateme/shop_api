<?php

namespace App\DataFixtures;

use App\Dto\ProductDto;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $products = [
            new ProductDto('IPhone', 10000),
            new ProductDto('Phones', 2000),
            new ProductDto('Phone case', 1000),
        ];

        foreach ($products as $productData) {
            $product = new Product();
            $product->setTitle($productData->title);
            $product->setPrice($productData->price);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
