<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\Length(min="2", max="64")
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @Assert\Length(min="10")
     * @ORM\Column(name="ingredients", type="text")
     */
    private $ingredients;

    /**
     * @var string
     * @Assert\NotNull()
     * @ORM\Column(name="price", type="decimal", precision=10, scale=0)
     */
    private $price;

    /**
     * @var string
     * @ORM\Column(name="recipe", type="text", nullable=true)
     */
    private $recipe;

    /**
     * @var string
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

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
     * @ORM\Column(type="string")
     */
    private $pictPath;

    /**
     * @var bool
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\DishCategory", inversedBy="dishes")
     */
    private $categories;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Cart", mappedBy="dishes")
     */
    private $carts;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\UploadPicture", mappedBy="dish", cascade={"REMOVE"})
     */
    private $uploadPictures;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\DishInOrder", mappedBy="dish")
     */
    private $orders;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
        $this->carts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->orders = new \Doctrine\Common\Collections\ArrayCollection();
        $this->uploadPictures = new \Doctrine\Common\Collections\ArrayCollection();
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
     *
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
     * Set ingredients
     *
     * @param string $ingredients
     *
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
     * Set price
     *
     * @param string $price
     *
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

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    /**
     * @return mixed
     */
    public function getPictPath()
    {
        return $this->pictPath;
    }

    /**
     * @param mixed $pictPath
     */
    public function setPictPath($pictPath)
    {
        $this->pictPath = $pictPath;
    }

    /**
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param boolean $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Add category
     *
     * @param \AppBundle\Entity\DishCategory $category
     *
     * @return Dish
     */
    public function addCategory(\AppBundle\Entity\DishCategory $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \AppBundle\Entity\DishCategory $category
     */
    public function removeCategory(\AppBundle\Entity\DishCategory $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Add cart
     *
     * @param \AppBundle\Entity\Cart $cart
     *
     * @return Dish
     */
    public function addCart(\AppBundle\Entity\Cart $cart)
    {
        $this->carts[] = $cart;
    }

    /**
     * Add uploadPictures
     *
     * @param \AppBundle\Entity\UploadPicture $uploadPictures
     *
     * @return Dish
     */
    public function addUploadPicture(\AppBundle\Entity\UploadPicture $uploadPictures)
    {
        $this->uploadPictures[] = $uploadPictures;

        return $this;
    }

    /**
     * Remove cart
     *
     * @param \AppBundle\Entity\Cart $cart
     */
    public function removeCart(\AppBundle\Entity\Cart $cart)
    {
        $this->carts->removeElement($cart);
    }

    /**
     * Get carts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCarts()
    {
        return $this->carts;
    }

    /**
     * Remove uploadPictures
     *
     * @param \AppBundle\Entity\UploadPicture $uploadPictures
     */
    public function removeUploadPicture(\AppBundle\Entity\UploadPicture $uploadPictures)
    {
        $this->uploadPictures->removeElement($uploadPictures);
    }

    /**
     * Get $this->uploadPictures
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUploadPictures()
    {
        return $this->uploadPictures;
    }

    /**
     * @return string
     */
    public function getRecipe()
    {
        return $this->recipe;
    }

    /**
     * @param string $recipe
     */
    public function setRecipe($recipe)
    {
        $this->recipe = $recipe;
    }
}
