<?php

namespace DinnerBundle\Controller;

use DinnerBundle\Form\AdType;
use DinnerBundle\Transaction\AdCreateTransaction;
use DinnerBundle\Entity\Ad;
use DinnerBundle\Entity\Guest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("ad")
 */
class AdController extends Controller
{
    /**
     * @Route("/", name="ad_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $ads = $em->getRepository('DinnerBundle:Ad')->findAll();

        return $this->render('@Dinner/Ad/index.html.twig', array(
            'ads' => $ads,
        ));
    }

    /**
     * @Route("/new", name="ad_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $ad = new Ad();
        $form = $this->createForm(AdType::class, $ad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->persistAd($ad);
        }

        return $this->render('@Dinner/Ad/new.html.twig', array(
            'ad' => $ad,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/new/guest/{id}", name="ad_new_for_guest")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Guest $guest
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newForGuestAction(Request $request, Guest $guest)
    {
        $ad = new Ad();
        $ad->guests->add($guest);
        $form = $this->createForm(AdType::class, $ad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->persistAd($ad);
        }

        return $this->render('@Dinner/Ad/new.html.twig', array(
            'ad' => $ad,
            'guest' => $guest,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}/edit", name="ad_edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Ad $ad
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Ad $ad)
    {
        $deleteForm = $this->createDeleteForm($ad);
        $editForm = $this->createForm(AdType::class, $ad);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ad_edit', array('id' => $ad->getId()));
        }

        return $this->render('@Dinner/Ad/edit.html.twig', array(
            'ad' => $ad,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @Route("/{id}", name="ad_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param Ad $ad
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Ad $ad)
    {
        $form = $this->createDeleteForm($ad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ad);
            $em->flush();
        }

        return $this->redirectToRoute('ad_index');
    }

    /**
     * @param Ad $ad The ad entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Ad $ad)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ad_delete', array('id' => $ad->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    private function persistAd(Ad $ad)
    {
        $em = $this->getDoctrine()->getManager();
        (new AdCreateTransaction($em, $ad))();

        return $this->redirectToRoute('ad_edit', array('id' => $ad->getId()));
    }
}
