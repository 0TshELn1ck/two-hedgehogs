<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Dish;
use AppBundle\Entity\DishInOrder;
use AppBundle\Entity\Order;
use AppBundle\Entity\User;
use AppBundle\Form\OrderStatusType;
use AppBundle\Form\OrderType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
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
     * @Route ("/{order}", name="admin_show_order",  requirements={"order": "\d+"})
     * @Template("AppBundle:Admin/Order:show.html.twig")
     */
    public function getOrderAction(Request $request, Order $order)
    {
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
     * @Route("/{status}", name="admin_orders")
     * @Template("AppBundle:Admin/Order:index.html.twig")
     */
    public function getOrdersAction(Request $request, $status = null)
    {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        if (!$status) {
            $orders = $em->getRepository("AppBundle:Order")->findBy(array(), array('cookTo' => 'DESC'));
        } else {
            $orders = $em->getRepository("AppBundle:Order")->findBy(array('status'=>$status), array('cookTo' => 'DESC'));
        }
        $pagination = $paginator->paginate($orders, $request->query->getInt('page', 1), 10);
        return ['orders' => $pagination, 'tableStyle'=>'manager'];

    }

    /**
     * Change order info only by admin
     *
     * @Route("/{order}/edit", name="admin_edit_order")
     * @Template("AppBundle:Admin/Order:edit.html.twig")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editOrderAction(Request $request, Order $order)
    {
        $form = $this->createForm(OrderType::class, $order);
        $em = $this->getDoctrine()->getManager();
        
        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $summ = $this->get('hedgehogs.order')->getSumm($order);
                $order->setSumm($summ);
                $em->persist($order);
                $em->flush();
            }
        }
        return [
            'order'=>$order,
            'form' => $form->createView(),
        ];
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
     * @Route("/modal/processing", name="get_processing_orders")
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
     * Get stats of order
     *
     * @Route("/modal/stats", name="get_order_stats")
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

    /**
     * Ajax deleting dish from order
     * 
     * @Route("/delete/{order}/{dish}", name="dellFromOrder")
     * @Method("POST")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function dellDishFromOrderAction(DishInOrder $dish = null, Order $order=null)
    {
        $response = new JsonResponse();
        $em = $this->getDoctrine()->getManager();

        if ($dish && $order){
            $dishes = $order->getDishesInOrder();
                
            if ($dishes->contains($dish)) {
                $em->remove($dish);
                $em->flush();
                
                if ($order->getDishesInOrder()->count() == 0){
                    $em->remove($order);
                } else {
                    $newDishes = $order->getDishesInOrder();
                    $summ = $this->get('hedgehogs.order')->getSumm($order);
                    $order->setSumm($summ);
                }
                $em->flush();
                
                return $response->setData(array('deleted' => 1));
            }
        }
   
        return $response->setData(array('deleted' => 0));
    }

}