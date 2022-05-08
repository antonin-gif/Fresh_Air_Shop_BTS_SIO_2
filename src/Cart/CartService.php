<?php

namespace App\Cart;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{

    protected $session;
    protected $productRepository;

    public function __construct(RequestStack $requestStack, ProductRepository $productRepository)
    {
        $this->session = $requestStack;
        $this->productRepository = $productRepository;
    }

    public function add(int $id)
    {
        //1. retrouver le panier dans la session (sous forme de tableau)
        // 2. si panier n'existe pas, prendre un tableau vide

        $session = $this->session->getSession();

        //dd($session);

        $cart = $session->get('cart', []);

        //[12 =>, 29 =>2]

        //3. voir si le produit (id) existe deja dans le tableau
        //4 si c'est le cas, augmenter la qtité
        //5 sinon, ajouter le produit avec la qtité 1
        if (array_key_exists($id, $cart)) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        // dd($cart);

        //6. enregistrer le tableau mis à jour dans la session
        $session->set('cart', $cart);
    }

    public function remove(int $id)
    {
        $session = $this->session->getSession();
        $cart = $session->get('cart', []);

        unset($cart[$id]);

        $session->set('cart', $cart);
    }

    public function decrement(int $id)
    {
        $session = $this->session->getSession();

        $cart = $session->get('cart', []);

        if (!array_key_exists($id, $cart)) {
            return;
        }

        // si produit est à 1 -> on le supprimer
        if ($cart[$id] === 1) {
            $this->remove($id);
        }

        // si produit est à plus de 1, on le décrémente
        $cart[$id]--;
        $session->set('cart', $cart);
    }

    public function getTotal(): int
    {

        $session = $this->session->getSession();

        $total = 0;

        foreach ($session->get('cart', []) as $id => $qty) {
            $product = $this->productRepository->find($id);

            if (!$product) {
                continue;
            }

            $total += $product->getPrice() * $qty;
        };
        return $total;
    }

    public function getDetailedCartItems(): array
    {

        $session = $this->session->getSession();


        $detailedCart = [];

        foreach ($session->get('cart', []) as $id => $qty) {
            $product = $this->productRepository->find($id);

            if (!$product) {
                continue;
            }

            $detailedCart[] = new CartItem($product, $qty);
        };
        return $detailedCart;
    }
}
