<?php

namespace AppBundle\Repository;

/**
 * OrdersRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OrdersRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Get last address witch user register order
     * @param $user_id
     * @param $limit
     * @return array
     */
    public function getLastUserAddress($user_id, $limit)
    {
        $orders = $this->getEntityManager()
            ->createQuery(
                'SELECT DISTINCT o.address FROM AppBundle:Order o 
                  WHERE o.user = :user ORDER BY o.createdAt DESC'
            )
            ->setMaxResults($limit)
            ->setParameter('user', $user_id)
            ->getResult();
        
        $adresses = array();
        
        foreach ($orders as $order){
            $adresses[] = $order['address'];
        }

        return $adresses;
    }

    /**
     * get all order for user sort by date
     * @param $user_id
     * @return array
     */
    public function getSortableOrder($user_id)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT o FROM AppBundle:Order o 
                  WHERE o.user = :user ORDER BY o.createdAt DESC'
            )
            ->setParameter('user', $user_id)
            ->getResult();
    }
}
