<?php

namespace DinnerBundle\Loader;

use DinnerBundle\Entity\Guest;
use DinnerBundle\Repository\GuestRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Output\OutputInterface;

class YKP implements Loader
{
    /** @var EntityManager */
    private $em;

    /** @var GuestRepository */
    private $repository;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository('DinnerBundle:Guest');
    }

    public function load(array $row, OutputInterface $output): void
    {
        $guest = $this->matchOnId($row) ?: $this->matchOnNames($row) ?: new Guest();
        $this->updateGuest($row, $guest);

        $output->writeln('Updating guest ' . $guest->__toString());

        $this->em->persist($guest);
    }

    private function matchOnId(array $row): ?Guest
    {
        return $this->repository->findOneBy(['ykpId' => $row['ykpId']]);
    }

    private function matchOnNames(array $row): ?Guest
    {
        return $this->repository->findOneBy([
            'familyName' => $row['familyName'],
            'hisName' => $row['hisName'],
            'herName' => $row['herName'],
        ]);
    }

    private function updateGuest(array $row, Guest $guest)
    {
        $guest->familyName = $guest->familyName ?: $row['familyName'];
        $guest->hisName = $guest->hisName ?: $row['hisName'];
        $guest->herName = $guest->herName ?: $row['herName'];
        $guest->ykpId = $guest->ykpId ?: $row['ykpId'];

        $guest->streetAddress = $row['streetAddress'];
        $guest->city = $row['city'];
        $guest->state = $row['state'];
        $guest->zip = $row['zip'];
        $guest->phone = $row['phone'];
    }
}
