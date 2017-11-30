<?php

namespace DinnerBundle\Tests\Repository;

use DinnerBundle\Entity\Ad;
use DinnerBundle\Entity\AdType;
use DinnerBundle\Entity\Guest;
use function iter\map;
use function iter\toArray;

class AdRepositoryTest extends RepositoryTestCase
{
    static protected function entityClass(): string
    {
        return Ad::class;
    }

    /**
     * @test
     */
    public function deleting_updates_guest_ad_types_string()
    {
        $adType = new AdType();
        $adType->code = 'G';
        $adType->label = 'Gold';
        $adType->price = 500;
        $adType->perPage = 1;
        $this->em->persist($adType);

        $ad = new Ad();
        $ad->adType = $adType;
        $this->em->persist($ad);

        $guest = new Guest();
        $guest->familyName = 'Smith';
        $ad->guests->add($guest);
        $guest->ads->add($ad);
        $this->em->persist($guest);

        $this->assertEquals('Gold', $guest->adTypesString);

        $this->em->remove($ad);
        $this->assertEquals('', $guest->adTypesString);
    }
}
