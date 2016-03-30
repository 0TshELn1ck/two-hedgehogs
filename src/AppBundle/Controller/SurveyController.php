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
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $em = $this->getDoctrine()->getManager();
        $surveyList = $em->getRepository('AppBundle:Survey')->getAllActiveSurveys(/*$this->getUser()*/);
        $newSurveys = [];
        /*$surveyDump = $surveyTest->getSurveyResult()->getValues()[0]->getUser();*/
        foreach ($surveyList as $survey) {
            if ($survey->getSurveyResult()->getValues()) {
                foreach ($survey->getSurveyResult()->getValues() as $user) {

                    $userFromResult = $user->getUser()->getId();
                    if ($userFromResult == $this->getUser()->getId()) {
                    } else {
                        $newSurveys[$survey->getId()] = $survey;
                    }
                }
            } else {
                $newSurveys[$survey->getId()] = $survey;
            }
        }

        return $this->render('AppBundle:Front:survey.html.twig', ['newSurveys' => $newSurveys]);
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
