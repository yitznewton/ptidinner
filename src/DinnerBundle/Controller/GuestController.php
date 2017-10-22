<?php

namespace DinnerBundle\Controller;

use DinnerBundle\Entity\Guest;
use DinnerBundle\Form\GuestType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("guests")
 */
class GuestController extends Controller
{
    /**
     * @Route("/", name="guest_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $guests = $em->getRepository('DinnerBundle:Guest')->findAll();

        return $this->render('@Dinner/Guest/index.html.twig', array(
            'guests' => $guests,
            'totals' => $em->getRepository('DinnerBundle:Guest')->totals(),
        ));
    }

    /**
     * @Route("/new", name="guest_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $guest = new Guest();
        $form = $this->createForm(GuestType::class, $guest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($guest);
            $em->flush();

            return $this->redirectToRoute('guest_edit', array('id' => $guest->getId()));
        }

        return $this->render('@Dinner/Guest/new.html.twig', array(
            'guest' => $guest,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}/edit", name="guest_edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Guest $guest
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Guest $guest)
    {
        $deleteForm = $this->createDeleteForm($guest);
        $editForm = $this->createForm(GuestType::class, $guest);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('guest_edit', array('id' => $guest->getId()));
        }

        return $this->render('@Dinner/Guest/edit.html.twig', array(
            'guest' => $guest,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @Route("/{id}", name="guest_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param Guest $guest
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Guest $guest)
    {
        $form = $this->createDeleteForm($guest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($guest);
            $em->flush();
        }

        return $this->redirectToRoute('guest_index');
    }

    /**
     * @param Guest $guest The guest entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Guest $guest)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('guest_delete', array('id' => $guest->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
