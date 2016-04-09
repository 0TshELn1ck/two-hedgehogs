<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Order;
use AppBundle\Form\OrderStatusType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class OrderController
 * @Route("/admin/order")
 */
class OrderController extends Controller
{
    /**
     * Get single order
     *
     * @Route ("/{order}", name="admin_show_order")
     * @Template("AppBundle:Admin/Order:show.html.twig")
     */
    public function getOrder(Request $request, Order $order)
    {
        if (!$order){
            return ['error'=>'Такого замовлення не існує'];
        }

        $form = $this->createForm(OrderStatusType::class, $order);
        $em = $this->getDoctrine()->getManager();

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em->persist($order);
                $em->flush();
            }
        }

        return [
            'order' => $order,
            'form' => $form->createView(),
        ];
    }

    /**
     * Get orders for diferent roles
     *
     * @Route("/", name="admin_orders")
     * @Template("AppBundle:Admin/Order:index.html.twig")
     */
    public function getOrdersAction(Request $request)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');

        if ($user->hasRole('ROLE_ADMIN')){
            $orders = $em->getRepository("AppBundle:Order")->findBy(array(),array('cookTo'=>'DESC'));
            $pagination = $paginator->paginate($orders, $request->query->getInt('page', 1), 10);
            return ['orders' => $pagination, 'tableStyle'=>'manager'];
        }

        if ($user->hasRole('ROLE_COOK')){
            $orders = $em->getRepository("AppBundle:Order")->findBy(array('status'=>'confirmed'),array('cookTo'=>'DESC'));
            $pagination = $paginator->paginate($orders, $request->query->getInt('page', 1), 10);

            return ['orders' => $pagination, 'tableStyle'=>'cook'];
        }

        if ($user->hasRole('ROLE_CARRIER')){
            $orders = $em->getRepository("AppBundle:Order")->findBy(array('status'=>'cooked'),array('cookTo'=>'DESC'));
            $pagination = $paginator->paginate($orders, $request->query->getInt('page', 1), 10);

            return ['orders' => $pagination, 'tableStyle'=>'carrier'];
        }
        
        return ['error' => 'Нажаль Ви не маєте доступу'];
    }

    /**
     * Count of new order
     *
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
     *
     * @Route("/processing", name="get_processing_orders")
     * @Method("POST")
     * @Template("AppBundle:Admin/Modals:orders.html.twig")
     */
    public function getProcessingOrdersAction()
    {
        $em = $this->getDoctrine()->getManager();
        $orders = $em->getRepository('AppBundle:Order')
                     ->findBy(array('status'=>'processing'), array('cookTo'=>'ASC'));
        
        return ['orders' => $orders];
    }

    /**
     * Get stats by order status
     *
     * @Route("/stats", name="get_order_stats")
     * @Template("AppBundle:Admin/Modals:orderStats.html.twig")
     */
    public function getOrdersStatsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $orders = $em->getRepository("AppBundle:Order")->findBy(array('status'=>array('confirmed','processing', 'cooking', 'shipping')));
        
        $stats = [];
        foreach ($orders as $order){
            if (isset($stats[$order->getStatus()]['count'])){
                $stats[$order->getStatus()]['count']++;
            } else {
                $stats[$order->getStatus()]['count'] = 1;
            }
        }
        
        return [
                'stats'=>$stats,
                'orderCount'=> count($orders)
        ];
    }


}