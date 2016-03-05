<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Personal
 *
 * @ORM\Table(name="personal")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PersonalRepository")
 */
class Personal extends BaseUser
{

}
