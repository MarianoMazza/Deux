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
     * @Route("/admin/tiposDeHospedaje", name="_tipos")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tipoHospedajes = $em->getRepository('AppBundle:TipoHospedaje')->findAll();

        return $this->render(':default/tipoHospedaje:tiposHospedaje.html.twig', array(
            'tipos' => $tipoHospedajes,
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

            return $this->redirectToRoute('_hecho', array('id' => $tipoHospedaje->getId()));

        }

        return $this->render(':default/publicacion:altaTipoHospedaje.html.twig', array(
            'tipoHospedaje' => $tipoHospedaje,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TipoHospedaje entity.
     * @Route("/admin/modificarTipo/{id}", name="_modificartipo")
     */
    public function editAction(Request $request, $id)
    {
        $tipoHospedaje = $this->getDoctrine()->getRepository('AppBundle:TipoHospedaje')->find($id);
        $deleteForm = $this->createDeleteForm($tipoHospedaje);
        $editForm = $this->createForm('AppBundle\Form\TipoHospedajeType', $tipoHospedaje);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tipoHospedaje);
            $em->flush();

            return $this->redirectToRoute('_hecho', array('id' => $tipoHospedaje->getId()));
        }

        return $this->render(':default/tipoHospedaje:modificarTipoHospedaje.html.twig', array(
            'tipoHospedaje' => $tipoHospedaje,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TipoHospedaje entity.
     *  @Route("/admin/eliminarTipo/{id}", name="_eliminarTipo")
     */
    public function deleteAction(Request $request, $id)
    {
        $tipoHospedaje = $this->getDoctrine()->getRepository('AppBundle:TipoHospedaje')->find($id);
        $form = $this->createDeleteForm($tipoHospedaje);
        $form->handleRequest($request);

        if (!empty($tipoHospedaje)) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tipoHospedaje);
            $em->flush();
        }

        return $this->redirectToRoute('_hecho');
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
            ->setAction($this->generateUrl('_eliminarTipo', array('id' => $tipoHospedaje->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
