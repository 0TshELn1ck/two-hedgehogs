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
}