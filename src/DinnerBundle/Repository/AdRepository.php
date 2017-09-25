<?php

namespace DinnerBundle\Repository;

class AdRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAll()
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT a FROM DinnerBundle\Entity\Ad a JOIN a.adType at ORDER BY at.price DESC, a.typeAccession ASC'
        );
        return $query->getResult();
    }
}
