<?php

namespace DinnerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ReportController extends Controller
{
    /**
     * @Route("/reports/seated", name="report_seated")
     */
    public function seatedAction()
    {
        $em = $this->getDoctrine()->getManager();
        $guests = $em->getRepository('DinnerBundle:Guest')->seated();

        return $this->render('DinnerBundle:Report:seated.html.twig', [
            'guests' => $guests,
            'totals' => $em->getRepository('DinnerBundle:Guest')->totals(),
        ]);
    }

    /**
     * @Route("/reports/pledged-not-paid", name="report_pledged_not_paid")
     */
    public function pledgedNotPaidAction()
    {

        $em = $this->getDoctrine()->getManager();
        $guests = $em->getRepository('DinnerBundle:Guest')->pledgedNotPaid();

        return $this->render('DinnerBundle:Report:pledged_not_paid.html.twig', [
            'guests' => $guests,
            'totals' => $em->getRepository('DinnerBundle:Guest')->totals(),
        ]);
    }
}
