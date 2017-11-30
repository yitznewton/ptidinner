<?php

namespace DinnerBundle\Tests\EventListener;

use DinnerBundle\Entity\Ad;
use DinnerBundle\Entity\AdType;
use DinnerBundle\Tests\EntityAwareTestCase;

class AdTypeAccessionTest extends EntityAwareTestCase
{
    /** @test */
    public function changes_type_accession_when_inserting()
    {
        $goldType = new AdType();
        $goldType->label = 'Gold';
        $goldType->code = 'G';
        $goldType->price = 500;
        $goldType->perPage = 1;

        $fullType = new AdType();
        $fullType->label = 'Full';
        $fullType->code = 'F';
        $fullType->price = 500;
        $fullType->perPage = 1;

        $firstAd = new Ad();
        $firstAd->adType = $goldType;
        $secondAd = new Ad();
        $secondAd->adType = $goldType;
        $thirdAd = new Ad();
        $thirdAd->adType = $fullType;

        $this->em->persist($goldType);
        $this->em->persist($fullType);
        $this->em->persist($firstAd);
        $this->em->persist($secondAd);
        $this->em->persist($thirdAd);
        $this->em->flush();

        $this->assertEquals('G-001', $firstAd->typeAccession);
        $this->assertEquals('G-002', $secondAd->typeAccession);
        $this->assertEquals('F-001', $thirdAd->typeAccession);
    }

    /** @test */
    public function changes_type_accession_when_changing_ad_type()
    {
        $goldType = new AdType();
        $goldType->label = 'Gold';
        $goldType->code = 'G';
        $goldType->price = 500;
        $goldType->perPage = 1;

        $fullType = new AdType();
        $fullType->label = 'Full';
        $fullType->code = 'F';
        $fullType->price = 500;
        $fullType->perPage = 1;

        $ad = new Ad();
        $ad->adType = $goldType;

        $this->em->persist($goldType);
        $this->em->persist($fullType);
        $this->em->persist($ad);
        $this->em->flush();

        $ad->adType = $fullType;

        $this->em->persist($ad);
        $this->em->flush();

        $this->assertEquals('F-001', $ad->typeAccession);
    }

    /** @test */
    public function does_not_change_type_accession_when_modifying_other_fields()
    {
        $adType = new AdType();
        $adType->label = 'Gold';
        $adType->code = 'G';
        $adType->price = 500;
        $adType->perPage = 1;

        $ad = new Ad();
        $ad->adType = $adType;

        $this->em->persist($adType);
        $this->em->persist($ad);
        $this->em->flush();

        $ad->copy = 'Foo';

        $this->em->persist($ad);
        $this->em->flush();

        $this->assertEquals('G-001', $ad->typeAccession);
    }
}
