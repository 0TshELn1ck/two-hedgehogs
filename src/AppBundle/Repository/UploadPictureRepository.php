<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UploadPictureRepository extends EntityRepository
{
    public function getListUploads($id)
    {
        return $this->createQueryBuilder('f')
            ->select('f')
            ->leftJoin('f.dish', 'd')
            ->where('d.id = :id')
            ->setParameter('id', $id)

            ->getQuery()
            ->getResult();
    }

    public function countPictures($id)
    {
        return $this->createQueryBuilder('f')
            ->select('count(f.id)')
            ->leftJoin('f.dish', 'd')
            ->where('d.id = :id')
            ->setParameter('id', $id)

            ->getQuery()
            ->getSingleScalarResult();
    }
}
