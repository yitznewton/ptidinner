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
}
