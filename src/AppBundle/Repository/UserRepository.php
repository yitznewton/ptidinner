<?php

namespace AppBundle\Repository;

class UserRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAll()
    {
        return $this->findBy(
            [],
            [
                'username' => 'ASC',
            ]);
    }
}
