<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Feedback;
use AppBundle\Entity\Order;
use AppBundle\Form\FeedbackType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserController
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
     * @Route("/orders", name="user_orders")
     * @Template("AppBundle:Front:userOrders.html.twig")
     */
    public function profileAction(Request $request)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        if ($user) {
            $orders = $em->getRepository('AppBundle:Order')->getSortableOrder($user->getId());

            return [
                'orders' => $orders, 'forms' => $this->createFeedbackForms($orders)
            ];
        }

        return $this->redirectToRoute('homepage');
    }

    /**
     * @param Order $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/feedback/{id}", name="user_feedback", requirements={"id": "\d+"})
     * @Method("POST")
     */
    public function feedbackAction(Order $id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $feedback = new Feedback();
        $feedback->setStatus(false);
        $feedback->setOrder($id);
        $feedback->setUser($this->getUser());
        $requestText = $request->request->get('feedback');
        $feedback->setText($requestText['text']);
        $em->persist($feedback);
        $em->flush();

        return $this->redirectToRoute('user_orders');
    }

    /**
     * @Route("/orders/delete/{order}", name="deleteOrderByUser")
     * @Method("POST")
     */
    public function deleteOrderAction(Request $request, Order $order = null)
    {
        $user = $this->getUser();
        $status = $order->getStatus();

        if ($user->getOrders()->contains($order)) {
            if ($status == 'processing' || $status == 'closed' || $status == 'canceled') {
                $em = $this->getDoctrine()->getManager();
                $em->remove($order);
                $em->flush();
                return new JsonResponse(['success' => 'Успішно видалено']);
            }

            return new JsonResponse(['error' => 'Ви не можете видалити замовлення №' . $order->getId()]);
        }

        return new JsonResponse(['error' => 'Виникла помилка']);
    }

    private function createFeedbackForms($orders)
    {
        $forms = [];
        /** @var Order $order */
        foreach ($orders as $order) {
            if ($order->getStatus() == 'closed') {
                $feedback = new Feedback();
                $forms[$order->getId()] = $this->createForm(FeedbackType::class, $feedback)->createView();
            }
        }
        return $forms;
    }
}