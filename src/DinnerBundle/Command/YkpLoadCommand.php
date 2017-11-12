<?php

namespace DinnerBundle\Command;

use DinnerBundle\Loader\YKP;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class YkpLoadCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('dinner:load:ykp')
            ->addArgument('file', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $loader = new YKP($em);

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
    }
}
