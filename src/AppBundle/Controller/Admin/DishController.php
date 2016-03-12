<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Dish;
use AppBundle\Entity\UploadPicture;
use AppBundle\Form\DishType;
use AppBundle\Form\ChoicePictureType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
     * @Route("/", name="adm_dish_index")
     */
    public function indexAction()
    {
        return $this->render('@App/Admin/Dish/index.html.twig');
    }

    /**
     * @Route("/add", name="adm_dish_add")
     */
    public function addAction(Request $request)
    {
        $dish = new Dish();
        $dish->setPictPath('not_set');

        $form = $this->createForm(DishType::class, $dish);
        $msg = "";

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($dish);
            $em->flush();
            $msg = "New dish successfully added";
        }

        return $this->render('@App/Admin/Dish/add.html.twig', ['form' => $form->createView(),
            'msg' => $msg]);
    }

    /**
     * @Route("/list", name="adm_dish_list")
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dishList = $em->getRepository('AppBundle:Dish')->getDishes();

        $deleteForms = [];
        foreach ($dishList as $entity) {
            $deleteForms[$entity->getId()] = $this->createFormBuilder($entity)
                ->setAction($this->generateUrl('adm_dish_del', array('id' => $entity->getId())))
                ->setMethod('DELETE')
                ->add('submit', SubmitType::class, ['label' => ' ', 'attr' => ['class' => 'glyphicon glyphicon-trash btn-link']])
                ->getForm()->createView();
        }

        return $this->render('@App/Admin/Dish/list.html.twig', ['dishList' => $dishList,
            'delForms' => $deleteForms]);
    }

    /**
     * @Route("/edit/{id}", name="adm_dish_edit")
     */
    public function editAction($id, Request $request)
    {
        $pict = new UploadPicture();

        $em = $this->getDoctrine()->getManager();
        $dish = $em->getRepository('AppBundle:Dish')->find($id);
        $msg = "";

        $form = $this->createForm(DishType::class, $dish);
        $uploadForm = $this->createFormBuilder($pict)
            ->add('file', FileType::class, ['label' => false])
            ->getForm();

        $choosePictures = $em->getRepository('AppBundle:UploadPicture')->getListUploads(10);
        $formChoose = $this->createForm(ChoicePictureType::class ,$dish, ['data' => $choosePictures]);

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            $uploadForm->handleRequest($request);
            $formChoose->handleRequest($request);
        }

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $msg = "Dish was successfully edited";
        }

        if ($uploadForm->isValid()) {
            $uploads = $uploadForm['file']->getData();
            $pict->setDish($dish);
            $pict->setOrigName($uploads->getClientOriginalName());

            $em->persist($pict);
            $uploadableManager = $this->get('stof_doctrine_extensions.uploadable.manager');
            $uploadableManager->markEntityToUpload($pict, $pict->getFile());
            $em->flush();
            $msg = 'Picture was added to dish';
        }

        if ($formChoose->isValid()) {
            $dish->setPictPath($formChoose['pict_path']->getData()->getPath());
            $em->flush();
            $msg = 'Picture changes for dish "' . $dish->getName() . '"';
        }

        return $this->render('@App/Admin/Dish/edit.html.twig', ['form' => $form->createView(),
            'uploadForm' => $uploadForm->createView(), 'formChoose' => $formChoose->createView(),
            'msg' => $msg]);
    }

    /**
     *
     * @Route("/delete/{id}", name="adm_dish_del")
     * @Method("DELETE")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Dish')->find($id);
        $em->remove($entity);
        $em->flush();

        return $this->redirectToRoute('adm_dish_list');
    }
}