<?php

namespace AppBundle\Controller;

use AppBundle\Entity\StaticPage;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StaticPageController extends Controller
{
    /**
     * @Route("/pages/{route}")
     * @ParamConverter("staticPage", class="AppBundle:StaticPage")
     * @Template("@App/Front/staticPage.html.twig")
     */
    public function showAction(StaticPage $page)
    {
    }

}
