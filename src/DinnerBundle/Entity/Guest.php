<?php

namespace DinnerBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="guests")
 * @ORM\Entity(repositoryClass="DinnerBundle\Repository\GuestRepository")
 * @ORM\HasLifecycleCallbacks
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
     * @var int
     *
     * @ORM\Column(name="ykp_id", type="integer", nullable=true)
     */
    public $ykpId;

    /**
     * @var string
     *
     * @ORM\Column(name="family_name", length=50)
     */
    public $familyName;

    /**
     * @var string
     *
     * @ORM\Column(name="title", length=25, nullable=true)
     */
    public $title;

    /**
     * @var string
     *
     * @ORM\Column(name="her_name", length=50, nullable=true)
     */
    public $herName;

    /**
     * @var string
     *
     * @ORM\Column(name="his_name", length=50, nullable=true)
     */
    public $hisName;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    public $note;

    /**
     * @var float
     *
     * @ORM\Column(name="pledge_2013", type="float", length=8, scale=2)
     */
    public $pledge2013 = 0.0;

    /**
     * @var float
     *
     * @ORM\Column(name="pledge_2014", type="float", length=8, scale=2)
     */
    public $pledge2014 = 0.0;

    /**
     * @var float
     *
     * @ORM\Column(name="pledge_2015", type="float", length=8, scale=2)
     */
    public $pledge2015 = 0.0;

    /**
     * @var float
     *
     * @ORM\Column(name="pledge_current", type="float", length=8, scale=2)
     */
    public $pledge2016 = 0.0;

    /**
     * @var float
     *
     * @ORM\Column(type="float", length=8, scale=2)
     */
    public $paid = 0.0;

    /**
     * @return float
     */
    public function balance()
    {
        return max(0, $this->pledgeCurrent() - $this->paid);
    }

    /**
     * @var string
     *
     * @ORM\Column(name="street_address", nullable=true)
     */
    public $streetAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="city", length=50, nullable=true)
     */
    public $city;

    /**
     * @var string
     *
     * @ORM\Column(name="state", length=2, nullable=true)
     */
    public $state;

    /**
     * @var string
     *
     * @ORM\Column(name="zip", length=9, nullable=true)
     */
    public $zip;

    /**
     * @var string
     *
     * @ORM\Column(length=50, nullable=true)
     */
    public $country;

    /**
     * @var string
     *
     * @ORM\Column(length=50, nullable=true)
     */
    public $phone;

    /**
     * @var string
     *
     * @ORM\Column(length=50, nullable=true)
     */
    public $mobile;

    /**
     * @var string
     *
     * @ORM\Column(length=50, nullable=true)
     */
    public $fax;

    /**
     * @var string
     *
     * @ORM\Column(length=100, nullable=true)
     */
    public $email;

    /**
     * @var string
     *
     * @ORM\Column(name="referred_by", length=100, nullable=true)
     */
    public $referredBy;

    /**
     * @var int
     *
     * @ORM\Column(name="paid_seats", type="integer")
     */
    public $paidSeats = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="comp_seats", type="integer")
     */
    public $compSeats = 0;

    /**
     * @return int
     */
    public function totalSeats()
    {
        return $this->paidSeats + $this->compSeats;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="previous_ad_copy", type="text", nullable=true)
     */
    public $previousAdCopy;

    /**
     * @var string
     *
     * @ORM\Column(name="ads_previous", length=100, nullable=true)
     */
    public $previousAdTypes;

    /**
     * @var string
     *
     * @ORM\Column(name="honoree_string", length=50, nullable=true)
     */
    public $honoreeString;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_business", type="boolean")
     */
    public $isBusiness = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="do_not_call", type="boolean")
     */
    public $doNotCall = false;

    /**
     * @var ArrayCollection<Ad>
     *
     * @ORM\ManyToMany(targetEntity="Ad", mappedBy="guests")
     * @ORM\JoinTable(name="ad_guest_assoc")
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

    public function __toString(): string
    {
        $names = array_values(array_filter([$this->hisName, $this->herName]));
        return $this->familyName . ', ' . join(' & ', $names);
    }

    public function pledgeCurrent(): float
    {
        return $this->pledge2016;
    }

    public function pledgePrevious(): float
    {
        return $this->pledge2015;
    }

    /**
     * @return float|int
     */
    public function adSum()
    {
        return array_sum(
            $this->ads->map(function($ad) {
                return $ad->price();
            })->toArray()
        );
    }

    public function adsCurrent(): string
    {
        return join(', ', $this->adTypes());
    }

    /**
     * @return string[]
     */
    public function adTypes(): array
    {
        return $this->ads->map(function ($ad) {
            return (string) $ad->adType;
        })->toArray();
    }

    public function pledgeIsLow(): bool
    {
        return $this->pledgeCurrent() < $this->pledgePrevious();
    }

    public function pledgeIsPaid(): bool
    {
        return $this->balance() === 0;
    }

    public function pledgeIsLacking(): bool
    {
        return $this->pledgeCurrent() < $this->adSum();
    }

    public function fullAddress(): string
    {
        return sprintf('%s, %s, %s %s',
            $this->streetAddress,
            $this->city,
            $this->state,
            $this->zip);
    }

    /**
     * @ORM\PreUpdate
     */
    public function updateHonoreeString(): void
    {
        $this->honoreeString = join(', ', $this->honorees->map(function($honoree) {
            return $honoree->code;
        })->toArray());
    }
}
