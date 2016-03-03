<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Dish;
use AppBundle\Form\DishType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DishController
 * @Route("/admin/dish")
 */
class DishController extends Controller
{
    /**
     * @Route("/", name="adm_dish_index")
     */
    public function indexAction()
    {
        return $this->render('@App/Admin/Dish/indexDish.html.twig');
    }
    /**
     * @Route("/add", name="adm_add_dish")
     */
    public function addAction(Request $request)
    {
        $dish = new Dish();

        $form = $this->createForm(DishType::class, $dish);
        $msg ="";

        $form->handleRequest($request);
        if ($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($dish);
            $em->flush();
            $msg ="New dish successfully added";
        }

        return $this->render('@App/Admin/Dish/addDish.html.twig', ['form' => $form->createView(),
            'msg' => $msg]);
    }

    /**
     * @Route("/list", name="adm_list_dish")
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dishList = $em->getRepository('AppBundle:Dish')->getDishes();

        return $this->render('@App/Admin/Dish/admListDishes.html.twig', ['dishList' => $dishList]);
    }

    /**
     * @Route("/modify/{id}", name="adm_mod_dish")
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dishList = $em->getRepository('AppBundle:Dish')->find($id);
        $msg ="";

        $form = $this->createForm(DishType::class, $dishList);

        $form->handleRequest($request);
        if ($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $msg ="Dish was successfully modified";
        }

        return $this->render('@App/Admin/Dish/modDish.html.twig', ['form' => $form->createView(),
        'msg' => $msg]);
    }
}