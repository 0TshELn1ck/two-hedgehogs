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
     * @ORM\JoinTable(name="users_interviews")
     */
    private $interviews;

    /**
     * @ORM\ManyToMany(targetEntity="Location")
     * @ORM\JoinTable(name="users_locations",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="location_id", referencedColumnName="id")}
     *      )
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
}