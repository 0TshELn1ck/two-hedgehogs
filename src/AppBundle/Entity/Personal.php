<?php
/**
 * Created by PhpStorm.
 * User: hibro
 * Date: 20.02.16
 * Time: 15:12
 */

namespace AppBundle\Entity;

use AppBundle\Entity\BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Personal
 * @package AppBundle\Entity
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PersonalRepository")
 */
class Personal extends BaseUser
{
    /**
     * @ORM\OneToMany(targetEntity="Ord", mappedBy="Personal")
     */
    private $orders;

    /**
     * @ORM\OneToMany(targetEntity="Post", mappedBy="Personal")
     */
    private $posts;


    public function __construct() {
        $this->orders = new ArrayCollection();
        $this->posts = new ArrayCollection();
    }

    /**
     * Add orders
     *
     * @param \AppBundle\Entity\Ord $orders
     * @return Personal
     */
    public function addOrder(\AppBundle\Entity\Ord $orders)
    {
        $this->orders[] = $orders;

        return $this;
    }

    /**
     * Remove orders
     *
     * @param \AppBundle\Entity\Ord $orders
     */
    public function removeOrder(\AppBundle\Entity\Ord $orders)
    {
        $this->orders->removeElement($orders);
    }

    /**
     * Get orders
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * Add posts
     *
     * @param \AppBundle\Entity\Post $posts
     * @return Personal
     */
    public function addPost(\AppBundle\Entity\Post $posts)
    {
        $this->posts[] = $posts;

        return $this;
    }

    /**
     * Remove posts
     *
     * @param \AppBundle\Entity\Post $posts
     */
    public function removePost(\AppBundle\Entity\Post $posts)
    {
        $this->posts->removeElement($posts);
    }

    /**
     * Get posts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPosts()
    {
        return $this->posts;
    }
}
