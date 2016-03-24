<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\DishCategory;
use AppBundle\Form\DishCategoryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
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
     * @Route("/new", name="admin_dish_category_new")
     * @Template()
     */
    public function newAction(Request $request)
    {
        $category = new DishCategory();

        $form = $this->createForm(DishCategoryType::class, $category);
        $msg = "";

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            $msg = "New dish category \"".$category->getName()."\"  successfully added";
        }

        return [
            'form' => $form->createView(),
            'msg' => $msg
        ];
    }

    /**
     * @Route("/list", name="admin_dish_category_list")
     * @Template()
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categoryList = $em->getRepository('AppBundle:DishCategory')->findAll();

        $deleteForm = [];
        foreach ($categoryList as $entity) {
            $deleteForm[$entity->getId()] = $this->createFormBuilder($entity)
                ->setAction($this->generateUrl('admin_dish_category_delete', array('id' => $entity->getId())))
                ->setMethod('DELETE')
                ->add('submit', SubmitType::class, [
                    'label' => ' ',
                    'attr' => ['class' => 'btn btn-xs btn-danger ace-icon fa fa-trash-o bigger-115']
                ])
                ->getForm()->createView();
        }

        return [
            'categoryList' => $categoryList,
            'deleteForm' => $deleteForm
        ];
    }

    /**
     * @Route("/edit/{id}", name="admin_dish_category_edit")
     * @Template()
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categoryList = $em->getRepository('AppBundle:DishCategory')->find($id);
        $msg = "";

        $form = $this->createForm(DishCategoryType::class, $categoryList);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $msg = "Category was successfully edited";
        }

        return [
            'form' => $form->createView(),
            'msg' => $msg
        ];
    }

    /**
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