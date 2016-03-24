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

    public function getAdminDishes($offset, $max)
    {
        return $this->getEntityManager()
            ->createQuery(
             'SELECT d FROM AppBundle:Dish d'
            )
            ->setFirstResult($offset)
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

    public function search($query)
    {
        return $this->createQueryBuilder('d')
            ->select('d, dc')
            ->leftJoin('d.categories', 'dc')
            ->orWhere('d.name = :q')
            ->orWhere("d.ingredients LIKE '%$query%'")
            ->orWhere("d.recipe LIKE '%$query%'")
            ->orWhere("dc.name LIKE '%$query%'")
            ->setParameter('q', $query)
            ->getQuery()
            ->getResult();
    }
}
