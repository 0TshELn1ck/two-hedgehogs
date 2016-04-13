<?php

namespace AppBundle\Controller\Admin;


use AppBundle\Entity\Feedback;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


/**
 * Class FeedbackController
 * @Route("/admin/feedback")
 */
class FeedbackController extends Controller
{
    /**
     * @Route("/", name="admin_feedback_index")
     */
    public function indexAction()
    {
        return $this->render('AppBundle:Admin/Feedback:index.html.twig', [
            'orderList' => $this->getDoctrine()->getRepository('AppBundle:Order')->getFeedbackOrders()
        ]);
    }

    /**
     * @param Feedback $feedback
     * @Route("/{id}", name="admin_feedback_show", requirements={"id": "\d+"})
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

    /**
     * Count of new feedbacks
     *
     * @Route("/count", name="get_feed_count")
     */
    public function getFeedCountAction()
    {
        $em = $this->getDoctrine()->getManager();
        $feeds = $em->getRepository('AppBundle:Feedback')->findBy(array('status'=>false));

        return new Response(count($feeds));
    }

    /**
     * Get new feedbacks by ajax
     *
     * @Route("/new", name="get_new_feedback")
     * @Method("POST")
     * @Template("AppBundle:Admin/Modals:feedback.html.twig")
     */
    public function getNewFeedbacksAction()
    {
        $em = $this->getDoctrine()->getManager();
        $feedbacks = $em->getRepository('AppBundle:Feedback')
            ->findBy(array('status'=>false));

        return ['feedbacks' => $feedbacks];
    }
}