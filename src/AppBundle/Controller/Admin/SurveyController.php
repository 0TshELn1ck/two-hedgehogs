<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Survey;
use AppBundle\Entity\SurveyAnswer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $surveyList = $em->getRepository('AppBundle:Survey')->findAll();

        return $this->render('@App/Admin/Survey/index.html.twig', ['surveyList' => $surveyList]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/new", name="admin_survey_new")
     */
    public function newAction(Request $request)
    {
        $survey = new Survey();
        $answer = new SurveyAnswer();

        $form = $this->createForm(SurveyType::class, $survey);
        $form->handleRequest($request);
        $message = '';

        if ($form->isValid()) {

            /*$em = $this->getDoctrine()->getManager();
            $em->persist($survey);
            $em->flush();*/
            $message = "New survey \"" . $survey->getTitle() . "\" was successfully added";

            return $this->render('@App/Admin/Survey/new.html.twig', ['form' => $form->createView(),
                'message' => $message]);
        }

        return $this->render('@App/Admin/Survey/new.html.twig', ['form' => $form->createView(),
            'message' => $message]);

    }
}