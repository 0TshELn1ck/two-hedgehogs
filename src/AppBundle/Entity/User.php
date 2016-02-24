<?php
/**
 * Created by PhpStorm.
 * User: hibro
 * Date: 20.02.16
 * Time: 15:12
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 * @package AppBundle\Entity
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\ManyToMany(targetEntity="Interview", inversedBy="users")
     */
    private $interviews;

    /**
     * @ORM\OneToMany(targetEntity="Location", mappedBy="user")
     */
    private $locations;

    /**
     * @ORM\OneToMany(targetEntity="Feedback", mappedBy="user")
     */
    private $feedbacks;

    /**
     * @ORM\OneToMany(targetEntity="Ord", mappedBy="user")
     */
    private $orders;


    public function __construct() {
        $this->interviews = new ArrayCollection();
        $this->locations = new ArrayCollection();
        $this->feedbacks = new ArrayCollection();
        $this->orders = new ArrayCollection();
    }

    /**
     * Add interviews
     *
     * @param \AppBundle\Entity\Interview $interviews
     * @return User
     */
    public function addInterview(\AppBundle\Entity\Interview $interviews)
    {
        $this->interviews[] = $interviews;

        return $this;
    }

    /**
     * Remove interviews
     *
     * @param \AppBundle\Entity\Interview $interviews
     */
    public function removeInterview(\AppBundle\Entity\Interview $interviews)
    {
        $this->interviews->removeElement($interviews);
    }

    /**
     * Get interviews
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInterviews()
    {
        return $this->interviews;
    }

    /**
     * Add locations
     *
     * @param \AppBundle\Entity\Location $locations
     * @return User
     */
    public function addLocation(\AppBundle\Entity\Location $locations)
    {
        $this->locations[] = $locations;

        return $this;
    }

    /**
     * Remove locations
     *
     * @param \AppBundle\Entity\Location $locations
     */
    public function removeLocation(\AppBundle\Entity\Location $locations)
    {
        $this->locations->removeElement($locations);
    }

    /**
     * Get locations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLocations()
    {
        return $this->locations;
    }

    /**
     * Add feedbacks
     *
     * @param \AppBundle\Entity\Feedback $feedbacks
     * @return User
     */
    public function addFeedback(\AppBundle\Entity\Feedback $feedbacks)
    {
        $this->feedbacks[] = $feedbacks;

        return $this;
    }

    /**
     * Remove feedbacks
     *
     * @param \AppBundle\Entity\Feedback $feedbacks
     */
    public function removeFeedback(\AppBundle\Entity\Feedback $feedbacks)
    {
        $this->feedbacks->removeElement($feedbacks);
    }

    /**
     * Get feedbacks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFeedbacks()
    {
        return $this->feedbacks;
    }

    /**
     * Add orders
     *
     * @param \AppBundle\Entity\Ord $orders
     * @return User
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
}
