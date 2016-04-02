<?php

namespace AppBundle\Controller;

use AppBundle\Entity\SurveyResult;
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
        $newSurveys = $this->findNewSurveys();

        return $this->render('AppBundle:Front:survey.html.twig', ['newSurveys' => $newSurveys]);
    }

    /**
     * @param $aid
     * @Route("/result/{aid}", name="result_survey",  requirements={"aid": "\d+"}))
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function surveyResultAction($aid)
    {
        $result = new SurveyResult();
        $em = $this->getDoctrine()->getManager();
        $answer = $em->getRepository('AppBundle:SurveyAnswer')->findOneBy(['id' => $aid]);
        if (!$answer) {
            throw $this->createNotFoundException('Unable to find answer');
        }
        $count = $answer->getCount();
        $answer->setCount($count + 1);
        $result->setUser($this->getUser());
        $result->setAnswer($answer);
        $result->setSurvey($answer->getSurvey());

        $em->persist($result);
        $em->flush();

        return $this->redirectToRoute('list_survey');
    }

    private function findNewSurveys()
    {
        $em = $this->getDoctrine()->getManager();
        $surveyList = $em->getRepository('AppBundle:Survey')->getAllActiveSurveys();

        $vote = true;
        $newSurveys = [];
        foreach ($surveyList as $survey) {
            if ($survey->getSurveyResult()->getValues()) {
                foreach ($survey->getSurveyResult()->getValues() as $result) {

                    $currentUser = $this->getUser()->getid();
                    $userFromResult = $result->getUser()->getId();

                    if ($userFromResult == $currentUser) {
                        $vote = true;
                        break;
                    } else {
                        $vote = false;
                        /* user not vote */
                    }
                }
                if (!$vote) {
                    $newSurveys[$survey->getId()] = $survey;
                }
            } else {
                $newSurveys[$survey->getId()] = $survey;
            }
        }
        return $newSurveys;
    }
}
