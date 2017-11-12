<?php

namespace DinnerBundle\Loader;

use DinnerBundle\Entity\Guest;
use DinnerBundle\Entity\Honoree;
use DinnerBundle\Repository\GuestRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Output\OutputInterface;

class PTI implements Loader
{
    /** @var EntityManager */
    private $em;

    /** @var GuestRepository */
    private $guestRepository;
    private $outOfTown;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->guestRepository = $this->em->getRepository('DinnerBundle:Guest');
        $this->outOfTown = $this->em->getRepository(Honoree::class)->findOneBy(['code' => 'OOT']);
    }

    public function load(array $row, OutputInterface $output): void
    {
        $guest = $this->matchOnNames($row) ?: new Guest();
        $this->updateGuest($row, $guest);

        $output->writeln('Updating guest ' . $guest->__toString());

        $this->em->persist($guest);
    }

    private function matchOnNames(array $row): ?Guest
    {
        return $this->guestRepository->findOneBy([
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
        $guest->streetAddress = $guest->streetAddress ?: $row['streetAddress'];
        $guest->city = $guest->city ?: $row['city'];
        $guest->state = $guest->state ?: $row['state'];
        $guest->zip = $guest->zip ?: $row['zip'];
        $guest->phone = $guest->phone ?: $row['phone'];
        $guest->mobile = $guest->mobile ?: $row['mobile'];

        if (!in_array($guest->city, ['Passaic', 'Clifton'])) {
            $guest->honorees->add($this->outOfTown);
        }
    }
}
