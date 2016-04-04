<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * StaticPage
 *
 * @ORM\Table(name="static_page")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StaticPageRepository")
 */
class StaticPage
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
     * @var String
     * @ORM\Column(name="route", type="string", length=32, unique=true)

     */
    private $route;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=12, unique=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text")
     */
    private $text;


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
     * Set name
     *
     * @param string $title
     *
     * @return StaticPage
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return StaticPage
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return String
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param String $route
     */
    public function setRoute($route)
    {
        $this->route = $route;
    }
}

