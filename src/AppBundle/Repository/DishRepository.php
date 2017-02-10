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
            ->where('d.name LIKE :q')
            ->orWhere('d.ingredients LIKE :q')
            ->orWhere('d.recipe LIKE :q')
            ->setParameter('q', '%' . $searchItem . '%')
            ->getQuery()
            ->getResult();
    }

    public function getPopularDish()
    {
        return $this->createQueryBuilder('d')
            ->select('d, count(o.id) as countOrders')
            ->add('orderBy', 'countOrders DESC')
            ->leftJoin('d.orders', 'o')
            ->groupBy('d')
            ->getQuery()
            ->setMaxResults(8)
            ->getResult();

    }
}
