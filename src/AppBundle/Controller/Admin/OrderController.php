<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class OrderController
 * @Route("/admin/order")
 */
class OrderController extends Controller
{
    /**
     * Count of new order
     * @Route("/count", name="get_order_count")
     */
    public function getOrderCountAction()
    {
        $em = $this->getDoctrine()->getManager();
        $orders = $em->getRepository('AppBundle:Order')->findBy(array('status'=>'processing'));
        
        return new Response(count($orders));
    }
    
    /**
     * Get new order by ajax
     * @Route("/processing", name="get_processing_orders")
     * @Method("POST")
     * @Template("AppBundle:Admin/Modals:orders.html.twig")
     */
    public function getProcessingOrders()
    {
        $em = $this->getDoctrine()->getManager();
        $orders = $em->getRepository('AppBundle:Order')
                     ->findBy(array('status'=>'processing'), array('cookTo'=>'ASC'));
        
        return ['orders' => $orders];
    }
}