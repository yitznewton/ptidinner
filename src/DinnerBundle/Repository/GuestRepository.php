<?php

namespace DinnerBundle\Repository;

use Doctrine\ORM\EntityRepository;

class GuestRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->findBy(
            [],
            [
                'familyName' => 'ASC',
                'hisName' => 'ASC',
                'herName' => 'ASC',
            ]);
    }

    public function totals()
    {
        $query = $this->getEntityManager()->createQuery(<<<EOD
            SELECT SUM(g.paid) AS paid,
            SUM(g.pledge2016) AS pledgeCurrent,
            SUM(g.pledge2016)-SUM(g.paid) AS balance,
            SUM(g.paidSeats) AS paidSeats,
            SUM(g.paidSeats)+SUM(g.compSeats) AS totalSeats
            FROM DinnerBundle\Entity\Guest g
EOD
        );

        return $query->getResult()[0];
    }

    public function seated()
    {
        $query = $this->getEntityManager()->createQuery(<<<EOD
            SELECT g FROM DinnerBundle\Entity\Guest g
            WHERE g.paidSeats + g.compSeats > 0
            ORDER BY g.familyName, g.hisName, g.herName
EOD
        );

        return $query->getResult();
    }

    public function pledgedNotPaid()
    {
        $query = $this->getEntityManager()->createQuery(<<<EOD
            SELECT g FROM DinnerBundle\Entity\Guest g
            WHERE g.paid < g.pledge2016
            ORDER BY g.familyName, g.hisName, g.herName
EOD
        );

        return $query->getResult();
    }
}
