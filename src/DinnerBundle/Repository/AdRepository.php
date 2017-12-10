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

    public function needingRebbetzinChanges()
    {
        $query = $this->getEntityManager()->createQuery(<<<EOD
            SELECT a FROM DinnerBundle\Entity\Ad a
            JOIN a.adType at
            WHERE a.needsRebbetzinChanges = true
            ORDER BY at.price DESC, a.typeAccession ASC
EOD
        );

        return $query->getResult();
    }
}
