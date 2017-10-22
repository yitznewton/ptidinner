<?php

use DinnerBundle\Entity\Guest;
use Doctrine\ORM\Tools\SchemaTool;
use function iter\map;
use function iter\toArray;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GuestRepositoryTest extends KernelTestCase
{
    /** @var \Doctrine\ORM\EntityManager */
    private $em;

    /** @var \DinnerBundle\Repository\GuestRepository */
    private $repository;

    public function setUp()
    {
        self::bootKernel();

        $this->em = self::$kernel->getContainer()->get('doctrine')->getManager();
        $this->repository = $this->em->getRepository(Guest::class);

        $metadata = $this->em->getMetadataFactory()->getAllMetadata();
        $schemaTool = new SchemaTool($this->em);
        $schemaTool->updateSchema($metadata);
    }

    /**
     * @test
     */
    public function seated_includes_sorted_comp_and_paid_seated_only()
    {
        $compSeatedGuest = $this->hydrate(['familyName' => 'Abel', 'compSeats' => 1]);
        $paidSeatedGuest = $this->hydrate(['familyName' => 'Johnson', 'paidSeats' => 1]);
        $nonSeatedGuest = $this->hydrate(['familyName' => 'Yterby']);

        $this->em->persist($paidSeatedGuest);
        $this->em->persist($compSeatedGuest);
        $this->em->persist($nonSeatedGuest);
        $this->em->flush();

        $this->assertEquals(['Abel', 'Johnson'], toArray(map(function ($g) { return $g->familyName; }, $this->repository->seated())));
    }

    private function hydrate($data)
    {
        $guest = new Guest();

        foreach ($data as $name => $value) {
            $guest->$name = $value;
        }

        return $guest;
    }
}
