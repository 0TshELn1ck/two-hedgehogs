<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class AdminController
 * @package AppBundle\Admin
 * @Route("/admin", name="admin")
 */
class AdminController extends Controller
{
    /**
     * @return array
     * @Route("/", name="admin_index")
     * @Template("AppBundle:Admin:index.html.twig")
     */
    public function indexAction()
    {

        return [];
    }
}
