<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Dish;
use AppBundle\Form\DishAddType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DishController
 * @Route("/dish")
 */
class DishController extends Controller
{
    /**
     * @Route("/list", name="listDish")
     */
    public function listIndex(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dishList = $em->getRepository('AppBundle:Dish')->getDishes();
        $msg = "";

        return $this->render('@App/listDishes.html.twig', ['dishList' => $dishList,
            'msg' => $msg]);
    }
    /**
     * @Route("/{slug}", name="showOneDish")
     */
    public function showOneIndex(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dishList = $em->getRepository('AppBundle:Dish')->getDishes();
        $msg = "";

        return $this->render('@App/listDishes.html.twig', ['dishList' => $dishList,
            'msg' => $msg]);
    }
}