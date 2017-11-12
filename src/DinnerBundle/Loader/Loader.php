<?php

namespace DinnerBundle\Loader;

use Symfony\Component\Console\Output\OutputInterface;

interface Loader
{
    public function load(array $row, OutputInterface $output): void;
}
