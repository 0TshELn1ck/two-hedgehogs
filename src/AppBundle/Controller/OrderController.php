<?php
namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DishController
 * @Route("/order")
 */
class OrderController extends Controller
{
    /**
     * @Route("/", name="cart")
     * @Template("AppBundle:Front:order.html.twig")
     */
    public function getCartAction(Request $request)
    {
        $user = $this->getUser();

        if ($user instanceof User){
            $cart = $user->getCart();

            return [
                'dishes'=>$cart->getDishes(),
                'cart'=>$cart,
            ];
        }

        return $this->redirect($this->generateUrl('user_login'));
    }
}