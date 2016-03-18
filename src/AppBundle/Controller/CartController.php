<?php
/**
 * Created by PhpStorm.
 * User: hibro
 * Date: 11.03.16
 * Time: 23:35
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Cart;
use AppBundle\Entity\User;
use AppBundle\Entity\Dish;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DishController
 * @Route("/cart")
 */
class CartController extends Controller
{
    /**
     * @Route("/", name="cart")
     * @Template("AppBundle:Front:order.html.twig")
     */
    public function getCartAction()
    {
        $user = $this->getUser();

        if ($user instanceof User){
            $cart = $user->getCart();

            return [
                'cart'=>$cart
            ];
        }

        return $this->redirect($this->generateUrl('user_login'));
    }

    /**
     * @Route("/check", name="cartCheck")
     */
    public function getCartCheckAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $count_dish = 0;

        if ($user instanceof User){
            $cart = $em->getRepository("AppBundle:Cart")->findOneBy(array('user'=>$user->getId()));

            if (!$cart){
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
    public function addToCartAction(Request $request, Dish $dish=null)
    {
        $response = new JsonResponse();
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        if ($user instanceof User) {
            $cart = $em->getRepository("AppBundle:Cart")->findOneBy(array('user' => $user->getId()));
            $dishInCart = $cart->getDishes();

            if (!$dishInCart->contains($dish)){
                $cart->addDish($dish);
                $em->persist($cart);
                $em->flush();
                $response->setData(array('added' => 1));

                return $response;
            }
        }
        $response->setData(array('added' => 0));

        return $response;
    }

}