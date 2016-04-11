<?php

namespace AppBundle\Services;

use Symfony\Bridge\Doctrine\RegistryInterface;

class GalleryService
{
    private $doctrine;

    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function randomPictures($num)
    {
        $em = $this->doctrine->getManager();
        $dishPictList = $em->getRepository('AppBundle:Dish')->getPictDishes();
        shuffle($dishPictList);
        $dishPictList = array_slice($dishPictList, 0, $num);

        return $dishPictList;
    }
}