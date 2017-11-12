<?php

namespace DinnerBundle\Command;

use DinnerBundle\Entity\Ad;
use DinnerBundle\Entity\Guest;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ResetAdsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('dinner:reset-ads');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        /** @var Guest $guest */
        foreach ($em->getRepository(Guest::class)->findAll() as $guest) {
            /** @var Ad $ad */
            foreach ($guest->ads as $ad) {
                $guest->previousAdCopy .= "\n\n===========\n\n" . $ad->copy;
            }

            $guest->ads->clear();
        }

        $em->getRepository(Ad::class)->clear();

        $em->flush();
    }
}
