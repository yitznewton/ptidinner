<?php

namespace DinnerBundle\Tests\Repository;

use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class RepositoryTestCase extends KernelTestCase
{
    /** @var \Doctrine\ORM\EntityManager */
    protected $em;

    public function setUp()
    {
        KernelTestCase::bootKernel();

        $this->em = KernelTestCase::$kernel->getContainer()->get('doctrine')->getManager();

        $metadata = $this->em->getMetadataFactory()->getAllMetadata();
        $schemaTool = new SchemaTool($this->em);
        $schemaTool->updateSchema($metadata);
    }
}
