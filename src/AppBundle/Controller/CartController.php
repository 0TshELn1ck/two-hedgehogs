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
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $count_dish = 0;

        if ($user) {
            $cart = $em->getRepository("AppBundle:Cart")->findOneBy(array('user' => $user->getId()));

            if (!$cart) {
                $cart = new Cart();
                $cart->setUser($user);
                $em->persist($cart);
                $em->flush();
            }

            $count_dish = count($cart->getDishes());
        }

        return new Response(
            $count_dish
        );
    }

    /**
     * Ajax adding to cart route
     * @Route("/add/{dish}", name="addToCart")
     * @Method("POST")
     */
    public function addToCartAction(Request $request, Dish $dish = null)
    {
        $response = new JsonResponse();
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        if ($user) {
            $cart = $user->getCart();
            $dishInCart = $cart->getDishes();

            if (!$dishInCart->contains($dish)) {
                $cart->addDish($dish);
                $em->flush();
                $response->setData(array('added' => 1));
            }
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
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        if ($user instanceof User) {
            $cart = $user->getCart();
            $dishInCart = $cart->getDishes();

            if ($dishInCart->contains($dish)) {
                $cart->removeDish($dish);
                $em->flush();
                $response->setData(array('deleted' => 1));
            }
        }

        return $response;
    }

}