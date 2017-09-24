<?php

namespace DinnerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="honorees")
 * @ORM\Entity(repositoryClass="DinnerBundle\Repository\HonoreeRepository")
 */
class Honoree
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, unique=true)
     */
    public $name;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=3, unique=true)
     */
    public $code;

    public function __toString(): string
    {
        return $this->name;
    }
}
