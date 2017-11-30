<?php

namespace DinnerBundle\Transaction;

use DinnerBundle\Entity\Ad;
use DinnerBundle\TypeAccession;
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

    public function __invoke(): void
    {
        $this->ad->adType->typeAccessionCount++;
        $this->ad->typeAccession = (new TypeAccession($this->ad))->toString();

        foreach ($this->ad->guests as $guest) {
            $guest->ads->add($this->ad);
            $guest->updateAdTypes();
            $this->em->persist($guest);
        }

        $this->em->persist($this->ad);
        $this->em->persist($this->ad->adType);
        $this->em->flush();
    }
}
