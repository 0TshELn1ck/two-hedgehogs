<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Dish;
use AppBundle\Form\DishAddType;
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
     * @Route("/add", name="dishAdd")
     */
    public function addIndex(Request $request)
    {
        $dish = new Dish();

        $form = $this->createForm(DishAddType::class, $dish);
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
}