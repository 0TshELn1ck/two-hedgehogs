<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Survey;
use AppBundle\Entity\SurveyAnswer;
use AppBundle\Entity\SurveyResult;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SurveyController
 * @Route("/survey")
 */
class SurveyController extends Controller
{
    /**
     * @Route("/", name="survey_list")
     */
    public function listAction(Request $request)
    {
        $answerForm = [];
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $newSurveys = $this->getDoctrine()->getRepository('AppBundle:Survey')->getAllActiveSurveys();
        } else {
            $newSurveys = $this->findNewSurveys();
            foreach ($newSurveys as $survey) {
                $answers = $survey->getSurveyAnswers()->getValues();
                foreach ($answers as $answer) {
                    $answerForm[$answer->getId()] = $this->createAnswerForm($answer)->createView();
                }
            }
        }

        return $this->render('AppBundle:Front:survey.html.twig', ['newSurveys' => $newSurveys, 'answerForm' => $answerForm]);
    }

    /**
     * @Route("/stat", name="survey_statistics")
     */
    public function statisticsAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $statList = $em->getRepository('AppBundle:Survey')->getAllActiveVoteSurveys($this->getUser());
        $countUsers = $em->getRepository('AppBundle:User')->countUsers();
        $percent = $countUsers / 100;

        return $this->render('@App/Front/surveyStat.html.twig', ['statList' => $statList, 'percent' => $percent]);
    }

    /**
     * @param SurveyAnswer $aid
     * @Route("/result/{aid}", name="survey_result",  requirements={"aid": "\d+"}))
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function resultAction($aid)
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

        return $this->redirectToRoute('survey_list');
    }

    private function findNewSurveys()
    {
        $em = $this->getDoctrine()->getManager();
        $surveyList = $em->getRepository('AppBundle:Survey')->getAllActiveSurveys();

        $vote = true;
        $newSurveys = [];
        /** @var Survey $survey */
        foreach ($surveyList as $survey) {
            if ($survey->getSurveyResult()->getValues()) {
                /** @var SurveyResult $result */
                foreach ($survey->getSurveyResult()->getValues() as $result) {

                    $currentUser = $this->getUser()->getid();
                    if ($result->getUser()) {
                        $userFromResult = $result->getUser()->getId();
                    } else {
                        $userFromResult = null;
                    }

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

    /**
     * @param SurveyAnswer $answer
     * @return \Symfony\Component\Form\Form
     */
    private function createAnswerForm($answer)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('survey_result', ['aid' => $answer->getId()]))
            ->setMethod('POST')
            ->add('submit', SubmitType::class, [
                'label' => $answer->getanswer(),
                'attr' => ['class' => 'btn btn-sm btn-success']
            ])
            ->getForm();
    }
}
