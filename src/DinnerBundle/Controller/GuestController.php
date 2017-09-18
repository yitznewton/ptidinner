<?php

namespace DinnerBundle\Controller;

use DinnerBundle\Entity\Guest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Guest controller.
 *
 * @Route("guest")
 */
class GuestController extends Controller
{
    /**
     * Lists all guest entities.
     *
     * @Route("/", name="guest_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $guests = $em->getRepository('DinnerBundle:Guest')->findAll();

        return $this->render('guest/index.html.twig', array(
            'guests' => $guests,
        ));
    }

    /**
     * Creates a new guest entity.
     *
     * @Route("/new", name="guest_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $guest = new Guest();
        $form = $this->createForm('DinnerBundle\Form\GuestType', $guest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($guest);
            $em->flush();

            return $this->redirectToRoute('guest_show', array('id' => $guest->getId()));
        }

        return $this->render('guest/new.html.twig', array(
            'guest' => $guest,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a guest entity.
     *
     * @Route("/{id}", name="guest_show")
     * @Method("GET")
     */
    public function showAction(Guest $guest)
    {
        $deleteForm = $this->createDeleteForm($guest);

        return $this->render('guest/show.html.twig', array(
            'guest' => $guest,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing guest entity.
     *
     * @Route("/{id}/edit", name="guest_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Guest $guest)
    {
        $deleteForm = $this->createDeleteForm($guest);
        $editForm = $this->createForm('DinnerBundle\Form\GuestType', $guest);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('guest_edit', array('id' => $guest->getId()));
        }

        return $this->render('guest/edit.html.twig', array(
            'guest' => $guest,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a guest entity.
     *
     * @Route("/{id}", name="guest_delete")
     * @Method("DELETE")
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
     * Creates a form to delete a guest entity.
     *
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
