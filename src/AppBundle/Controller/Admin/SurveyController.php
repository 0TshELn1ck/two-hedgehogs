<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Survey;
use AppBundle\Entity\SurveyAnswer;
use AppBundle\Form\SurveyEditType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\SurveyType;

/**
 * Class DishController
 * @Route("/admin/survey")
 */
class SurveyController extends Controller
{
    /**
     * @Route("/", name="admin_survey_index")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $surveyList = $em->getRepository('AppBundle:Survey')->findAll();
        $paginate = $this->get('knp_paginator')->paginate($surveyList, $request->query->getInt('page', 1), 10);

        $delForms = [];
        foreach ($surveyList as $item) {
            $delForms[$item->getId()] = $this->createDeleteForm($item)->createView();
        }

        return $this->render('@App/Admin/Survey/index.html.twig', ['surveyList' => $paginate, 'delForms' => $delForms]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/new", name="admin_survey_new")
     */
    public function newAction(Request $request)
    {
        $survey = new Survey();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(SurveyType::class, $survey);
        $form->handleRequest($request);

        if ($form->isValid()) {
            for ($i = 1; $i <= 5; $i++) {
                $formAnswer = $form['answer' . $i]->getData();
                if ($formAnswer != "") {
                    $answer = new SurveyAnswer();
                    $answer->setAnswer($formAnswer);
                    $answer->setCount(0);
                    $answer->setSurvey($survey);
                    $em->persist($answer);
                }
            }
            $em->persist($survey);
            $em->flush();

            return $this->redirectToRoute('admin_survey_index');
        }

        return $this->render('@App/Admin/Survey/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @param Survey $survey
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/edit/{id}", name="admin_survey_edit")
     */
    public function editAction(Survey $survey, Request $request)
    {
        $form = $this->createForm(SurveyEditType::class, $survey);
        $em = $this->getDoctrine()->getManager();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('admin_survey_index');
        }

        return $this->render('@App/Admin/Survey/edit.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/stat", name="admin_survey_statistics")
     */
    public function statisticsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $statList = $em->getRepository('AppBundle:Survey')->getAllActiveSurveys();
        $countUsers = $em->getRepository('AppBundle:User')->countUsers();
        $percent = $countUsers / 100;

        return $this->render('@App/Admin/Survey/statistics.html.twig', ['statList' => $statList, 'percent' => $percent]);
    }

    /**
     *
     * @Route("/delete/{id}", name="admin_survey_delete")
     * @Method("DELETE")
     */
    public function deleteSurveyAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $survey = $em->getRepository('AppBundle:Survey')->findOneBy(['id' => $id]);
        if (!$survey) {
            throw $this->createNotFoundException('Unable to find Survey');
        }
        $em->remove($survey);
        $em->flush();

        return $this->redirectToRoute('admin_survey_index');
    }

    /**
     * @param Survey $survey
     * @return \Symfony\Component\Form\Form
     */
    private function createDeleteForm(Survey $survey)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_survey_delete', ['id' => $survey->getId()]))
            ->setMethod('DELETE')
            ->add('submit', SubmitType::class, [
                'label' => ' ',
                'attr' => ['class' => 'btn btn-minier btn-danger ace-icon fa fa-trash-o bigger-115']
            ])
            ->getForm();
    }
}
