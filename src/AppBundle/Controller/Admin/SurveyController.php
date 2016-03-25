<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Survey;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SurveyController extends Controller
{
    public function indexAction()
    {

    }

    public function newAction(Request $request)
    {
        $survey = new Survey();

    }
}