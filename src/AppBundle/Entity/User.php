<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="fos_users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends \FOS\UserBundle\Model\User
{
    const DEFAULT_GARBAGE_PASSWORD = 'qwertyuiop';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
}

