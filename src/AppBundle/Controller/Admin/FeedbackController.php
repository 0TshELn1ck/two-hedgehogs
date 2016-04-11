<?php

namespace AppBundle\Controller\Admin;


use AppBundle\Entity\Feedback;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Class FeedbackController
 * @Route("/admin")
 */
class FeedbackController extends Controller
{
    /**
     * @Route("feedback", name="admin_feedback_index")
     */
    public function indexAction()
    {
        return $this->render('AppBundle:Admin/Feedback:index.html.twig', [
            'orderList' => $this->getDoctrine()->getRepository('AppBundle:Order')->getFeedbackOrders()
        ]);
    }

    /**
     * @param Feedback $feedback
     * @Route("/feedback/{id}", name="admin_feedback_show", requirements={"id": "\d+"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Feedback $feedback)
    {
        if ($feedback->getStatus() == false) {
            $feedback->setStatus(true);
        }
        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->render('@App/Admin/Feedback/show.html.twig', ['feedback' => $feedback]);
    }
}