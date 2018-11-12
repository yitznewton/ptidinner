<?php

namespace DinnerBundle\Tests\Transaction;

use DinnerBundle\Entity\Ad;
use DinnerBundle\Entity\AdType;
use DinnerBundle\Entity\Guest;
use DinnerBundle\Transaction\AdCreateTransaction;
use PHPUnit\Framework\TestCase;

class AdCreateTransactionTest extends TestCase
{
    /** @var AdType */
    private $adType;

    /** @var Ad */
    private $ad;

    public function setUp(): void
    {
        $this->adType = new AdType();
        $this->adType->typeAccessionCount = 2;
        $this->adType->code = 'Full';
        $this->adType->label = 'Full';

        $this->ad = new Ad();
        $this->ad->adType = $this->adType;
    }

    /** @test */
    public function updates_guest_ad_types()
    {
        $em = new MockObjectManager();
        $guest = new Guest();
        $guest->familyName = 'Smith';
        $this->ad->guests->add($guest);
        $transaction = new AdCreateTransaction($em, $this->ad);
        $transaction();

        $this->assertEquals('Full', $guest->adTypesString);
    }

    /** @test */
    public function flushes() {
        $em = new MockObjectManager();
        $guest = new Guest();
        $guest->familyName = 'Smith';
        $this->ad->guests->add($guest);
        $transaction = new AdCreateTransaction($em, $this->ad);
        $transaction();

        $this->assertTrue($em->isFlushed($this->ad));
        $this->assertTrue($em->isFlushed($guest));
    }
}
