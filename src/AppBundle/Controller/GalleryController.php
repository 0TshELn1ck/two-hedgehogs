<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class GalleryController extends Controller
{
    /**
     * @param Request $request
     * @Route("/gallery", name="gallery")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request)
    {
        $dishPictList = $this->get('gallery.dishes')->randomPictures(12);

        return $this->render('@App/Front/gallery.html.twig', ['dishPictList' => $dishPictList]);
    }
}
