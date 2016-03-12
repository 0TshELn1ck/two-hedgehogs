<?php
/**
 * Created by PhpStorm.
 * User: hibro
 * Date: 11.03.16
 * Time: 23:35
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Cart;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DishController
 * @Route("/cart")
 */
class CartController extends Controller
{
    /**
     * @Route("/check", name="cartCheck")
     */
    public function getCartAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        if ($user){
            $cart = $em->getRepository("AppBundle:Cart")->findBy(array('user'=>$user->getId()));

            if (!$cart){
                $cart = new Cart();
                $cart->setIp($request->getClientIp());
                $em->persist($cart);
                $em->flush();
            }

        } else {
            $cart = $em->getRepository("AppBundle:Cart")->findOneBy(array('ip'=>$request->getClientIp()));

            if (!$cart){
                $cart = new Cart();
                $cart->setIp($request->getClientIp());
                $em->persist($cart);
                $em->flush();
            }
        }

        return new Response(
            count($cart->getDishes())
        );
    }

}