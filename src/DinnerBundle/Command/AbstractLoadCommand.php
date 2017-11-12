<?php

namespace DinnerBundle\Command;

use DinnerBundle\Loader\Loader;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractLoadCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->addArgument('file', InputArgument::REQUIRED);
    }

    protected function em(): EntityManager
    {
        return $this->getContainer()->get('doctrine.orm.entity_manager');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $loader = $this->loader();

        $filename = $input->getArgument('file');

        if (!file_exists($filename)) {
            throw new \RuntimeException('File does not exist');
        }

        $fh = fopen($filename, 'r');

        $fields = explode("\t", trim(fgets($fh)));

        while ($line = trim(fgets($fh))) {
            $row = array_combine($fields, explode("\t", $line));
            $loader->load($row, $output);
        }

        $output->writeln('Flushing changes');

        $this->em()->flush();
    }

    abstract protected function loader(): Loader;
}
