<?php

namespace DinnerBundle\EventListener;

use DinnerBundle\Entity\Ad;
use DinnerBundle\Entity\AdType;
use DinnerBundle\TypeAccession;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\UnitOfWork;

class AdTypeAccession
{
    public function onFlush(OnFlushEventArgs $args)
    {
        $em = $args->getEntityManager();
        $uow = $em->getUnitOfWork();

        foreach ($this->updatedAds($uow) as $ad) {
            $this->updateTypeAccession($ad, $uow, $em);
        }
    }

    private function updatedAds(UnitOfWork $uow): array
    {
        $updates = array_merge($uow->getScheduledEntityUpdates(), $uow->getScheduledEntityInsertions());

        return array_values(array_filter($updates, function ($u) {
            return $u instanceof Ad;
        }));
    }

    private function updateTypeAccession(Ad $ad, UnitOfWork $uow, EntityManager $em): void
    {
        $changes = $uow->getEntityChangeSet($ad);

        if (isset($changes['adType'])) {
            $adType = $ad->adType;
            $adType->typeAccessionCount++;
            $ad->typeAccession = (new TypeAccession($ad))->toString();

            $adMetadata = $em->getClassMetadata(Ad::class);
            $adTypeMetadata = $em->getClassMetadata(AdType::class);

            $uow->recomputeSingleEntityChangeSet($adMetadata, $ad);
            $uow->recomputeSingleEntityChangeSet($adTypeMetadata, $adType);
        }
    }
}
