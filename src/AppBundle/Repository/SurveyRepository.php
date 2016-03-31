<?php

namespace AppBundle\Repository;

/**
 * SurveyRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SurveyRepository extends \Doctrine\ORM\EntityRepository
{
    public function getAllActiveSurveys()
    {
        return $this->createQueryBuilder('s')
            ->select('s', 'sa')
            ->where('s.status = 1')
            ->leftJoin('s.surveyAnswers', 'sa')
            ->getQuery()
            ->getResult();
    }
}
