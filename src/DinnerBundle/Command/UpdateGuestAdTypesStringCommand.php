<?php

namespace DinnerBundle\Command;

use DinnerBundle\Entity\Guest;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateGuestAdTypesStringCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('dinner:update-guest-ad-types');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        /** @var Guest $guest */
        foreach ($em->getRepository(Guest::class)->findAll() as $guest) {
            $guest->updateAdTypes();
        }

        $em->flush();
    }
}
