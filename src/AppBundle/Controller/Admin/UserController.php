<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserController
 * @package AppBundle\Controller\Admin
 * @Route("/admin/user", name="admin_user")
 */
class UserController extends Controller
{
    /**
     * @return array
     * @Route("/", name="admin_user_index")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->findAll();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($user, $request->query->getInt('page', 1), 10);

        $deleteForm = [];
        foreach ($user as $entity) {
            $deleteForm[$entity->getId()] = $this->createDeleteForm($entity)->createView();
        }

        return ['user' => $pagination, 'deleteForm' => $deleteForm];
    }

    /**
     * @Route("/new", name="admin_user_new")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function newAction(Request $request)
    {
        $user = new User();

        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(UserType::class, $user);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($user);
                $em->flush();

                return $this->redirectToRoute('admin_user_index');
            }
        }
        return ['userForm' => $form->createView()];
    }

    /**
     * @Route("/show/{id}", name="admin_user_show")
     * @Template()
     * @return array
     */
    public function showAction($id)
    {
        if ($id) {
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('AppBundle:User')->find($id);

            if (!$user) {
                throw $this->createNotFoundException('Unable to find User.');
            }

            return ['user' => $user];
        }

        return [];
    }

    /**
     * @param Request $request
     * @param $id
     * @return array
     * @Route("/edit/{id}", name="admin_user_edit")
     * @Method({"GET", "POST"})
     * @Template("@App/Admin/User/new.html.twig")
     */
    public function editAction(Request $request, $id)
    {
        $breadcrumbs = "Рудагувати";
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->findOneBy(array('id' => $id));

        if (!$user) {
            throw $this->createNotFoundException('Unable to find Container user.');
        }

        $originalPassword = $user->getPassword();
        $editForm = $this->createForm(UserType::class, $user);

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            $plainPassword = $editForm->get('password')->getData();
            if (!empty($plainPassword)) {
                //encode the password
                $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
                $tempPassword = $encoder->encodePassword($user->getPassword(), $user->getSalt());
                $user->setPassword($tempPassword);
            } else {
                $user->setPassword($originalPassword);
            }

            $em->persist($user);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_user_index'));
        }

        return [
            'userForm' => $editForm->createView(),
            'breadcrumbs' => $breadcrumbs
        ];
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/delete/{id}", name="admin_user_delete")
     * @Method("DELETE")
     */
    public function deleteAction($id)
    {
        if ($id) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:User')->findOneBy(
                array(
                    'id' => $id,
                )
            );

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_user_index'));
    }

    /**
     * Creates a form to delete a User entity.
     * @param User $user The User entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {

        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->add('submit', SubmitType::class, [
                'label' => ' ',
                'attr' => ['class' => 'btn btn-xs btn-danger ace-icon fa fa-trash-o bigger-115']
            ])
            ->getForm();
    }

    /**
     * @param Request $request
     * @return array
     * @Route("/search", name="admin_user_search")
     * @Method("POST")
     * @Template()
     */
    public function searchAction(Request $request)
    {
        if ($request->getMethod() == 'POST') {
            $searchItem = $request->request->get('search');
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('AppBundle:User')->searchInUsers($searchItem);

            $paginator = $this->get('knp_paginator');
            $pagination = $paginator->paginate($user, $request->query->getInt('page', 1), 10);

            return ['user' => $pagination];
        }

        return [];
    }
}
