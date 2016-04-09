<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository
{
    /**
     * @param $searchItem
     * @return array
     * Search item in user.email and user.name
     */
    public function searchInUsers($searchItem)
    {
        return $this->createQueryBuilder('u')
            ->where('u.email LIKE :search')
            ->orWhere('u.username LIKE :search')
            ->orWhere('u.id LIKE :search')
            ->setParameter('search', '%' . $searchItem . '%')
            ->getQuery()
            ->getResult();
    }

    public function countUsers()
    {
        return $this->createQueryBuilder('u')
            ->select('count(u.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
