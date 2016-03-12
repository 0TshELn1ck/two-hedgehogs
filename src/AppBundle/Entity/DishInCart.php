<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DishInCart
 *
 * @ORM\Table(name="dish_in_cart")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DishInCartRepository")
 */
class DishInCart
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Cart", inversedBy="pickedDishes")
     */
    private $cart;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Dish")
     */
    private $dish;

    /**
     * @var int
     *
     * @ORM\Column(name="count", type="integer", nullable=false, unique=false)
     */
    private $count = 1;

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
     * Set count
     *
     * @param integer $count
     *
     * @return DishInCart
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Get count
     *
     * @return integer
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set cart
     *
     * @param \AppBundle\Entity\Cart $cart
     *
     * @return DishInCart
     */
    public function setCart(\AppBundle\Entity\Cart $cart = null)
    {
        $this->cart = $cart;

        return $this;
    }

    /**
     * Get cart
     *
     * @return \AppBundle\Entity\Cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * Set dish
     *
     * @param \AppBundle\Entity\Dish $dish
     *
     * @return DishInCart
     */
    public function setDish(\AppBundle\Entity\Dish $dish = null)
    {
        $this->dish = $dish;

        return $this;
    }

    /**
     * Get dish
     *
     * @return \AppBundle\Entity\Dish
     */
    public function getDish()
    {
        return $this->dish;
    }
}
