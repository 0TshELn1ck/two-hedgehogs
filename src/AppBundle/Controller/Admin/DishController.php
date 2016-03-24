<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Dish;
use AppBundle\Entity\UploadPicture;
use AppBundle\Form\DishType;
use AppBundle\Form\ChoicePictureType;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
     * @Route("/", name="admin_dish_index")
     */
    public function indexAction()
    {

    }

    /**
     * @Route("/new", name="admin_dish_new")
     */
    public function newAction(Request $request)
    {
        $dish = new Dish();
        $dish->setPictPath('not_set');

        $form = $this->createForm(DishType::class, $dish);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($dish);
            $em->flush();
            $message = "New dish \"".$dish->getName()."\" was successfully added";

            return $this->render('@App/Admin/Dish/newMessage.html.twig', ['dish' => $dish, 'message' => $message]);
        }
        return $this->render('@App/Admin/Dish/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/list/page/{page}", name="admin_dish_list", defaults={"page" = 1},
     *     requirements={"page": "\d+"})
     */
    public function listAction(Request $request, $page)
    {
        $maxResults = 15;
        /* if page = 0 */
        if ($page >= 1) {
            $offset = ($page - 1) * $maxResults;
        } else {
            $offset = 0;
            $page = 1;
        }

        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('AppBundle:Dish')->getAdminDishes($offset, $maxResults);
        $paginate = $this->paginate($query, $maxResults, $page);
        $i = 0;
        $dishList = [];
        $deleteForms = [];
        foreach ($paginate['pagesList'] as $entity) {
            $dishList[$i] = $entity;
            $i++;
            $deleteForms[$entity->getId()] = $this->createFormBuilder($entity)
                ->setAction($this->generateUrl('admin_dish_delete', array('id' => $entity->getId())))
                ->setMethod('DELETE')
                ->add('submit', SubmitType::class, [
                    'label' => ' ',
                    'attr' => ['class' => 'btn btn-xs btn-danger ace-icon fa fa-trash-o bigger-115']
                ])
                ->getForm()->createView();
        }
        return $this->render('@App/Admin/Dish/list.html.twig', ['dishList' => $dishList,
            'deleteForm' => $deleteForms, 'paginate' => $paginate]);
    }

    /**
     * @param Dish $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/edit/{id}", name="admin_dish_edit")
     */
    public function editAction(Dish $id, Request $request)
    {
        $pict = new UploadPicture();

        $em = $this->getDoctrine()->getManager();
        $dish = $em->getRepository('AppBundle:Dish')->find($id);

        $form = $this->createForm(DishType::class, $dish);
        $uploadForm = $this->createFormBuilder($pict)
            ->add('file', FileType::class, ['label' => false])
            ->getForm();

        $choosePictures = $em->getRepository('AppBundle:UploadPicture')->getListUploads($id);
        $countPictures = $em->getRepository('AppBundle:UploadPicture')->countPictures($id);

        $formChoose = $this->createForm(ChoicePictureType::class, $dish, ['data' => $choosePictures]);
        $delPictForm = $this->createDeleteForm($dish)->createView();

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            $uploadForm->handleRequest($request);
            $formChoose->handleRequest($request);
        }

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $message = "Dish was successfully edited";

            return $this->render('@App/Admin/Dish/editMessage.html.twig', ['dish' => $dish, 'message' => $message]);
        }

        if ($uploadForm->isValid()) {
            $uploads = $uploadForm['file']->getData();
            $pict->setDish($dish);
            $pict->setOrigName($uploads->getClientOriginalName());

            $em->persist($pict);
            $uploadableManager = $this->get('stof_doctrine_extensions.uploadable.manager');
            $uploadableManager->markEntityToUpload($pict, $pict->getFile());
            $em->flush();
            $message = 'Picture was added to dish';

            return $this->render('@App/Admin/Dish/editMessage.html.twig', ['dish' => $dish, 'message' => $message]);
        }

        if ($formChoose->isValid()) {
            $dish->setPictPath($formChoose['pict_path']->getData()->getPath());
            $em->flush();
            $message = 'Main picture changes for dish "' . $dish->getName() . '"';

            return $this->render('@App/Admin/Dish/editMessage.html.twig', ['dish' => $dish, 'message' => $message]);
        }
        return $this->render('@App/Admin/Dish/edit.html.twig', ['form' => $form->createView(),
            'uploadForm' => $uploadForm->createView(), 'formChoose' => $formChoose->createView(),
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

        return $this->redirectToRoute('admin_dish_list');
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
        return $this->redirectToRoute('admin_dish_list');
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

    private function paginate($query, $maxResults, $page)
    {
        $pagesList = new Paginator($query, $fetchJoin = false);
        $count = count($pagesList);
        $maxPages = ceil($count / $maxResults);
        /* if - need to activate or disactivate page block in Twig */
        if ($count <= $maxResults) {
            $count = 0;
        }
        return ['pagesList' => $pagesList, 'count' => $count, 'maxPages' => $maxPages, 'page' => $page];
    }
}