<?php

namespace App\Controller;

use App\Entity\CartItem;
use App\Entity\Product;
use App\Form\AddItemType;
use App\Services\CartManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart.index")
     *
     * @param CartManager $cartManager The service to manage cart.
     *
     * @return Response;
     */
    public function index(CartManager $cartManager)
    {
        $cart = $cartManager->getCart();
        $cartItems = array();
        $total = 0;
        foreach ($cart as $productId => $quantity) {
            $product = $this->getDoctrine()->getRepository(Product::class)->find($productId);
            if (!empty($product)) {
                $cartItems[$productId] = [
                    'id'          => $productId,
                    'name'        => $product->getName(),
                    'description' => $product->getDescription(),
                    'price'       => $product->getPrice(),
                    'quantity'    => $quantity
                ];
                $total += $product->getPrice() * $quantity;
            }
        }

        return $this->render('cart/index.html.twig', [
            'cartItems' => $cartItems,
            'total'     => $total
        ]);
    }

    /**
     * Display the form to add a CartItem object in the cart.
     *
     * @param Product $product Product to add.
     *
     * @return Response
     */
    public function addItemForm(Product $product) : Response
    {
        $cartItem = new CartItem();
        $cartItem->setProductId($product->getId());

        $form = $this->createForm(AddItemType::class, $cartItem, [
            'action' => $this->generateUrl('cart.addItem'),
            'method' => 'POST'
        ]);

        return $this->render('cart/addItemForm.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/cart/addItem", name="cart.addItem", methods={"POST"})
     *
     * @param Request $request
     * @param CartManager $cartManager The service to manage cart.
     *
     * @return Response;
     */
    public function addItem(Request $request, CartManager $cartManager) : Response
    {
        $cartItem = new CartItem();
        $form = $this->createForm(AddItemType::class, $cartItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cartManager->addItemToCart($cartItem);
            $this->addFlash('success', 'The product has been added to your cart');
        }

        return $this->redirectToRoute('cart.index');
    }

    /**
     * @Route("/cart/clear", name="cart.clear")
     *
     * @param CartManager $cartManager The service to manage cart.
     *
     * @return Response
     */
    public function clearCart(CartManager $cartManager) : Response
    {
        $cartManager->setCart(array());
        $this->addFlash('success', 'Your cart is empty');

        return $this->redirectToRoute('cart.index');
    }
}
