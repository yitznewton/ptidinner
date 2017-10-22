<?php

use DinnerBundle\Entity\Guest;
use Doctrine\ORM\Tools\SchemaTool;
use function iter\map;
use function iter\toArray;
use nemesis\Doctrine\Hydrator\ArrayHydrator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GuestRepositoryTest extends KernelTestCase
{
    /** @var \Doctrine\ORM\EntityManager */
    private $em;

    /** @var \DinnerBundle\Repository\GuestRepository */
    private $repository;

    /** @var ArrayHydrator */
    private $hydrator;

    public function setUp()
    {
        self::bootKernel();

        $this->em = self::$kernel->getContainer()->get('doctrine')->getManager();
        $this->repository = $this->em->getRepository(Guest::class);
        $this->hydrator = new ArrayHydrator($this->em);

        $metadata = $this->em->getMetadataFactory()->getAllMetadata();
        $schemaTool = new SchemaTool($this->em);
        $schemaTool->updateSchema($metadata);
    }

    /**
     * @test
     */
    public function seated_includes_sorted_comp_and_paid_seated_only()
    {
        $compSeatedGuest = $this->hydrate(['family_name' => 'Abel', 'comp_seats' => 1]);
        $paidSeatedGuest = $this->hydrate(['family_name' => 'Johnson', 'paid_seats' => 1]);
        $nonSeatedGuest = $this->hydrate(['family_name' => 'Yterby']);

        $this->em->persist($paidSeatedGuest);
        $this->em->persist($compSeatedGuest);
        $this->em->persist($nonSeatedGuest);
        $this->em->flush();

        $this->assertEquals(['Abel', 'Johnson'], toArray(map(function ($g) {
            return $g->familyName;
        }, $this->repository->seated())));
    }

    private function hydrate($data)
    {
        return $this->hydrator->hydrate(Guest::class, $data);
    }
}
