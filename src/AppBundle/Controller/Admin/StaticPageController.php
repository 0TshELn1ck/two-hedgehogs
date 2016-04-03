<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\StaticPage;
use AppBundle\Form\StaticPageType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class StaticPageController
 * @package AppBundle\Controller\Admin
 * @Route("/admin/static")
 */
class StaticPageController extends Controller
{

    /**
     * @return array
     * @Route("/",name="admin_static_index")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $pages = $em->getRepository('AppBundle:StaticPage')->findAll();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($pages, $request->query->getInt('page', 1), 10);

        $deleteForm = [];
        foreach ($pages as $entity) {
            $deleteForm[$entity->getId()] = $this->createDeleteForm($entity)->createView();
        }

        return ['pages' => $pagination, 'deleteForm' => $deleteForm];
    }

    /**
     * @param Request $request
     * @return array|RedirectResponse
     * @Route("/new", name="admin_static_new")
     * @Template()
     */
    public function newAction(Request $request)
    {
        $page = new StaticPage();

        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(StaticPageType::class, $page)
            ->add('Зберегти', SubmitType::class);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($page);
                $em->flush();

                return $this->redirectToRoute('admin_static_index');
            }
        }

        return ['pageForm' => $form->createView()];
    }

    /**
     * @Route("/show/{id}", name="admin_static_show")
     * @Template()
     * @return array
     */
    public function showAction($id)
    {
        if ($id) {
            $em = $this->getDoctrine()->getManager();
            $page = $em->getRepository('AppBundle:StaticPage')->find($id);

            if (!$page) {
                throw $this->createNotFoundException('Unable to find Page.');
            }

            return ['page' => $page];
        }

        return [];
    }

    /**
     * @param Request $request
     * @param $id
     * @return array
     * @Method({"GET", "POST"})
     * @Route("/edit/{id}", name="admin_static_edit")
     * @Template("@App/Admin/StaticPage/new.html.twig")
     */
    public function editAction(Request $request, $id)
    {
        $breadcrumbs = "Редагувати";
        $em = $this->getDoctrine()->getManager();
        $page = $em->getRepository('AppBundle:StaticPage')->findOneBy(array('id' => $id));

        if (!$page) {
            throw $this->createNotFoundException('Unable to find Container page.');
        }

        $editForm = $this->createForm(StaticPageType::class, $page)
            ->add('Редагувати', SubmitType::class);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($page);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_static_index'));
        }

        return [
            'pageForm' => $editForm->createView(),
            'breadcrumbs' => $breadcrumbs
        ];
    }

    /**
     * @param $id
     * @return RedirectResponse
     * @Route("/delete/{id}", name="admin_static_delete")
     * @Method("DELETE")
     */
    public function deleteAction($id)
    {
        if ($id) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:StaticPage')->findOneBy(
                array(
                    'id' => $id,
                )
            );

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find StaticPage entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_static_index'));
    }

    /**
     * @param StaticPage $page
     * @return Form
     */
    private function createDeleteForm(StaticPage $page)
    {

        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_static_delete', array('id' => $page->getId())))
            ->setMethod('DELETE')
            ->add('submit', SubmitType::class, [
                'label' => ' ',
                'attr' => ['class' => 'btn btn-xs btn-danger ace-icon fa fa-trash-o bigger-115']
            ])
            ->getForm();
    }


}