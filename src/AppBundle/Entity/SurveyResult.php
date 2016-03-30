<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SurveyResult
 *
 * @ORM\Table(name="survey_result")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SurveyResultRepository")
 */
class SurveyResult
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\SurveyAnswer")
     */
    private $answer;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Survey", inversedBy="surveyResult")
     */
    private $survey;


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
     * Set answer
     *
     * @param \AppBundle\Entity\SurveyAnswer $answer
     *
     * @return SurveyResult
     */
    public function setAnswer(\AppBundle\Entity\SurveyAnswer $answer = null)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get answer
     *
     * @return \AppBundle\Entity\SurveyAnswer
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return SurveyResult
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set survey
     *
     * @param \AppBundle\Entity\Survey $survey
     *
     * @return SurveyResult
     */
    public function setSurvey(\AppBundle\Entity\Survey $survey = null)
    {
        $this->survey = $survey;

        return $this;
    }

    /**
     * Get survey
     *
     * @return \AppBundle\Entity\Survey
     */
    public function getSurvey()
    {
        return $this->survey;
    }
}
