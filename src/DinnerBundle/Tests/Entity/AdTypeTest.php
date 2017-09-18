<?php

namespace DinnerBundle\Tests\Entity;

use DinnerBundle\Entity\AdType;
use PHPUnit\Framework\TestCase;

class AdTypeTest extends TestCase
{
    private $adType;

    protected function setUp()
    {
        $this->adType = new AdType();
        $this->adType->label = 'Gold';
    }

    /**
     * @test
     */
    public function stringCast()
    {
        $this->assertEquals('Gold', (string) $this->adType);
    }
}
