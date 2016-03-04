<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    /**
     * @return array
     * @Route("/admin/user", name="admin_user")
     * @Template()
     */
    public function indexAction()
    {
        return [];
    }
}
