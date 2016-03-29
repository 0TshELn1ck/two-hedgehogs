<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Dish;
use AppBundle\Form\DishAddType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SurveyController
 * @Route("/survey")
 */
class SurveyController extends Controller
{
    /**
     * @Route("/", name="list_survey")
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $surveyList = $em->getRepository('AppBundle:Survey')->getAllSurveys();

        return $this->render('AppBundle:Front:survey.html.twig', ['surveyList' => $surveyList]);
    }
}
