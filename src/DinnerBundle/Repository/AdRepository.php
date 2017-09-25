<?php

namespace DinnerBundle\Repository;

use Doctrine\ORM\EntityRepository;

class AdRepository extends EntityRepository
{
    public function findAll()
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT a FROM DinnerBundle\Entity\Ad a JOIN a.adType at ORDER BY at.price DESC, a.typeAccession ASC'
        );
        return $query->getResult();
    }
}
