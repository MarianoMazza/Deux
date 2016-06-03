<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\CalificacionUsuario;
use AppBundle\Form\CalificacionUsuarioType;

/**
 * CalificacionUsuario controller.
 *
 */
class CalificacionUsuarioController extends Controller
{
    /**
     * Lists all CalificacionUsuario entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $calificacionUsuarios = $em->getRepository('AppBundle:CalificacionUsuario')->findAll();

        return $this->render(':default/usuario:calificacionUsuario.html.twig', array(
            'calificacionUsuarios' => $calificacionUsuarios,
        ));
    }

    /**
     * Creates a new CalificacionUsuario entity.
     * @Route("/calificacionUsuario", name="_calificacionUsuario")
     */
    public function newAction(Request $request)
    {
        $calificacionUsuario = new CalificacionUsuario();
        $calificacionUsuario->setDeUsuario($this->getUser());
        $form = $this->createForm('AppBundle\Form\CalificacionUsuarioType', $calificacionUsuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($calificacionUsuario);
            $em->flush();

            return $this->redirectToRoute('calificacionUsuario_show', array('id' => $calificacionUsuario->getId()));
        }

        return $this->render(':default/usuario:calificacionUsuario.html.twig', array(
            'calificacionUsuario' => $calificacionUsuario,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a CalificacionUsuario entity.
     *
     */
    public function showAction(CalificacionUsuario $calificacionUsuario)
    {
        $deleteForm = $this->createDeleteForm($calificacionUsuario);

        return $this->render('calificacionusuario/show.html.twig', array(
            'calificacionUsuario' => $calificacionUsuario,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing CalificacionUsuario entity.
     *
     */
    public function editAction(Request $request, CalificacionUsuario $calificacionUsuario)
    {
        $deleteForm = $this->createDeleteForm($calificacionUsuario);
        $editForm = $this->createForm('AppBundle\Form\CalificacionUsuarioType', $calificacionUsuario);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($calificacionUsuario);
            $em->flush();

            return $this->redirectToRoute('calificacionUsuario_edit', array('id' => $calificacionUsuario->getId()));
        }

        return $this->render('calificacionusuario/edit.html.twig', array(
            'calificacionUsuario' => $calificacionUsuario,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a CalificacionUsuario entity.
     *
     */
    public function deleteAction(Request $request, CalificacionUsuario $calificacionUsuario)
    {
        $form = $this->createDeleteForm($calificacionUsuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($calificacionUsuario);
            $em->flush();
        }

        return $this->redirectToRoute('calificacionUsuario_index');
    }

    /**
     * Creates a form to delete a CalificacionUsuario entity.
     *
     * @param CalificacionUsuario $calificacionUsuario The CalificacionUsuario entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CalificacionUsuario $calificacionUsuario)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('calificacionUsuario_delete', array('id' => $calificacionUsuario->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
