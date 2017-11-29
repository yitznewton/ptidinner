<?php

namespace DinnerBundle\Tests\Repository;

use Doctrine\ORM\Tools\SchemaTool;
use nemesis\Doctrine\Hydrator\ArrayHydrator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class RepositoryTestCase extends KernelTestCase
{
    /** @var ArrayHydrator */
    private $hydrator;

    /** @var \Doctrine\ORM\EntityManager */
    protected $em;

    /** @var \DinnerBundle\Repository\GuestRepository */
    protected $repository;

    public function setUp()
    {
        KernelTestCase::bootKernel();

        $this->em = KernelTestCase::$kernel->getContainer()->get('doctrine')->getManager();
        $this->repository = $this->em->getRepository(static::entityClass());
        $this->hydrator = new ArrayHydrator($this->em);

        $metadata = $this->em->getMetadataFactory()->getAllMetadata();
        $schemaTool = new SchemaTool($this->em);
        $schemaTool->updateSchema($metadata);
    }

    protected function hydrate($data)
    {
        return $this->hydrator->hydrate(static::entityClass(), $data);
    }

    abstract static protected function entityClass(): string;
}
