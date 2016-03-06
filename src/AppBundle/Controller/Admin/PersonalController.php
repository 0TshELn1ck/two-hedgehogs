<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class PersonalController
 * @package AppBundle\Controller\Admin
 * @Route("/admin/personal", name="admin_personal")
 */
class PersonalController extends Controller
{
    /**
     * @return array
     * @Route("/", name="admin_personal_index")
     * @Template()
     */
    public function indexAction()
    {
        return [];
    }
}
