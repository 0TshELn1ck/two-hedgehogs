<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Personal;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PersonalController
 * @package AppBundle\Controller\Admin
 * @Route("/admin/personal", name="admin_personal")
 */
class PersonalController extends Controller
{
    /**
     * @return array
     * @Route("/", name="admin_personal_index")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $personal = $em->getRepository('AppBundle:Personal')->findAll();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($personal, $request->query->getInt('page', 1), 10);

        $deleteForm = [];
        foreach ($personal as $entity) {
            $deleteForm[$entity->getId()] = $this->createDeleteForm($entity)->createView();
        }

        return ['personal' => $pagination, 'deleteForm' => $deleteForm];
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/admin/personal/delete/{id}", name="admin_personal_delete")
     * @Method("DELETE")
     */
    public function deleteAction($id)
    {
        if ($id) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Personal')->findOneBy(
                array(
                    'id' => $id,
                )
            );

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Personal entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_personal_index'));
    }

    /**
     * Creates a form to delete a Personal entity.
     * @param Personal $personal The Personal entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Personal $personal)
    {

        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_personal_delete', array('id' => $personal->getId())))
            ->setMethod('DELETE')
            ->add('submit', SubmitType::class, [
                'label' => ' Видалити',
                'attr' => ['class' => 'btn btn-xs btn-danger ace-icon fa fa-trash-o bigger-120']
            ])
            ->getForm();
    }
}
