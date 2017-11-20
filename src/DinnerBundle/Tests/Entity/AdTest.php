<?php

namespace DinnerBundle\Tests\Entity;

use DinnerBundle\Entity\Ad;
use DinnerBundle\Entity\AdType;
use DinnerBundle\Entity\Guest;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class AdTest extends TestCase
{
    /**
     * @var Ad
     */
    private $ad;
    private $adType;

    protected function setUp()
    {
        $this->adType = new AdType();
        $this->adType->label = 'Gold';
        $this->ad = new Ad();
        $this->ad->adType = $this->adType;
        $this->ad->typeAccession = 'Gold-123';
    }

    /**
     * @test
     */
    public function string_cast_with_short_copy()
    {
        $this->ad->copy = 'abc';
        $this->assertEquals('Gold-123: abc', (string) $this->ad);
    }

    /**
     * @test
     */
    public function string_cast_when_no_copy()
    {
        $this->ad->copy = null;
        $this->assertEquals('Gold-123', $this->ad->__toString());
    }

    /**
     * @test
     */
    public function guest_string()
    {
        $guest1 = new Guest();
        $guest2 = new Guest();
        $guest1->familyName = 'Bobb';
        $guest2->familyName = 'Catt';
        $this->ad->guests = new ArrayCollection([$guest1, $guest2]);

        $this->ad->updateGuestString();

        $this->assertEquals('Bobb, Catt', $this->ad->guestString);
    }

    /**
     * @test
     */
    public function string_cast_when_copy_too_long()
    {
        $this->ad->copy = 'abcdefghijklmnopqrstuvwxyz';
        $this->assertEquals('Gold-123: abcdefghijklmnopqrstuvwxy...', (string) $this->ad);
    }
}
