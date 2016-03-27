<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Survey
 *
 * @ORM\Table(name="survey")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SurveyRepository")
 */
class Survey
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var bool
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    /**
     * @var \DateTime $createdAt
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\SurveyAnswer", mappedBy="survey", cascade={"REMOVE"})
     */
    private $surveyAnswers;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->surveyAnswers = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set title
     *
     * @param string $title
     *
     * @return Survey
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return Survey
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return bool
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Add surveyAnswer
     *
     * @param \AppBundle\Entity\SurveyAnswer $surveyAnswer
     *
     * @return Survey
     */
    public function addSurveyAnswer(\AppBundle\Entity\SurveyAnswer $surveyAnswer)
    {
        $this->surveyAnswers[] = $surveyAnswer;

        return $this;
    }

    /**
     * Remove surveyAnswer
     *
     * @param \AppBundle\Entity\SurveyAnswer $surveyAnswer
     */
    public function removeSurveyAnswer(\AppBundle\Entity\SurveyAnswer $surveyAnswer)
    {
        $this->surveyAnswers->removeElement($surveyAnswer);
    }

    /**
     * Get surveyAnswer
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSurveyAnswers()
    {
        return $this->surveyAnswers;
    }
}
