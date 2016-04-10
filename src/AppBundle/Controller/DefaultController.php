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

    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dishList = $em->getRepository('AppBundle:Dish')->getDishes();
        $dishPictList = $this->get('gallery.dishes')->randomPictures(5);
        $popularDish = $em->getRepository('AppBundle:Dish')->getPopularDish();
        
        return [
            'dishList' => $dishList, 
            'dishPictList' => $dishPictList,
            'popularDish'=>$popularDish
        ];
    }
}
