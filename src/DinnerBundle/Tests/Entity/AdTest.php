<?php

namespace DinnerBundle\Tests\Entity;

use DinnerBundle\Entity\Ad;
use DinnerBundle\Entity\AdType;
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
    public function stringCastShortCopy()
    {
        $this->ad->copy = 'abc';
        $this->assertEquals('Gold-123: abc', (string) $this->ad);
    }

    /**
     * @test
     */
    public function stringCastCopyTooLong()
    {
        $this->ad->copy = 'abcdefghijklmnopqrstuvwxyz';
        $this->assertEquals('Gold-123: abcdefghijklmnopqrstuvwxy...', (string) $this->ad);
    }
}
