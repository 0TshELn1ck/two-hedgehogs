<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PersonalController extends Controller
{
    /**
     * @return array
     * @Route("/admin/personal", name="admin_personal")
     * @Template()
     */
    public function indexAction()
    {
        return [];
    }
}
