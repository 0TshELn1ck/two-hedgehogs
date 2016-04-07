<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Dish;
use AppBundle\Form\DishAddType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DishController extends Controller
{
    /**
     * @Route("/dishes", name="list_dish")
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dishList = $em->getRepository('AppBundle:Dish')->getDishes();
        $categories = $em->getRepository('AppBundle:DishCategory')->getCategoriesActiveDishes();

        return $this->render('AppBundle:Front:menu.html.twig', ['dishList' => $dishList, 'categories' => $categories]);
    }

    /**
     * @Route("/dish/{slug}", name="show_one_dish")
     */
    public function showOneAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $dish = $em->getRepository('AppBundle:Dish')->getOneDish($slug);

        return $this->render('AppBundle:Front:dish.html.twig', ['dish' => $dish]);
    }
}