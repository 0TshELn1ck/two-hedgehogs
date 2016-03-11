<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * DishCategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DishCategoryRepository extends EntityRepository
{
    public function getCategoriesDishes()
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT c FROM AppBundle:DishCategory c
             JOIN c.dishes d'
        );

        return $query->getResult();
    }
}