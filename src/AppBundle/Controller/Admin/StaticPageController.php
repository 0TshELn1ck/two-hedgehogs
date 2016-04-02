<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StaticPageController
 * @package AppBundle\Controller\Admin
 * @Route("/admin/static")
 */
class StaticPageController extends Controller
{

    /**
     * @return array
     * @Route("/",name="admin_static_index")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $pages = $em->getRepository('AppBundle:StaticPage')->findAll();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($pages, $request->query->getInt('page', 1), 10);

        return ['pages' => $pagination];
    }
}