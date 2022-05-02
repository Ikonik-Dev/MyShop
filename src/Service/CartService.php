<?php

// src/Service/CartService.php
namespace App\Service;

use App\Entity\Product;
use phpDocumentor\Reflection\Types\This;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService 
{
    // enregistrement dans l'objet session
    private $sessionInterface;

    public function __construct(SessionInterface $sessionInterface)
    {
        $this->sessionInterface = $sessionInterface;
    }
    // fonctionnalité de recuperation Panier par défaut
    public function get()
    {
        return $this->sessionInterface->get('cart', [
            'elements' => [],
            'total' => 0.0
        ]);
    }
    // fonctionnalité d'incrémentation de produits
    public function add(Product $product)
    {
        $cart = $this->get();
        $productId = $product->getId();

        // condition si panier vide et initialisation du produit
        if (!isset($cart['elements'][$productId])) 
        {
            $cart['elements'][$productId] = [
                'product' => $product,
                'quantity' => 0
            ];
        }
        // ajout
        $cart['total'] = $cart['total'] + $product->getPrice();
        $cart['elements'][$productId]['quantity'] = $cart['elements'][$productId]['quantity'] + 1;

        // enregistrement du panier
        $this->sessionInterface->set('cart', $cart);
    }

    public function remove(Product $product)
    {
        $cart = $this->get();
        $productId = $product->getId();

        if (!isset($cart['elements'][$productId])) 
        {
            return;
        }

        $cart['total'] = $cart['total'] - $product->getPrice();
        $cart['elements'][$productId]['quantity'] = $cart['elements'][$productId]['quantity'] - 1;

        if ($cart['elements'][$productId]['quantity'] <= 0) 
        {
            unset($cart['elements'][$productId]);
        }

        $this->sessionInterface->set('cart', $cart);

    }

    // nettoyage du panier
    public function clear()
    {
        $this->sessionInterface->remove('cart');
    }

}