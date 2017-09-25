<?php

namespace DinnerBundle\Tests\Entity;

use DinnerBundle\Entity\Ad;
use DinnerBundle\Entity\AdType;
use DinnerBundle\Entity\Guest;
use DinnerBundle\Entity\Honoree;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class GuestTest extends TestCase
{
    /**
     * @var Guest
     */
    private $guest;

    protected function setUp()
    {
        $this->guest = new Guest();
    }

    /**
     * @test
     */
    public function string_case_with_woman_only()
    {
        $this->guest->familyName = 'Jameson';
        $this->guest->herName = 'Betty';

        $this->assertEquals('Jameson, Betty', (string) $this->guest);
    }

    /**
     * @test
     */
    public function string_case_with_man_only()
    {
        $this->guest->familyName = 'Jameson';
        $this->guest->hisName = 'Walter';

        $this->assertEquals('Jameson, Walter', (string) $this->guest);
    }

    /**
     * @test
     */
    public function string_case_with_man_and_woman()
    {
        $this->guest->familyName = 'Jameson';
        $this->guest->herName = 'Betty';
        $this->guest->hisName = 'Walter';

        $this->assertEquals('Jameson, Walter & Betty', (string) $this->guest);
    }

    /**
     * @test
     */
    public function pledge_low_when_low()
    {
        $this->guest->pledge2015 = 1000;
        $this->guest->pledge2016 = 999;

        $this->assertTrue($this->guest->pledgeIsLow());
    }

    /**
     * @test
     */
    public function pledge_low_when_not_low()
    {
        $this->guest->pledge2015 = 1000;
        $this->guest->pledge2016 = 1000;

        $this->assertFalse($this->guest->pledgeIsLow());
    }

    /**
     * @test
     */
    public function pledge_lacking_when_lacking()
    {
        $adType = new AdType();
        $adType->price = 100;
        $ad = new Ad();
        $ad->adType = $adType;

        $this->guest->pledge2016 = 99;
        $this->guest->ads = new ArrayCollection([$ad]);

        $this->assertTrue($this->guest->pledgeIsLacking());
    }

    /**
     * @test
     */
    public function pledge_lacking_when_not_lacking()
    {
        $adType = new AdType();
        $adType->price = 100;
        $ad = new Ad();
        $ad->adType = $adType;

        $this->guest->pledge2016 = 100;
        $this->guest->ads = new ArrayCollection([$ad]);

        $this->assertFalse($this->guest->pledgeIsLacking());
    }

    /**
     * @test
     */
    public function honoree_string()
    {
        $honoree1 = new Honoree();
        $honoree2 = new Honoree();
        $honoree1->code = 'XYZ';
        $honoree2->code = 'ABC';
        $this->guest->honorees = new ArrayCollection([$honoree1, $honoree2]);

        $this->guest->updateHonoreeString();

        $this->assertEquals('XYZ, ABC', $this->guest->honoreeString);
    }

    /**
     * @test
     */
    public function ads_current()
    {
        $adType1 = new AdType();
        $adType2 = new AdType();
        $adType1->label = 'Gold';
        $adType2->label = 'Full';
        $ad1 = new Ad();
        $ad2 = new Ad();
        $ad1->adType = $adType1;
        $ad2->adType = $adType2;
        $this->guest->ads = new ArrayCollection([$ad1, $ad2]);

        $this->assertEquals('Gold, Full', $this->guest->adsCurrent());
    }

    /**
     * @test
     */
    public function total_seats()
    {
        $this->guest->paidSeats = 1;
        $this->guest->compSeats = 2;

        $this->assertEquals(3, $this->guest->totalSeats());
    }
}
