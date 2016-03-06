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
     * @Route("/list", name="list_dish")
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dishList = $em->getRepository('AppBundle:Dish')->getDishes();

        return $this->render('@App/Dish/listDishes.html.twig', ['dishList' => $dishList]);
    }
    /**
     * @Route("/{slug}", name="show_one_dish")
     */
    public function showOneAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $dish = $em->getRepository('AppBundle:Dish')->getOneDish($slug);

        return $this->render('@App/Dish/showOneDish.html.twig', ['dish' => $dish]);
    }
}