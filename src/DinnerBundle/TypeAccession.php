<?php

namespace DinnerBundle;

use DinnerBundle\Entity\Ad;

class TypeAccession
{
    /**
     * @var Ad
     */
    private $ad;

    public function __construct(Ad $ad)
    {
        $this->ad = $ad;
    }

    public function toString(): string
    {
        $adType = $this->ad->adType;
        $count = sprintf("%03s", $adType->typeAccessionCount);

        return "{$adType->code}-$count";
    }
}
