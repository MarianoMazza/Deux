<?php

namespace AppBundle\Controller;

use Doctrine\ORM\Mapping\Id;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Publicacion;
use AppBundle\Form\PublicacionType;
use Symfony\Component\Validator\Constraints\Date;

/**
 * Publicacion controller.
 *
 */
class PublicacionController extends Controller
{
    /**
     * Lists all Publicacion entities.
     * @Route("/home/publicaciones", name="_listaPubli")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $publicaciones = $em->getRepository('AppBundle:Publicacion')->findAll();

        return $this->render(':default/publicacion:publicaciones.html.twig', array(
            'publicaciones' => $publicaciones,
            'user' => $this->getUser(),
        ));
    }

    /**
     * @Route("/home/altaPublicacion", name="_altaPubli")
     */
    public function newAction(Request $request)
    {
        $publicacion = new Publicacion();
        $publicacion->setUsuario($this->getUser());
        $form = $this->createForm('AppBundle\Form\PublicacionType', $publicacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($publicacion);
            $em->flush();

            return $this->redirectToRoute('_hecho', array('id' => $publicacion->getId()));
        }

        return $this->render(':default/publicacion:altaPubli.html.twig', array(
            'publicacion' => $publicacion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Publicacion entity.
     * @Route("/home/publicaciones/{id}", name="_mostrarPublicacion")
     */
    public function showAction($id)
    {
        $publicacion = $this->getDoctrine()
            ->getRepository('AppBundle:Publicacion')
            ->find($id);
        $deleteForm = $this->createDeleteForm($publicacion);

        return $this->render(':default/publicacion:mostrarPublicacion.html.twig', array(
            'publicacion' => $publicacion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Publicacion entity.
     *
     */
    public function editAction(Request $request, Publicacion $publicacion)
    {
        $deleteForm = $this->createDeleteForm($publicacion);
        $editForm = $this->createForm('AppBundle\Form\PublicacionType', $publicacion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($publicacion);
            $em->flush();

            return $this->redirectToRoute('yes_edit', array('id' => $publicacion->getId()));
        }

        return $this->render('publicacion/edit.html.twig', array(
            'publicacion' => $publicacion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Publicacion entity.
     * @Route("/home/publicacion/eliminar/{id}", name="_eliminarPublicacion")
     */
    public function deleteAction(Request $request, $id)
    {
        $publicacion = $this->getDoctrine()
            ->getRepository('AppBundle:Publicacion')
            ->find($id);
        $form = $this->createDeleteForm($publicacion);
        $form->handleRequest($request);

        if (!empty($publicacion)) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($publicacion);
            $em->flush();
        }

        return $this->redirectToRoute('_hecho');
    }

    /**
     * Creates a form to delete a Publicacion entity.
     *
     * @param Publicacion $publicacion The Publicacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Publicacion $publicacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('_eliminarPublicacion', array('id' => $publicacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
