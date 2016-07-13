<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
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
    {   $error=null;
        $em = $this->getDoctrine()->getManager();

        $tipoHospedajes = $em->getRepository('AppBundle:TipoHospedaje')->findAll();

        return $this->render(':default/tipoHospedaje:tiposHospedaje.html.twig', array(
            'tipos' => $tipoHospedajes,
            'error' => $error,
        ));
    }

    /**
     * Creates a new TipoHospedaje entity.
     * @Route("/admin/tipoHospedaje", name="_tipoHospedaje")
     */
    public function newAction(Request $request)
    {
        try {
        $tipoHospedaje = new TipoHospedaje();
        $form = $this->createForm('AppBundle\Form\TipoHospedajeType', $tipoHospedaje);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tipoHospedaje);
            $em->flush();
            return $this->redirectToRoute('_tipos', array('id' => $tipoHospedaje->getId()));
        }
    }catch (UniqueConstraintViolationException  $e) {
        return $this->redirectToRoute('_errorTipo');
    }

        return $this->render(':default/tipoHospedaje:altaTipoHospedaje.html.twig', array(
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
            return $this->redirectToRoute('_tipos', array('id' => $tipoHospedaje->getId()));
        }

        return $this->render(':default/tipoHospedaje:modificarTipoHospedaje.html.twig', array(
            'tipoHospedaje' => $tipoHospedaje,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     *  @Route("/admin/eliminarTipo/{id}", name="_eliminarTipo")
     */
    public function deleteAction(Request $request, $id)
    {
        $error=null;
        try{
            $tipoHospedaje = $this->getDoctrine()->getRepository('AppBundle:TipoHospedaje')->find($id);
            $publicaciones = $this->getDoctrine()
                ->getRepository('AppBundle:Publicacion')
                ->findOneBy([
                    'tipo'=>$tipoHospedaje->getId()
                ]);
            if (!empty($publicaciones)){
                $tipoHospedajes = $this->getDoctrine()->getRepository('AppBundle:TipoHospedaje')->findAll();
                $error='No puede eliminar este tipo de hospedaje ya que 1 o más publicaciones se encuentran relacionados al mismo.';
                return $this->render(':default/tipoHospedaje:tiposHospedaje.html.twig', array(
                    'tipos' => $tipoHospedajes,
                    'error' => $error,
                ));
            }

            $form = $this->createDeleteForm($tipoHospedaje);
            $form->handleRequest($request);

            if (!empty($tipoHospedaje)) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($tipoHospedaje);
                $em->flush();
            }
        }catch (Exception $e) {
            return $this->redirectToRoute('_error', [
                'err' => $e->getMessage()
            ]);
        }

        return $this->redirectToRoute('_hecho');
    }

    private function createDeleteForm(TipoHospedaje $tipoHospedaje)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('_eliminarTipo', array('id' => $tipoHospedaje->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}