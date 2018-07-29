<?php

namespace DinnerBundle\Command;

use DinnerBundle\Entity\Ad;
use DinnerBundle\Entity\Guest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ResetAdsCommand extends Command
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('dinner:reset-ads');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var Guest $guest */
        foreach ($this->em->getRepository(Guest::class)->findAll() as $guest) {
            /** @var Ad $ad */
            foreach ($guest->ads as $ad) {
                $guest->previousAdCopy .= "\n\n===========\n\n" . $ad->copy;
            }
        }

        $this->em->createQueryBuilder()->delete(Ad::class)->getQuery()->execute();
        $this->em->flush();
    }
}
