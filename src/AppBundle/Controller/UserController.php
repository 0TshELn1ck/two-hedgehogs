<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Order;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserController
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
     * @Route("/orders", name="userProfile")
     * @Template("AppBundle:Front:userOrders.html.twig")
     */
    public function profileAction(Request $request)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        
        if ($user){
            return [
                'orders'=>$em->getRepository('AppBundle:Order')->getSortableOrder($user->getId()),
            ];
        }
        
        return $this->redirectToRoute('homepage');
    }
    
    /**
     * @Route("/orders/delete/{order}", name="deleteOrderByUser")
     * @Method("POST")
     */
    public function deleteOrderAction(Request $request, Order $order = null)
    {
        $user = $this->getUser();
        $status = $order->getStatus();

        if ($user->getOrders()->contains($order)){
            if ($status == 'processing' || $status == 'closed' || $status == 'canceled') {
                $em = $this->getDoctrine()->getManager();
                $em->remove($order);
                $em->flush();
                return new JsonResponse(['success'=>'Успішно видалено']);
            }
            
            return new JsonResponse(['error'=>'Ви не можете видалити замовлення №'.$order->getId()]);
        }

        return new JsonResponse(['error'=>'Виникла помилка']);
    }
}