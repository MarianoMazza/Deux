<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Porcentaje;
use AppBundle\Form\PorcentajeType;

/**
 * Porcentaje controller.
 *
 * @Route("/porcentaje")
 */
class PorcentajeController extends Controller
{
    /**
     * Lists all Porcentaje entities.
     *
     * @Route("/", name="porcentaje_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $porcentajes = $em->getRepository('AppBundle:Porcentaje')->findAll();

        return $this->render('porcentaje/index.html.twig', array(
            'porcentajes' => $porcentajes,
        ));
    }

    /**
     * Creates a new Porcentaje entity.
     *
     * @Route("/newPorcentaje", name="_newPorcentaje")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $porcentaje = new Porcentaje();
        $form = $this->createForm('AppBundle\Form\PorcentajeType', $porcentaje);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($porcentaje);
            $em->flush();

            return $this->redirectToRoute('_listaPubli', array('id' => $porcentaje->getId()));
        }

        return $this->render('porcentaje/new.html.twig', array(
            'porcentaje' => $porcentaje,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Porcentaje entity.
     *
     * @Route("/{id}", name="porcentaje_show")
     * @Method("GET")
     */
    public function showAction(Porcentaje $porcentaje)
    {
        $deleteForm = $this->createDeleteForm($porcentaje);

        return $this->render('porcentaje/show.html.twig', array(
            'porcentaje' => $porcentaje,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Porcentaje entity.
     *
     * @Route("/{id}/edit", name="porcentaje_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Porcentaje $porcentaje)
    {
        $deleteForm = $this->createDeleteForm($porcentaje);
        $editForm = $this->createForm('AppBundle\Form\PorcentajeType', $porcentaje);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($porcentaje);
            $em->flush();

            return $this->redirectToRoute('porcentaje_edit', array('id' => $porcentaje->getId()));
        }

        return $this->render('porcentaje/edit.html.twig', array(
            'porcentaje' => $porcentaje,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Porcentaje entity.
     *
     * @Route("/{id}", name="porcentaje_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Porcentaje $porcentaje)
    {
        $form = $this->createDeleteForm($porcentaje);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($porcentaje);
            $em->flush();
        }

        return $this->redirectToRoute('porcentaje_index');
    }

    /**
     * Creates a form to delete a Porcentaje entity.
     *
     * @param Porcentaje $porcentaje The Porcentaje entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Porcentaje $porcentaje)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('porcentaje_delete', array('id' => $porcentaje->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
