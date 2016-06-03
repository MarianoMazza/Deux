<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\CalificacionPublicacion;
use AppBundle\Form\CalificacionPublicacionType;

/**
 * CalificacionPublicacion controller.
 *
 */
class CalificacionPublicacionController extends Controller
{
    /**
     * Lists all CalificacionPublicacion entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $calificacionPublicacions = $em->getRepository('AppBundle:CalificacionPublicacion')->findAll();

        return $this->render('calificacionpublicacion/index.html.twig', array(
            'calificacionPublicacions' => $calificacionPublicacions,
        ));
    }

    /**
     * Creates a new CalificacionPublicacion entity.
     * @Route("/calificacionPublicacion", name="_calificacionPublicacion")
     */
    public function newAction(Request $request)
    {
        $calificacionPublicacion = new CalificacionPublicacion();
        $calificacionPublicacion->setDeUsuario($this->getUser());
        $form = $this->createForm('AppBundle\Form\CalificacionPublicacionType', $calificacionPublicacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($calificacionPublicacion);
            $em->flush();

            return $this->redirectToRoute('calificacionpublicacion_show', array('id' => $calificacionPublicacion->getId()));
        }

        return $this->render(':default/publicacion:calificacionPublicacion.html.twig', array(
            'calificacionPublicacion' => $calificacionPublicacion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a CalificacionPublicacion entity.
     *
     */
    public function showAction(CalificacionPublicacion $calificacionPublicacion)
    {
        $deleteForm = $this->createDeleteForm($calificacionPublicacion);

        return $this->render('calificacionpublicacion/show.html.twig', array(
            'calificacionPublicacion' => $calificacionPublicacion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing CalificacionPublicacion entity.
     *
     */
    public function editAction(Request $request, CalificacionPublicacion $calificacionPublicacion)
    {
        $deleteForm = $this->createDeleteForm($calificacionPublicacion);
        $editForm = $this->createForm('AppBundle\Form\CalificacionPublicacionType', $calificacionPublicacion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($calificacionPublicacion);
            $em->flush();

            return $this->redirectToRoute('calificacionpublicacion_edit', array('id' => $calificacionPublicacion->getId()));
        }

        return $this->render('calificacionpublicacion/edit.html.twig', array(
            'calificacionPublicacion' => $calificacionPublicacion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a CalificacionPublicacion entity.
     *
     */
    public function deleteAction(Request $request, CalificacionPublicacion $calificacionPublicacion)
    {
        $form = $this->createDeleteForm($calificacionPublicacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($calificacionPublicacion);
            $em->flush();
        }

        return $this->redirectToRoute('calificacionpublicacion_index');
    }

    /**
     * Creates a form to delete a CalificacionPublicacion entity.
     *
     * @param CalificacionPublicacion $calificacionPublicacion The CalificacionPublicacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CalificacionPublicacion $calificacionPublicacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('calificacionpublicacion_delete', array('id' => $calificacionPublicacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
