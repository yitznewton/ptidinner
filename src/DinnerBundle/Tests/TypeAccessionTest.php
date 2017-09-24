<?php

namespace DinnerBundle\Tests;

use DinnerBundle\TypeAccession;
use DinnerBundle\Entity\Ad;
use DinnerBundle\Entity\AdType;
use PHPUnit\Framework\TestCase;

class TypeAccessionTest extends TestCase
{
    /**
     * @test
     */
    public function returns_correct_value()
    {
        $adType = new AdType();
        $adType->code = 'Full';
        $adType->typeAccessionCount = 1;

        $ad = new Ad();
        $ad->adType = $adType;

        $typeAccession = new TypeAccession($ad);

        $this->assertEquals('Full-001', $typeAccession->toString());
    }
}
