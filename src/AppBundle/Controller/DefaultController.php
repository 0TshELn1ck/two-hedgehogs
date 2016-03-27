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
     * @Template("AppBundle:Front:homepage.html.twig")
     */

    public function indextestAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dishList = $em->getRepository('AppBundle:Dish')->getDishes();

        return [
            'dishList' => $dishList
        ];
    }
}
