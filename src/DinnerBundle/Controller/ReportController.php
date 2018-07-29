<?php

namespace DinnerBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reports")
 */
class ReportController extends Controller
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/")
     */
    public function indexRedirectAction()
    {
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/seated", name="report_seated")
     */
    public function seatedAction()
    {
        $guests = $this->em->getRepository('DinnerBundle:Guest')->seated();

        return $this->render('DinnerBundle:Report:seated.html.twig', [
            'guests' => $guests,
            'totals' => $this->em->getRepository('DinnerBundle:Guest')->totals(),
        ]);
    }

    /**
     * @Route("/all-pledges", name="report_pledged")
     */
    public function pledgedAction()
    {
        $guests = $this->em->getRepository('DinnerBundle:Guest')->pledged();

        return $this->render('DinnerBundle:Report:pledged.html.twig', [
            'guests' => $guests,
            'totals' => $this->em->getRepository('DinnerBundle:Guest')->totals(),
        ]);
    }

    /**
     * @Route("/pledged-not-paid", name="report_pledged_not_paid")
     */
    public function pledgedNotPaidAction()
    {
        $guests = $this->em->getRepository('DinnerBundle:Guest')->pledgedNotPaid();

        return $this->render('DinnerBundle:Report:pledged_not_paid.html.twig', [
            'guests' => $guests,
            'totals' => $this->em->getRepository('DinnerBundle:Guest')->totals(),
        ]);
    }

    /**
     * @Route("/reports/past-donor-no-pledge", name="report_past_donor_no_pledge")
     */
    public function pastDonorNoPledgeAction()
    {
        $guests = $this->em->getRepository('DinnerBundle:Guest')->pastDonorNoPledge();

        return $this->render('DinnerBundle:Report:past_donor_no_pledge.html.twig', [
            'guests' => $guests,
            'totals' => $this->em->getRepository('DinnerBundle:Guest')->totals(),
        ]);
    }

    public function totalsAction()
    {
        return $this->render('@Dinner/Report/totals.html.twig', [
            'totals' => $this->em->getRepository('DinnerBundle:Guest')->totals(),
        ]);
    }
}
