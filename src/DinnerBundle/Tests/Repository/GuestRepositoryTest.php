<?php

namespace DinnerBundle\Tests\Repository;

use DinnerBundle\Entity\Guest;
use DinnerBundle\Tests\EntityAwareTestCase;
use nemesis\Doctrine\Hydrator\ArrayHydrator;
use function iter\map;
use function iter\toArray;

class GuestRepositoryTest extends EntityAwareTestCase
{
    /** @var ArrayHydrator */
    private $hydrator;

    /** @var \DinnerBundle\Repository\GuestRepository */
    private $repository;

    public function setUp()
    {
        parent::setUp();
        $this->hydrator = new ArrayHydrator($this->em);
        $this->repository = $this->em->getRepository(Guest::class);
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

    /**
     * @test
     */
    public function pledged_not_paid()
    {
        $zeroPledgeGuest = $this->hydrate(['family_name' => 'Abel', 'pledge_2018' => 0.0, 'paid' => 0.0]);
        $paidUpGuest = $this->hydrate(['family_name' => 'Johnson', 'pledge_2018' => 100.0, 'paid' => 100.0]);
        $unpaidGuest = $this->hydrate(['family_name' => 'Stetson', 'pledge_2018' => 100.0, 'paid' => 0.0]);
        $underPaidGuest = $this->hydrate(['family_name' => 'Yterby', 'pledge_2018' => 100.0, 'paid' => 99.0]);

        $this->em->persist($underPaidGuest);
        $this->em->persist($paidUpGuest);
        $this->em->persist($unpaidGuest);
        $this->em->persist($zeroPledgeGuest);
        $this->em->flush();

        $this->assertEquals(['Stetson', 'Yterby'], toArray(map(function ($g) {
            return $g->familyName;
        }, $this->repository->pledgedNotPaid())));
    }

    /**
     * @test
     */
    public function past_donor_no_pledge()
    {
        $neverPledgedGuest = $this->hydrate(['family_name' => 'Abel', 'pledge_2018' => 0.0, 'pledge_2017' => 0.0]);
        $underPledgedGuest = $this->hydrate(['family_name' => 'Stetson', 'pledge_2018' => 55.0, 'pledge_2017' => 100.0]);
        $pastDonorNoPledgeGuest = $this->hydrate(['family_name' => 'Yterby', 'pledge_2018' => 0.0, 'pledge_2017' => 100.0]);

        $this->em->persist($pastDonorNoPledgeGuest);
        $this->em->persist($underPledgedGuest);
        $this->em->persist($neverPledgedGuest);
        $this->em->flush();

        $this->assertEquals(['Yterby'], toArray(map(function ($g) {
            return $g->familyName;
        }, $this->repository->pastDonorNoPledge())));
    }

    private function hydrate($data)
    {
        return $this->hydrator->hydrate(Guest::class, $data);
    }
}
