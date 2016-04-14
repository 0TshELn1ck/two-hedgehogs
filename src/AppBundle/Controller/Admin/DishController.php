<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Dish;
use AppBundle\Entity\UploadPicture;
use AppBundle\Form\DishType;
use AppBundle\Form\ChoicePictureType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class DishController
 * @Route("/admin/dish")
 */
class DishController extends Controller
{
    /**
     * @Route("/", name="admin_dish_index")
     * @Method({"GET"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dishList = $em->getRepository('AppBundle:Dish')->findAll();
        $paginate = $this->get('knp_paginator')->paginate($dishList, $request->query->getInt('page', 1), 10);

        $deleteForms = [];
        foreach ($dishList as $entity) {
            $deleteForms[$entity->getId()] = $this->createFormBuilder($entity)
                ->setAction($this->generateUrl('admin_dish_delete', array('id' => $entity->getId())))
                ->setMethod('DELETE')
                ->add('submit', SubmitType::class, [
                    'label' => ' ',
                    'attr' => ['class' => 'btn btn-xs btn-danger ace-icon fa fa-trash-o bigger-115']
                ])
                ->getForm()->createView();
        }
        return $this->render('@App/Admin/Dish/index.html.twig', ['deleteForm' => $deleteForms, 'dishList' => $paginate]);
    }

    /**
     * @Route("/new", name="admin_dish_new")
     */
    public function newAction(Request $request)
    {
        $dish = new Dish();
        $form = $this->createForm(DishType::class, $dish);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->uploadPictureSaveDish($form, $dish);
            $message = "Нова страва \"" . $dish->getName() . "\" була успішно додана";

            return $this->render('@App/Admin/Dish/newMessage.html.twig', ['dish' => $dish, 'message' => $message]);
        }
        return $this->render('@App/Admin/Dish/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @param Dish $dish
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/edit/{id}", name="admin_dish_edit")
     */
    public function editAction(Dish $dish, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(DishType::class, $dish);

        $choosePictures = $em->getRepository('AppBundle:UploadPicture')->getListUploads($dish);
        $countPictures = $em->getRepository('AppBundle:UploadPicture')->countPictures($dish);

        $formChoose = $this->createForm(ChoicePictureType::class, $dish, ['data' => $choosePictures]);
        $delPictForm = $this->createDeleteForm($dish)->createView();

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            $formChoose->handleRequest($request);
        }

        if ($form->isValid()) {
            $this->uploadPictureSaveDish($form, $dish);
            $message = "Страва була успішно відредагована";

            return $this->render('@App/Admin/Dish/editMessage.html.twig', ['dish' => $dish, 'message' => $message]);
        }

        if ($formChoose->isValid()) {
            $dish->setPictPath($formChoose['pict_path']->getData()->getPath());
            $em->flush();
            $message = 'Змінено головне фото для страви "' . $dish->getName() . '"';

            return $this->render('@App/Admin/Dish/editMessage.html.twig', ['dish' => $dish, 'message' => $message]);
        }
        return $this->render('@App/Admin/Dish/edit.html.twig', ['form' => $form->createView(), 'formChoose' => $formChoose->createView(),
            'countPictures' => $countPictures, 'choosePicture' => $choosePictures, 'delPictForm' => $delPictForm
        ]);
    }

    /**
     *
     * @Route("/delete/{id}", name="admin_dish_delete")
     * @Method("DELETE")
     */
    public function deleteDishAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Dish')->find($id);
        $em->remove($entity);
        $em->flush();

        return $this->redirectToRoute('admin_dish_index');
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/picture/delete/{id}", name="admin_pictures_delete")
     * @Method("DELETE")
     */
    public function deletePicturesAction($id)
    {
        if ($id) {
            $em = $this->getDoctrine()->getManager();
            $dish = $em->getRepository('AppBundle:Dish')->findOneBy(['id' => $id]);

            if (!$dish) {
                throw $this->createNotFoundException('Unable to find Dish');
            }
            $dish->setPictPath('not_set');
            $pictures = $em->getRepository('AppBundle:UploadPicture')->getListUploads($id);
            foreach ($pictures as $item) {
                $em->remove($item);
            }
            $em->flush();

            return $this->redirectToRoute('admin_dish_edit', ['id' => $dish->getId()]);
        }
        return $this->redirectToRoute('admin_dish_index');
    }

    /**
     * @param Dish $dish
     * @return \Symfony\Component\Form\Form
     */
    private function createDeleteForm(Dish $dish)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_pictures_delete', ['id' => $dish->getId()]))
            ->setMethod('DELETE')
            ->add('delete', SubmitType::class, [
                'attr' => ['class' => 'btn btn-xs btn-info ace-icon fa fa-trash-o bigger-115']
            ])
            ->getForm();
    }

    /**
     * @param Request $request
     * @return array
     * @Route("/search", name="admin_dish_search")
     */
    public function searchAction(Request $request)
    {
        if ($request->getMethod() == 'POST') {
            $searchItem = $request->request->get('search');
            $em = $this->getDoctrine()->getManager();
            $dishList = $em->getRepository('AppBundle:Dish')->searchDishes($searchItem);

            return $this->render('@App/Admin/Dish/search.html.twig', ['dishList' => $dishList]);
        }

        return $this->render('@App/Admin/Dish/search.html.twig');
    }

    /** @var Dish $dish */
    private function uploadPictureSaveDish($form, $dish)
    {
        $em = $this->getDoctrine()->getManager();
        if (substr($dish->getPictPath(), 0, 8) != './images'){
            $dish->setPictPath('not_set');
        }

        $uploads = $form['file']->getData();
        if ($uploads) {
            $pict = new UploadPicture();
            $pict->setDish($dish);
            $pict->setOrigName($uploads->getClientOriginalName());

            $em->persist($pict);
            $uploadableManager = $this->get('stof_doctrine_extensions.uploadable.manager');
            $uploadableManager->markEntityToUpload($pict, $uploads);
            $em->persist($dish);
            $em->flush();

            if ($form['setMain']->getData()) {
                $dish->setPictPath($pict->getPath());
                $em->flush();
            }
        } else {
            $em->persist($dish);
            $em->flush();
        }
    }
}
