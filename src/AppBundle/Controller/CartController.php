<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cart;
use AppBundle\Entity\User;
use AppBundle\Entity\Dish;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class DishController
 * @Route("/cart")
 */
class CartController extends Controller
{
    /**
     * @Route("/check", name="cartCheck")
     */
    public function getCartCheckAction(Request $request)
    {
        return new Response($this->get('hedgehogs.order')->getCart());
    }

    /**
     * Ajax adding to cart route
     * @Route("/add/{dish}", name="addToCart")
     * @Method("POST")
     */
    public function addToCartAction(Request $request, Dish $dish = null)
    {
        $response = new JsonResponse();
        
        if ($this->get('hedgehogs.order')->addToCart($dish)){
            $response->setData(array('added' => 1));
        }

        return $response;
    }

    /**
     * Ajax deleting dish from cart
     * @Route("/delete/{dish}", name="dellFromCart")
     * @Method("POST")
     */
    public function dellFromCartAction(Dish $dish = null)
    {
        $response = new JsonResponse();
        
        if ($this->get('hedgehogs.order')->dellFromCart($dish)){
            $response->setData(array('deleted' => 1));
        }

        return $response;
    }

}