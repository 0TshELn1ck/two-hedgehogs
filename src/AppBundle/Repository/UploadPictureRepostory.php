<?php

namespace AppBundle\Repository;

class UploadPictureRepository extends \Doctrine\ORM\EntityRepository
{
    public function getListUploads($limit)
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->setMaxResults($limit)

            ->getQuery()
            ->getResult();
    }
}
