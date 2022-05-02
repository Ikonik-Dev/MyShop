<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart_index')]
    
    // CartService recuperé grace à l'autowiring
    public function index(CartService $cartService): Response
    {
        // on stock une instance de ce service dans une variable $cart
        $cart = $cartService->get();

        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
            'cart' => $cart
        ]);
    }

    #[Route('/cart/add/{id}', name: 'app_cart_add')]
    // CartService recuperé grace à l'autowiring et en secon parametre le param converter pour les produits
    public function add(CartService $cartService, Product $product): Response
    {
        // on instancie le service et on lui attribut la methode add
        $cartService->add($product);


        return $this->redirectToRoute('app_cart_index');
    }

    #[Route('/cart/remove/{id}', name: 'app_cart_remove')]
    // CartService recuperé grace à l'autowiring et en secon parametre le param converter pour les produits
    public function remove(CartService $cartService, Product $product): Response
    {
        // on instancie le service et on lui attribut la methode remove
        $cartService->remove($product);


        return $this->redirectToRoute('app_cart_index');
    }

    #[Route('/cart/clear', name: 'app_cart_clear')]
    // CartService recuperé grace à l'autowiring et en secon parametre le param converter pour les produits
    public function clear(CartService $cartService): Response
    {
        // on instancie le service et on lui attribut la methode clear
        $cartService->clear();


        return $this->redirectToRoute('app_cart_index');
    }
}
