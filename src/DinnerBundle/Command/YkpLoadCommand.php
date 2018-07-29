<?php

namespace DinnerBundle\Command;

use DinnerBundle\Loader\Loader;
use DinnerBundle\Loader\YKP;

class YkpLoadCommand extends AbstractLoadCommand
{
    protected function configure()
    {
        parent::configure();
        $this->setName('dinner:load:ykp');
    }

    protected function loader(): Loader
    {
        return new YKP($this->em);
    }
}
