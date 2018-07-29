<?php

namespace DinnerBundle\Tests;

use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class EntityAwareTestCase extends KernelTestCase
{
    /** @var \Doctrine\ORM\EntityManager */
    protected $em;

    public function setUp()
    {
        KernelTestCase::bootKernel();

        $this->em = KernelTestCase::$kernel->getContainer()->get('doctrine.orm.entity_manager');

        $metadata = $this->em->getMetadataFactory()->getAllMetadata();
        $schemaTool = new SchemaTool($this->em);
        $schemaTool->updateSchema($metadata);
    }
}
