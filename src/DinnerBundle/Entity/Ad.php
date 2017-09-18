<?php

namespace DinnerBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="ads")
 * @ORM\Entity(repositoryClass="DinnerBundle\Repository\AdRepository")
 */
class Ad
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
     * @ORM\Column(name="copy", type="text")
     */
    public $copy = '';

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="text")
     */
    public $note = '';

    /**
     * @var string
     *
     * @ORM\Column(name="guest_string", type="text")
     */
    public $guestString = '';

    /**
     * @var string
     *
     * @ORM\Column(name="type_accession", type="string", length=10, unique=true)
     */
    public $typeAccession = '';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="sent_to_printer", type="date", nullable=true)
     */
    public $sentToPrinter;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="proof_from_printer", type="date", nullable=true)
     */
    public $proofFromPrinter;

    /**
     * @var boolean
     *
     * @ORM\Column(name="proof_approved", type="boolean")
     */
    public $proofApproved = false;

    /**
     * @var ArrayCollection<Guest>
     *
     * @ORM\ManyToMany(targetEntity="Guest", mappedBy="ads")
     */
    public $guests;

    /**
     * @var AdType
     *
     * @ORM\ManyToOne(targetEntity="AdType")
     * @ORM\JoinColumn(name="ad_type_id", referencedColumnName="id")
     */
    public $adType;

    public function __construct()
    {
        $this->guests = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->typeAccession . ': ' . $this->truncatedCopy();
    }

    /**
     * @return string
     */
    private function truncatedCopy()
    {
        $len = 25;
        $copy = $this->copy;

        if (strlen($copy) > $len) {
            return substr($copy, 0, $len) . '...';
        } else {
            return $copy;
        }
    }
}
