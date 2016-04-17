<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 11.04.16
 * Time: 20:34
 */

namespace AppBundle\Services;

use AppBundle\Entity\Cart;
use AppBundle\Entity\Order;
use AppBundle\Entity\User;
use Symfony\Bridge\Doctrine\RegistryInterface;


class OrderService
{
    private $em;
    private $user;

    public function __construct(RegistryInterface $doctrine, $security)
    {
        $this->em = $doctrine->getManager();
        $this->user = $security->getToken()->getUser();
    }

    /**
     * Get count of product in the cart
     *
     * @return mixed
     */
    public function getCart()
    {
        $user = $this->user;
        
        if ($user instanceof User){
            $cart = $this->em->getRepository("AppBundle:Cart")->findOneBy(array('user' => $user->getId()));

            if (!$cart) {
                $cart = new Cart();
                $cart->setUser($user);
                $this->em->persist($cart);
                $this->em->flush();
            }
        
            return count($cart->getDishes());

        } else {
            return 0;
        }
    }

    /**
     * Add product in cart
     * 
     * @return mixed
     */
    public function addToCart($dish)
    {
        $user = $this->user;

        if ($user instanceof User) {
            $cart = $user->getCart();
            $dishInCart = $cart->getDishes();

            if (!$dishInCart->contains($dish)) {
                $cart->addDish($dish);
                $this->em->flush();

                return true;
            }
        }

        return false;
    }

    /**
     * Delete dish from cart
     * 
     * @param $dish
     * @return bool
     */
    public function dellFromCart($dish)
    {
        $user = $this->user;

        if ($user instanceof User) {
            $cart = $user->getCart();
            $dishInCart = $cart->getDishes();

            if ($dishInCart->contains($dish)) {
                $cart->removeDish($dish);
                $this->em->flush();

                return true;
            }
        }

        return false;
    }

    /**
     * Get summ of order
     *
     * @param $order
     * @return int
     */
    public function getSumm(Order $order)
    {
        $summ = 0;
        
        foreach ($order->getDishesInOrder() as $dishInOrder) {
            $price = $dishInOrder->getDish()->getPrice();
            $summ = $summ + ($price * $dishInOrder->getCount());
        }

        return $summ;
    }
    
    

}