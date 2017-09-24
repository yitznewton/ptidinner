<?php

namespace DinnerBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="ad_types")
 * @ORM\Entity(repositoryClass="DinnerBundle\Repository\AdTypeRepository")
 */
class AdType
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @var string
     *
     * @ORM\Column(unique=true)
     */
    public $label;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    public $price;

    /**
     * @var string
     *
     * @ORM\Column(unique=true)
     */
    public $code;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", name="per_page")
     */
    public $perPage;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", name="type_accession_count")
     */
    public $typeAccessionCount = 0;

    public function __toString(): string
    {
        return $this->label;
    }
}
