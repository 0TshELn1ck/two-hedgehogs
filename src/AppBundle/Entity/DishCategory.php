<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * DishCategory
 *
 * @ORM\Table(name="dish_category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DishCategoryRepository")
 */
class DishCategory
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="Dish", mappedBy="categories")
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
     * Set name
     *
     * @param string $name
     * @return DishCategory
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * Add dishs
     *
     * @param \AppBundle\Entity\Dish $dishs
     * @return DishCategory
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
