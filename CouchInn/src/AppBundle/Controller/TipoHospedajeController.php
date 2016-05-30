<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\TipoHospedaje;
use AppBundle\Form\TipoHospedajeType;

/**
 * TipoHospedaje controller.
 *
 */
class TipoHospedajeController extends Controller
{
    /**
     * Lists all TipoHospedaje entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tipoHospedajes = $em->getRepository('AppBundle:TipoHospedaje')->findAll();

        return $this->render('tipohospedaje/index.html.twig', array(
            'tipoHospedajes' => $tipoHospedajes,
        ));
    }

    /**
     * Creates a new TipoHospedaje entity.
     * @Route("/tipoHospedaje", name="_tipoHospedaje")
     */
    public function newAction(Request $request)
    {
        $tipoHospedaje = new TipoHospedaje();
        $form = $this->createForm('AppBundle\Form\TipoHospedajeType', $tipoHospedaje);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tipoHospedaje);
            $em->flush();

            return $this->redirectToRoute('yes_show', array('id' => $tipoHospedaje->getId()));
        }

        return $this->render('default/publicacion/tipoHospedaje.html.twig', array(
            'tipoHospedaje' => $tipoHospedaje,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TipoHospedaje entity.
     *
     */
    public function showAction(TipoHospedaje $tipoHospedaje)
    {
        $deleteForm = $this->createDeleteForm($tipoHospedaje);

        return $this->render('tipohospedaje/show.html.twig', array(
            'tipoHospedaje' => $tipoHospedaje,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TipoHospedaje entity.
     *
     */
    public function editAction(Request $request, TipoHospedaje $tipoHospedaje)
    {
        $deleteForm = $this->createDeleteForm($tipoHospedaje);
        $editForm = $this->createForm('AppBundle\Form\TipoHospedajeType', $tipoHospedaje);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tipoHospedaje);
            $em->flush();

            return $this->redirectToRoute('yes_edit', array('id' => $tipoHospedaje->getId()));
        }

        return $this->render('tipohospedaje/edit.html.twig', array(
            'tipoHospedaje' => $tipoHospedaje,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TipoHospedaje entity.
     *
     */
    public function deleteAction(Request $request, TipoHospedaje $tipoHospedaje)
    {
        $form = $this->createDeleteForm($tipoHospedaje);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tipoHospedaje);
            $em->flush();
        }

        return $this->redirectToRoute('yes_index');
    }

    /**
     * Creates a form to delete a TipoHospedaje entity.
     *
     * @param TipoHospedaje $tipoHospedaje The TipoHospedaje entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TipoHospedaje $tipoHospedaje)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('yes_delete', array('id' => $tipoHospedaje->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
