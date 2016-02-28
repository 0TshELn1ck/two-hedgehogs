<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function indextestAction(Request $request)
    {
        return $this->render('AppBundle:Front:homepage.html.twig');
    }

    /**
     * @Route("menu", name="menu")
     */
    public function menuAction(Request $request)
    {
        return $this->render('AppBundle:Front:menu.html.twig');
    }

}
