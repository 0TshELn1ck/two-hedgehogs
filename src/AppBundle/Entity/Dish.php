<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Dish
 *
 * @ORM\Table(name="dish")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DishRepository")
 */
class Dish
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
     * @var string
     *
     * @ORM\Column(name="recipe", type="text", nullable=true)
     */
    private $recipe;

    /**
     * @var string
     *
     * @ORM\Column(name="ingredients", type="text")
     */
    private $ingredients;

    /**
     * @var string
     *
     * @ORM\Column(name="in_menu", type="string", length=255)
     */
    private $inMenu;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2)
     */
    private $price;

    /**
     * @Gedmo\Slug(fields={"name"}, updatable=true, separator="_")
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

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
     * @Gedmo\Timestampable(on="change", field={"name", "price", "in_menu", "recipe", "ingredients"})
     * @ORM\Column(name="update_at", type="datetime", nullable=true)
     */
    private $updateAt;

    /**
     * @ORM\ManyToMany(targetEntity="Ord", inversedBy="dishs")
     * @ORM\JoinTable(name="order_dishes")
     */
    private $orders;

    /**
     * @ORM\ManyToMany(targetEntity="DishCategory", inversedBy="dishs")
     * @ORM\JoinTable(name="category_dishes")
     */
    private $categories;


    /**
     * @ORM\OneToMany(targetEntity="Photo", mappedBy="dish")
     */
    private $photos;

    public function __construct() {
        $this->orders = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->photos = new ArrayCollection();
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
     * @return Dish
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
     * Set recipe
     *
     * @param string $recipe
     * @return Dish
     */
    public function setRecipe($recipe)
    {
        $this->recipe = $recipe;

        return $this;
    }

    /**
     * Get recipe
     *
     * @return string 
     */
    public function getRecipe()
    {
        return $this->recipe;
    }

    /**
     * Set ingredients
     *
     * @param string $ingredients
     * @return Dish
     */
    public function setIngredients($ingredients)
    {
        $this->ingredients = $ingredients;

        return $this;
    }

    /**
     * Get ingredients
     *
     * @return string 
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }

    /**
     * Set inMenu
     *
     * @param string $inMenu
     * @return Dish
     */
    public function setInMenu($inMenu)
    {
        $this->inMenu = $inMenu;

        return $this;
    }

    /**
     * Get inMenu
     *
     * @return string 
     */
    public function getInMenu()
    {
        return $this->inMenu;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Dish
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
}
