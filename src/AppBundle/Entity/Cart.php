<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Cart
 *
 * @ORM\Table(name="cart")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CartRepository")
 */
class Cart
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
     * @ORM\Column(name="ip", type="string", length=15, nullable=true, unique=true)
     */
    private $ip;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\User", inversedBy="cart")
     */
    private $user;

    /**
     * @var \DateTime $createdAt
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\DishInCart", mappedBy="cart")
     */
    private $pickedDishes;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set ip
     *
     * @param string $ip
     *
     * @return Cart
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
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
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Cart
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
     * Constructor
     */
    public function __construct()
    {
        $this->pickedDishes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add pickedDishes
     *
     * @param \AppBundle\Entity\DishInCart $pickedDish
     *
     * @return Cart
     */
    public function addDish(\AppBundle\Entity\DishInCart $pickedDish)
    {
        $this->pickedDishes[] = $pickedDish;

        return $this;
    }

    /**
     * Remove pickedDishes
     *
     * @param \AppBundle\Entity\DishInCart $pickedDish
     */
    public function removePickedDish(\AppBundle\Entity\DishInCart $pickedDish)
    {
        $this->pickedDishes->removeElement($pickedDish);
    }

    /**
     * Get pickedDishes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPickedDishes()
    {
        return $this->pickedDishes;
    }
}
