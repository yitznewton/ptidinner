<?php

namespace DinnerBundle\Transaction;

use DinnerBundle\Entity\Ad;
use DinnerBundle\TypeAccession;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;

class AdDeleteTransaction
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
        foreach ($this->ad->guests as $guest) {
            $guest->ads->removeElement($this->ad);
            $guest->updateAdTypes();
            $this->em->persist($guest);
        }

        $this->em->remove($this->ad);
        $this->em->flush();
    }
}
