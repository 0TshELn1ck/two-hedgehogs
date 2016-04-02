<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;

/**
 * Order
 *
 * @ORM\Table(name="ord")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrdersRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class Order
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
     * @ORM\Column(name="status", type="string", length=255, options={"default" = "processing"})
     */
    private $status = 'processing';

    /**
     * @var string
     *
     * @ORM\Column(name="summ", type="decimal", precision=10, scale=2)
     */
    private $summ = 0;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="orders")
     */
    private $user;

    /**
     * @var \DateTime $cookTo
     *
     * @ORM\Column(type="datetime")
     */
    private $cookTo;

    /**
     * @var \DateTime $createdAt
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime $updatedAt
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\DishInOrder", mappedBy="order", cascade={"persist", "remove"})
     */
    private $dishesInOrder;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * Hook SoftDeleteable behavior
     * updates deletedAt field
     */
    use SoftDeleteableEntity;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dishesInOrder = new \Doctrine\Common\Collections\ArrayCollection();
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
     *
     * @return Order
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
     * Set summ
     *
     * @param string $summ
     *
     * @return Order
     */
    public function setSumm($summ)
    {
        $this->summ = $summ;

        return $this;
    }

    /**
     * Get summ
     *
     * @return string
     */
    public function getSumm()
    {
        return $this->summ;
    }

    /**
     * Set cookTo
     *
     * @param \DateTime $cookTo
     *
     * @return Order
     */
    public function setCookTo($cookTo)
    {
        $this->cookTo = $cookTo;

        return $this;
    }

    /**
     * Get cookTo
     *
     * @return \DateTime
     */
    public function getCookTo()
    {
        return $this->cookTo;
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
     * @return Order
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
     * Add dishesInOrder
     *
     * @param \AppBundle\Entity\DishInOrder $dishesInOrder
     *
     * @return Order
     */
    public function addDishesInOrder(\AppBundle\Entity\DishInOrder $dishesInOrder)
    {
        $this->dishesInOrder[] = $dishesInOrder;

        return $this;
    }

    /**
     * Remove dishesInOrder
     *
     * @param \AppBundle\Entity\DishInOrder $dishesInOrder
     */
    public function removeDishesInOrder(\AppBundle\Entity\DishInOrder $dishesInOrder)
    {
        $this->dishesInOrder->removeElement($dishesInOrder);
    }

    /**
     * Get dishesInOrder
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDishesInOrder()
    {
        return $this->dishesInOrder;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Order
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }
}
