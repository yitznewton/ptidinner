<?php

namespace DinnerBundle\Command;

use DinnerBundle\Entity\Guest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateGuestAdTypesStringCommand extends Command
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('dinner:update-guest-ad-types');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var Guest $guest */
        foreach ($this->em->getRepository(Guest::class)->findAll() as $guest) {
            $guest->updateAdTypes();
        }

        $this->em->flush();
    }
}
