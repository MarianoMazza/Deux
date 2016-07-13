<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Comision;
use AppBundle\Form\ComisionType;

/**
 * Comision controller.
 *
 * @Route("/comision")
 */
class ComisionController extends Controller
{
    /**
     * Lists all Comision entities.
     *
     * @Route("/", name="comision_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $comisions = $em->getRepository('AppBundle:Comision')->findAll();

        return $this->render('comision/index.html.twig', array(
            'comisions' => $comisions,
        ));
    }

    /**
     * Creates a new Comision entity.
     *
     * @Route("/newComision/{id}", name="_newComision")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request,$id)
    {
        $comision = new Comision();
        $porcentaje = $this->getDoctrine()->getRepository('AppBundle:Porcentaje')->findBy(array(),array('id'=>'DESC'));

        $publicacion = $this->getDoctrine()->getRepository('AppBundle:Publicacion')->find($id);
        $form = $this->createForm('AppBundle\Form\ComisionType', $comision);
        $comision->setFecha(new \DateTime('today'));
        $comision->setPublicacion($id);
        $comision->setPorcentaje($porcentaje[0]->getPorcentaje());
        $comision->setMonto($publicacion->getCosto());
        $comision->setGanancia($publicacion->getCosto()*$comision->getPorcentaje()/100);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($comision);
            $em->flush();

            return $this->redirectToRoute('_hecho', array('id' => $comision->getId()));
        }

        return $this->render('comision/new.html.twig', array(
            'comision' => $comision,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Comision entity.
     *
     * @Route("/{id}", name="comision_show")
     * @Method("GET")
     */
    public function showAction(Comision $comision)
    {
        $deleteForm = $this->createDeleteForm($comision);

        return $this->render('comision/show.html.twig', array(
            'comision' => $comision,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Comision entity.
     *
     * @Route("/{id}/edit", name="comision_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Comision $comision)
    {
        $deleteForm = $this->createDeleteForm($comision);
        $editForm = $this->createForm('AppBundle\Form\ComisionType', $comision);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($comision);
            $em->flush();

            return $this->redirectToRoute('comision_edit', array('id' => $comision->getId()));
        }

        return $this->render('comision/edit.html.twig', array(
            'comision' => $comision,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Comision entity.
     *
     * @Route("/{id}", name="comision_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Comision $comision)
    {
        $form = $this->createDeleteForm($comision);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($comision);
            $em->flush();
        }

        return $this->redirectToRoute('comision_index');
    }

    /**
     * Creates a form to delete a Comision entity.
     *
     * @param Comision $comision The Comision entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Comision $comision)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('comision_delete', array('id' => $comision->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
