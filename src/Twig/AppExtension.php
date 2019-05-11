<?php

namespace App\Twig;

use App\Services\CartManager;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    private $cartManager;

    public function __construct(CartManager $cartManager)
    {
        $this->cartManager = $cartManager;
    }

    public function getFilters()
    {
        return array(
            new TwigFilter('getQtyProducts', array($this, 'getQtyProducts'))
        );
    }

    public function getQtyProducts()
    {
        return $this->cartManager->getQtyProducts();
    }
}