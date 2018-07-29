<?php

namespace DinnerBundle\Command;

use DinnerBundle\Loader\Loader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractLoadCommand extends Command
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        parent::__construct();
    }

    protected function configure()
    {
        $this->addArgument('file', InputArgument::REQUIRED);
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
            $columns = array_pad(explode("\t", $line), count($fields), '');
            $row = array_combine($fields, $columns);
            $loader->load($row, $output);
        }

        $output->writeln('Flushing changes');

        $this->em->flush();
    }

    abstract protected function loader(): Loader;
}
