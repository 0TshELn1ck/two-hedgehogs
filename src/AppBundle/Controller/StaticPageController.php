<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StaticPageController extends Controller
{
    /**
     * @return array
     * @Template("@App/Front/staticPage.html.twig")
     * @Route("/pages/{slug}",name="static_page", defaults={"slug" = "none"})
     */
    public function indexAction($slug)
    {
        return ['slug' => $slug];
    }

}
