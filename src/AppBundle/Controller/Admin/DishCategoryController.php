<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\DishCategory;
use AppBundle\Form\DishCategoryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class DishCategoryController
 * @Route("/admin/dish/category")
 */
class DishCategoryController extends Controller
{

    /**
     * @Route("/add", name="admin_dish_category_add")
     */
    public function addAction(Request $request)
    {
        $category = new DishCategory();

        $form = $this->createForm(DishCategoryType::class, $category);
        $msg ="";

        $form->handleRequest($request);
        if ($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            $msg ="New dish category successfully added";
        }

        return $this->render('@App/Admin/Dish/addCategory.html.twig', ['form' => $form->createView(),
            'msg' => $msg]);
    }

    /**
     * @Route("/list", name="admin_dish_category_list")
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categoryList = $em->getRepository('AppBundle:DishCategory')->findAll();

        $deleteForms = [];
        foreach ($categoryList as $entity) {
            $deleteForms[$entity->getId()] = $this->createFormBuilder($entity)
                ->setAction($this->generateUrl('admin_dish_category_delete', array('id' => $entity->getId())))
                ->setMethod('DELETE')
                ->add('submit', SubmitType::class, ['label' => ' ', 'attr' => ['class' => 'glyphicon glyphicon-trash btn-link']])
                ->getForm()->createView();
        }

        return $this->render('@App/Admin/Dish/listCategory.html.twig', ['categoryList' => $categoryList,
        'delForms' => $deleteForms]);
    }

    /**
     * @Route("/edit/{id}", name="admin_dish_category_edit")
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categoryList = $em->getRepository('AppBundle:DishCategory')->find($id);
        $msg ="";

        $form = $this->createForm(DishCategoryType::class, $categoryList);

        $form->handleRequest($request);
        if ($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $msg ="Category was successfully edited";
        }

        return $this->render('@App/Admin/Dish/editCategory.html.twig', ['form' => $form->createView(),
        'msg' => $msg]);
    }

    /**
     *
     * @Route("/delete/{id}", name="admin_dish_category_delete")
     * @Method("DELETE")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:DishCategory')->find($id);
        $em->remove($entity);
        $em->flush();

        return $this->redirectToRoute('admin_dish_category_list');
    }
}