<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GalleryController extends Controller
{
    /**
     * @param Request $request
     * @Route("/Gallery")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request)
    {
        $dishPictList = $this->getDoctrine()->getRepository('AppBundle:Dish')->getPictDishes();

        return $this->render('@App/Front/homepage.html.twig', ['dishPictList' => $dishPictList]);
    }
}
