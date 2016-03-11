<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UploadPictureRepository extends EntityRepository
{
    public function getListUploads($limit)
    {
        return $this->createQueryBuilder('f')
            ->select('f')
            ->setMaxResults($limit)

            ->getQuery()
            ->getResult();
    }
}
