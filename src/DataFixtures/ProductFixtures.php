<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    /**
     * Generate 12 products with random price.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 12; $i++) {
            $product = new Product();
            $product->setName('Product_' . $i);
            $product->setDescription('Product description ' . $i);

            // Get random float value between 0 and 100 with two decimals.
            $scale = pow(10, 2);
            $price = mt_rand(0, 100 * $scale) / $scale;
            $product->setPrice($price);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
