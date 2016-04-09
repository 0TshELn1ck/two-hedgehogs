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
            ->where('d.status =1')
            ->getQuery()
            ->getResult();
    }
    
    public function getPictDishes()
    {
        return $this->createQueryBuilder('d')
            ->select('d')
            ->where('d.status =1')
            ->andWhere('d.pictPath <> :path')
            ->setParameter('path', 'not_set')
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

    public function searchDishes($searchItem)
    {
        return $this->createQueryBuilder('d')
            ->select('d')
            ->where('d.name LIKE :q1')
            ->orWhere('d.ingredients LIKE :q')
            ->orWhere('d.recipe LIKE :q')
            ->setParameter('q', '%' . $searchItem . '%')
            ->setParameter('q1', $searchItem)
            ->getQuery()
            ->getResult();
    }
}
