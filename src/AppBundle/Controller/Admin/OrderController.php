<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class OrderController
 * @Route("/admin/order")
 */
class OrderController extends Controller
{
    /**
     * Count of new order
     * @Route("/count", name="getOrderCount")
     */
    public function getOrderCountAction()
    {
        $em = $this->getDoctrine()->getManager();
        $orders = $em->getRepository('AppBundle:Order')->findBy(array('status'=>'processing'));
        
        return new Response(count($orders));
    }
}