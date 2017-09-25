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
    public function string_cast()
    {
        $this->assertEquals('Gold', (string) $this->adType);
    }
}
