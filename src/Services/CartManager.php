<?php

namespace App\Services;

use App\Entity\CartItem;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartManager
{
    const CART_SESSION_NAME = "mycart";

    /** @var SessionInterface $session */
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * Get the current cart in session.
     *
     * @return mixed
     */
    public function getCart()
    {
        return $this->session->get(self::CART_SESSION_NAME, array());
    }

    /**
     * Set the current cart in session.
     *
     * @param array $newCart The new cart to store in session.
     */
    public function setCart($newCart)
    {
        $this->session->set(self::CART_SESSION_NAME, $newCart);
    }

    /**
     * Add a product if it does not exist in the cart. Otherwise, its quantity is updated.
     *
     * @param CartItem $cartItem The CartItem to add in the cart.
     */
    public function addItemToCart(CartItem $cartItem)
    {
        $cart = $this->getCart();
        if (array_key_exists($cartItem->getProductId(), $cart)) {
            $cart[$cartItem->getProductId()] += $cartItem->getQuantity();
        } else {
            $cart[$cartItem->getProductId()] = $cartItem->getQuantity();
        }
        $this->setCart($cart);
    }

    /**
     * Get the total number of products in the basket.
     *
     * @return int
     */
    public function getQtyProducts()
    {
        $cart = $this->getCart();
        $totalProducts = 0;
        foreach ($cart as $cartItem) {
            $totalProducts += $cartItem;
        }

        return $totalProducts;
    }
}