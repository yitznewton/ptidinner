<?php

namespace DinnerBundle\Repository;

class GuestRepository extends \Doctrine\ORM\EntityRepository
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
}
