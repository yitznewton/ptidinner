<?php

namespace DinnerBundle\Command;

use DinnerBundle\Loader\Loader;
use DinnerBundle\Loader\PTI;

class PtiLoadCommand extends AbstractLoadCommand
{
    protected function configure()
    {
        parent::configure();
        $this->setName('dinner:load:pti');
    }

    protected function loader(): Loader
    {
        return new PTI($this->em());
    }
}
