<?php

namespace DinnerBundle\Tests\Transaction;

use DinnerBundle\Entity\Ad;
use DinnerBundle\Entity\AdType;
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
    public function increments_accession_on_ad_type()
    {
        $em = new MockObjectManager();
        $transaction = new AdCreateTransaction($em, $this->ad);
        $transaction();

        $this->assertEquals(3, $this->adType->typeAccessionCount);
    }

    /** @test */
    public function sets_type_accession_on_ad()
    {
        $em = new MockObjectManager();
        $transaction = new AdCreateTransaction($em, $this->ad);
        $transaction();

        $this->assertEquals('Full-003', $this->ad->typeAccession);
    }

    /** @test */
    public function persists_ad_and_type()
    {
        $em = new MockObjectManager();
        $transaction = new AdCreateTransaction($em, $this->ad);
        $transaction();

        $this->assertTrue($em->isPersisted([$this->ad, $this->adType]));
    }
}
