<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class DishRepository extends EntityRepository
{
    public function getDishes()
    {
        return $this->createQueryBuilder('d')
            ->select('d', 'dc')
            ->leftJoin('d.categories', 'dc')
            ->getQuery()
            ->getResult();
    }

    public function getAdminDishes($first, $max)
    {
        return $this->getEntityManager()
            ->createQuery(
             'SELECT d FROM AppBundle:Dish d'
            )
            ->setFirstResult($first)
            ->setMaxResults($max);
    }

    public function getOneDish($slug)
    {
        return $this->createQueryBuilder('d')
            ->select('d')
            ->where('d.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
