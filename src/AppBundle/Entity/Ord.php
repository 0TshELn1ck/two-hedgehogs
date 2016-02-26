<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Ord
 *
 * @ORM\Table(name="ord")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrdRepository")
 */
class Ord
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2)
     */
    private $price;

    /**
     * @var  /DataTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;
    /**
     * @var  /DataTime
     *
     * @Gedmo\Timestampable(on="change", field={"status"})
     * @ORM\Column(name="update_at", type="datetime", nullable=true)
     */
    private $updateAt;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="orders")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Personal", inversedBy="orders")
     */
    private $cook;


    /**
     * @ORM\ManyToOne(targetEntity="Personal", inversedBy="orders")
     */
    private $courier;

    /**
     * @ORM\OneToOne(targetEntity="Feedback", inversedBy="order")
     */
    private $feedback;

    /**
     * @ORM\ManyToMany(targetEntity="Dish", mappedBy="orders")
     */
    private $dishs;

    public function __construct() {
        $this->dishs = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Ord
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Ord
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Ord
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updateAt
     *
     * @param \DateTime $updateAt
     * @return Ord
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * Get updateAt
     *
     * @return \DateTime 
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     * @return Ord
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set cook
     *
     * @param \AppBundle\Entity\Personal $cook
     * @return Ord
     */
    public function setCook(\AppBundle\Entity\Personal $cook = null)
    {
        $this->cook = $cook;

        return $this;
    }

    /**
     * Get cook
     *
     * @return \AppBundle\Entity\Personal 
     */
    public function getCook()
    {
        return $this->cook;
    }

    /**
     * Set courier
     *
     * @param \AppBundle\Entity\Personal $courier
     * @return Ord
     */
    public function setCourier(\AppBundle\Entity\Personal $courier = null)
    {
        $this->courier = $courier;

        return $this;
    }

    /**
     * Get courier
     *
     * @return \AppBundle\Entity\Personal 
     */
    public function getCourier()
    {
        return $this->courier;
    }

    /**
     * Set feedback
     *
     * @param \AppBundle\Entity\Feedback $feedback
     * @return Ord
     */
    public function setFeedback(\AppBundle\Entity\Feedback $feedback = null)
    {
        $this->feedback = $feedback;

        return $this;
    }

    /**
     * Get feedback
     *
     * @return \AppBundle\Entity\Feedback 
     */
    public function getFeedback()
    {
        return $this->feedback;
    }

    /**
     * Add dishs
     *
     * @param \AppBundle\Entity\Dish $dishs
     * @return Ord
     */
    public function addDish(\AppBundle\Entity\Dish $dishs)
    {
        $this->dishs[] = $dishs;

        return $this;
    }

    /**
     * Remove dishs
     *
     * @param \AppBundle\Entity\Dish $dishs
     */
    public function removeDish(\AppBundle\Entity\Dish $dishs)
    {
        $this->dishs->removeElement($dishs);
    }

    /**
     * Get dishs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDishs()
    {
        return $this->dishs;
    }
}
