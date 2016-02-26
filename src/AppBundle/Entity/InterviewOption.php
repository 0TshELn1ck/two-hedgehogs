<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InterviewOption
 *
 * @ORM\Table(name="interview_option")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InterviewOptionRepository")
 */
class InterviewOption
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
     * @ORM\Column(name="lable", type="string", length=255)
     */
    private $lable;

    /**
     * @var int
     *
     * @ORM\Column(name="count", type="integer", length=255)
     */
    private $count;

    /**
     * @ORM\ManyToOne(targetEntity="Interview", inversedBy="options")
     */
    private $interview;

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
     * Set lable
     *
     * @param string $lable
     * @return InterviewOption
     */
    public function setLable($lable)
    {
        $this->lable = $lable;

        return $this;
    }

    /**
     * Get lable
     *
     * @return string 
     */
    public function getLable()
    {
        return $this->lable;
    }

    /**
     * Set count
     *
     * @param integer $count
     * @return InterviewOption
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
     * Set interview
     *
     * @param \AppBundle\Entity\Interview $interview
     * @return InterviewOption
     */
    public function setInterview(\AppBundle\Entity\Interview $interview = null)
    {
        $this->interview = $interview;

        return $this;
    }

    /**
     * Get interview
     *
     * @return \AppBundle\Entity\Interview 
     */
    public function getInterview()
    {
        return $this->interview;
    }
}
