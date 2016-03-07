<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\User;
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
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/admin/user/delete/{id}", name="admin_user_delete")
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
                'label' => ' Видалити',
                'attr' => ['class' => 'btn btn-xs btn-danger ace-icon fa fa-trash-o bigger-120']
            ])
            ->getForm();
    }
}
