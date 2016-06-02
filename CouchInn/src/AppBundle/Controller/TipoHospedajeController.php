<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\TipoHospedaje;
use AppBundle\Form\TipoHospedajeType;
use Symfony\Component\Validator\Constraints as Assert;

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
<<<<<<< HEAD
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
     *
     * @Route("/admin/modificarHospedaje/{id}", name= "_modificarHospedaje"))
     */
  /*  public function editAction($id){
        $em = $this-> getDoctrine()->getManager();
        $hospedaje = $em-> getRepository('AppBundle:TipoHospedaje')->find($id);

        if($hospedaje){
            throw $this->createNotFoundException('El tipo de Hospedaje no existe');
        }
        $form=$this->createEditForm($hospedaje);

        return $this->render(':default/administrador:editHospedaje.html.twig',array('hopedaje'=>$hospedaje,'form'=>$form->createView()));
    }
*/


    public function editAction(Request $request, TipoHospedaje $tipoHospedaje)
    {
        $tipoHospedaje = $usuario = $this->getDoctrine()->getRepository('TipoHospedaje')->find($this->getUser()->getId());
        }
    /*
     * @Route("/admin/modificarTipo/{id}", name="_modificartipo")
     */
    /**
     * Deletes a TipoHospedaje entity.
<<<<<<< HEAD
     * @Route("/admin/eliminar/{id}", name="_eliminarTipoHospedaje")
     *  @Route("/admin/eliminarTipo/{id}", name="_eliminarTipo")
>>>>>>> 357d5ac794eef31754e5d70da2333972d2b02561
     */
    public function deleteAction(Request $request, $id)
    {
        try {
            $tipoHospedaje = $this->getDoctrine()->getRepository('AppBundle:TipoHospedaje')->find('id');
            if ($tipoHospedaje->getRoles() == $this->getUser()->getRoles()){
                throw new Exception ('Usted no tiene privilegios suficientes para realizar esta acción.');
            }
            $form = $this->createDeleteForm($tipoHospedaje);
            $form->handleRequest($request);
            if (!empty($tipoHospedaje)) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($tipoHospedaje);
                $em->flush();
                return $this->redirectToRoute('_hecho');
            }
        } catch (Exception $e) {
            return $this->redirectToRoute('_error', [
                'err'=>$e->getMessage()
            ]);
        }
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
