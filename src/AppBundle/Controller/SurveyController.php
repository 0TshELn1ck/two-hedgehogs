<?php

namespace AppBundle\Controller;

use AppBundle\Entity\SurveyResult;
use AppBundle\Form\SurveyFrontType;
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
        $surveyList = $em->getRepository('AppBundle:Survey')->getAllActiveSurveys(/*$this->getUser()->getid()*/);
        /*$formSurveyList = [];
        $form1Survey = $this->createForm(SurveyFrontType::class, $surveyList[0])->createView();

        foreach ($surveyList as $item) {
            $formSurveyList[$item->getId()] = $this->createForm(SurveyFrontType::class, $item)->createView();
        }*/

        return $this->render('AppBundle:Front:survey.html.twig', ['surveyList' => $surveyList/*,
            'formSurveyList' => $formSurveyList, 'form1Survey' => $form1Survey*/]);
    }

    /**
     * @param $aid
     * @Route("/result/{aid}", name="result_survey")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function surveyResultAction($aid, Request $request)
    {
        $result = new SurveyResult();
        $em = $this->getDoctrine()->getManager();
        $answer = $em->getRepository('AppBundle:SurveyAnswer')->findOneBy(['id' => $aid]);
        $result->setUser($this->getUser());
        $result->setAnswer($answer);
        $result->setSurvey($answer->getSurvey());

        $em->persist($result);
        $em->flush();

        return $this->redirectToRoute('homepage');
    }
}
