<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="homepage")
     * @Template("default/index.html.twig")
     */

    public function indextestAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dishList = $em->getRepository('AppBundle:Dish')->getDishes();

        return $this->render('AppBundle:Front:homepage.html.twig', ['dishList' => $dishList]);
    }

    /**
     * @Route("/user/orders", name="userProfile")
     */
    public function profileAction(Request $request)
    {
        return $this->render('AppBundle:Front:userProfile.html.twig');
    }
}
