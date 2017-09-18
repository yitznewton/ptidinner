<?php

namespace DinnerBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="guests")
 * @ORM\Entity(repositoryClass="DinnerBundle\Repository\GuestRepository")
 */
class Guest
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
     * @ORM\Column(name="family_name", length=50)
     */
    public $familyName;

    /**
     * @var string
     *
     * @ORM\Column(name="title", length=25)
     */
    public $title = '';

    /**
     * @var string
     *
     * @ORM\Column(name="her_name", length=50)
     */
    public $herName = '';

    /**
     * @var string
     *
     * @ORM\Column(name="his_name", length=50)
     */
    public $hisName = '';

    /**
     * @var integer
     */
    public $pledge2013;

    /**
     * @var integer
     */
    public $pledge2014;

    /**
     * @var integer
     */
    public $pledge2015;

    /**
     * @var integer
     */
    public $pledge2016;

    /**
     * @var integer
     */
    public $paid;

    /**
     * @var string
     *
     * @ORM\Column(name="street_address")
     */
    public $streetAddress = '';

    /**
     * @var string
     *
     * @ORM\Column(name="city", length=50)
     */
    public $city = '';

    /**
     * @var string
     *
     * @ORM\Column(name="state", length=2)
     */
    public $state = '';

    /**
     * @var string
     *
     * @ORM\Column(name="zip", length=9)
     */
    public $zip = '';

    /**
     * @var ArrayCollection<Ad>
     *
     * @ORM\ManyToMany(targetEntity="Ad", inversedBy="guests")
     * @ORM\JoinTable(name="ad_guest_assoc",
     *     joinColumns={@ORM\JoinColumn(name="guest_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="ad_id", referencedColumnName="id")}
     * )
     */
    public $ads;

    /**
     * @var ArrayCollection<Honoree>
     *
     * @ORM\ManyToMany(targetEntity="Honoree")
     * @ORM\JoinTable(name="honoree_guest_assoc",
     *     joinColumns={@ORM\JoinColumn(name="guest_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="honoree_id", referencedColumnName="id")}
     * )
     */
    public $honorees;

    public function __construct()
    {
        $this->ads = new ArrayCollection();
        $this->honorees = new ArrayCollection();
    }

    public function __toString()
    {
        $names = array_values(array_filter([$this->hisName, $this->herName]));
        return $this->familyName . ', ' . join(' & ', $names);
    }

    /**
     * @return int
     */
    public function pledgeCurrent()
    {
        return $this->pledge2016;
    }

    /**
     * @return int
     */
    public function pledgePrevious()
    {
        return $this->pledge2015;
    }

    /**
     * @return float|int
     */
    public function adSum()
    {
        return array_sum(
            array_map(function($ad) {
                return $ad->price();
            }, $this->ads)
        );
    }

    /**
     * @return string
     */
    public function adsCurrent()
    {
        return join(', ', array_map(function($ad) {
            return $ad->adType->label;
        }, $this->ads));
    }

    /**
     * @return string[]
     */
    public function adTypes()
    {
        return array_map(function ($ad) {
            return (string) $ad->adType;
        }, $this->ads);
    }

    /**
     * @return boolean
     */
    public function pledgeIsLow()
    {
        return $this->pledgeCurrent() < $this->pledgePrevious();
    }

    /**
     * @return boolean
     */
    public function pledgeIsLacking()
    {
        return $this->pledgeCurrent() < $this->adSum();
    }

    /**
     * @return string
     */
    public function fullAddress()
    {
        return sprintf('%s, %s, %s %s',
            $this->streetAddress,
            $this->city,
            $this->state,
            $this->zip);
    }

    /**
     * @return string
     */
    public function honoreeString()
    {
        return join(', ', array_map(function($honoree) {
            return $honoree->code;
        }, $this->honorees));
    }
}
