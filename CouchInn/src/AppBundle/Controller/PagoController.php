<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Pago;
use AppBundle\Form\PagoType;

/**
 * Pago controller.
 *
 */
class PagoController extends Controller
{
    /**
     * Lists all Pago entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pagos = $em->getRepository('AppBundle:Pago')->findAll();

        return $this->render('pago/index.html.twig', array(
            'pagos' => $pagos,
        ));
    }
    /**
     * @Route("/pagoYaHecho", name="_pagoHecho")
     */
    public function pagoHecho(){
        return $this->render(':default:pagoHecho.html.twig');
    }
    /**
     * return boolean
     */
    public function puedePagar()
    {
        if (!$this->getUser()->getPagos()->isEmpty()) {
            if($this->getUser()->getPagos()->last()->estaVencido()){
               return true;
            }
            else return false;
        }
        return true;
    }
    /**
     * Creates a new Pago entity.
     * @Route("/pago",name="_pago")
     */
    public function newAction(Request $request)
    {
        $error = null;
        if ($this->getUser()->esPremium()) {

            return $this->render(':default:pagoHecho.html.twig'); }
            else {

            $pago = new Pago();
            $form = $this->createForm('AppBundle\Form\PagoType', $pago);
            $pago->setUsuario($this->getUser());
            $pago->setMonto(100);
            $pago->setVencimiento(new \DateTime('today'));
            $pago->getVencimiento()->modify('+1 month');
            $form->handleRequest($request);
            if ($pago->getVencimientoTarjeta() != null and new \DateTime('today') >= $pago->getVencimientoTarjeta()){
                $error = 'La fecha de vencimiento de tarjeta es incorrecta.';
                return $this->render('default/pago.html.twig', array(
                    'pago' => $pago,
                    'form' => $form->createView(),
                    'error' => $error,
                ));
            }
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($pago);
                $em->flush();
                return $this->redirectToRoute('_pago', array('id' => $pago->getId()));
            }
        }
        return $this->render('default/pago.html.twig', array(
            'pago' => $pago,
            'form' => $form->createView(),
            'error' => $error,
        ));
    }

    /**
     * Finds and displays a Pago entity.
     *
     */
    public function showAction(Pago $pago)
    {
        $deleteForm = $this->createDeleteForm($pago);

        return $this->render('pago/show.html.twig', array(
            'pago' => $pago,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Pago entity.
     *
     */
    public function editAction(Request $request, Pago $pago)
    {
        $deleteForm = $this->createDeleteForm($pago);
        $editForm = $this->createForm('AppBundle\Form\PagoType', $pago);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pago);
            $em->flush();

            return $this->redirectToRoute('pago_edit', array('id' => $pago->getId()));
        }

        return $this->render('pago/edit.html.twig', array(
            'pago' => $pago,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Pago entity.
     *
     */
    public function deleteAction(Request $request, Pago $pago)
    {
        $form = $this->createDeleteForm($pago);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pago);
            $em->flush();
        }

        return $this->redirectToRoute('pago_index');
    }

    /**
     * Creates a form to delete a Pago entity.
     *
     * @param Pago $pago The Pago entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Pago $pago)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pago_delete', array('id' => $pago->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
