<?php

namespace AppBundle\Controller;

use AppBundle\Entity\DishInOrder;

use AppBundle\Entity\Order;
use AppBundle\Form\OrderType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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

        if ($user) {
            $em = $this->getDoctrine()->getManager();
            $cart = $user->getCart();
            if ($cart->getDishes()->count() > 0) {
                $order = new Order();
                $address = $em->getRepository("AppBundle:Order")->getLastUserAddress($user->getId(), 3);

                foreach ($cart->getDishes() as $dish) {
                    $dishInOrder = new DishInOrder();
                    $dishInOrder->setDish($dish)
                                ->setOrder($order);
                }

                $form = $this->createForm(OrderType::class, $order);

                if ($request->getMethod() === 'POST') {
                    $form->handleRequest($request);
                    $summ = $this->get('hedgehogs.order')->getSumm($order);
                    $order->setUser($user)
                          ->setSumm($summ);

                    $cart->getDishes()->clear();
                    $em->persist($order);
                    $em->persist($cart);
                    $em->flush();

                    return $this->redirectToRoute('user_orders');
                }

                return [
                    'dishes' => $cart->getDishes(),
                    'cart' => $cart,
                    'form' => $form->createView(),
                    'addresses' => $address,
                ];
            } else {
                return ['massage' => 'Ви не додали жодного блюда з меню собі в замовлення',];
            }
        }

        return $this->redirectToRoute('fos_user_security_login');
    }
}