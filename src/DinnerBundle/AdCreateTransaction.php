<?php

namespace DinnerBundle;

use DinnerBundle\Entity\Ad;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;

class AdCreateTransaction
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var Ad
     */
    private $ad;

    public function __construct(ObjectManager $em, Ad $ad)
    {
        $this->em = $em;
        $this->ad = $ad;
    }

    public function persist(): void
    {
        $this->ad->adType->typeAccessionCount++;
        $this->ad->typeAccession = (new TypeAccession($this->ad))->toString();
        $this->em->persist($this->ad);
        $this->em->persist($this->ad->adType);
        $this->em->flush();
    }
}
