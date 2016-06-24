<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Publicacion;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Solicitud;
use AppBundle\Form\SolicitudType;

/**
 * Solicitud controller.
 *
 */
class SolicitudController extends Controller
{
    /**
     * Lists all Solicitud entities.
     * @Route("/user/solicitudes", name="lista_solicitudes")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $solicitudes = $em->getRepository('AppBundle:Solicitud')->findAll();

        return $this->render('default/solicitud/notificaciones.twig', array(
            'solicitudes' => $solicitudes,
            'misSolicitudes' => $this->getUser()->getMisSolicitudes(),
            'user' => $this->getUser(),
        ));
    }

    /**
     * Creates a new Solicitud entity.
     * @Route("/publicacion/{id}/hospedarme", name="_hospedarme")
     */
    public function newAction(Request $request, $id)
    {
        $error = null;
        $publicacion = $this->getDoctrine()
            ->getRepository('AppBundle:Publicacion')
            ->find($id);
        $solicitud = new Solicitud();
        $form = $this->createForm('AppBundle\Form\SolicitudType', $solicitud);
        $form
            ->add('desde', DateType::class,[
                'years'=>range($publicacion->getFechaDisponibleInicio()->format('Y'), $publicacion->getFechaDisponibleFin()->format('Y')),
                'months'=>range($publicacion->getFechaDisponibleInicio()->format('m'), $publicacion->getFechaDisponibleFin()->format('m')),
                'days'=>range($publicacion->getFechaDisponibleInicio()->format('d'), $publicacion->getFechaDisponibleFin()->format('d')),
            ])
            ->add('hasta', DateType::class,[
                'years'=>range($publicacion->getFechaDisponibleInicio()->format('Y'), $publicacion->getFechaDisponibleFin()->format('Y')),
                'months'=>range($publicacion->getFechaDisponibleInicio()->format('m'), $publicacion->getFechaDisponibleFin()->format('m')),
                'days'=>range($publicacion->getFechaDisponibleInicio()->format('d'), $publicacion->getFechaDisponibleFin()->format('d')),
            ]);
        $form->handleRequest($request);

        $solicitudes = $this->getDoctrine()
            ->getRepository('AppBundle:Solicitud')
            ->findOneBy(['usuario'=>$this->getUser()]);

        if (empty($solicitudes)){
            if ($form->isSubmitted() && $solicitud->getDesde() <= $solicitud->getHasta()) {
                $solicitud->setPublicacion($publicacion);
                $solicitud->setFecha(new \DateTime('today'));
                $solicitud->setOk(1);
                $solicitud->setUsuario($this->getUser());
                $em = $this->getDoctrine()->getManager();
                $em->persist($solicitud);
                $em->flush();

                return $this->redirectToRoute('_listaPubli', array('id' => $solicitud->getId()));
            }elseif ($form->isSubmitted()){
                $error = 'Las fechas que usted ha ingresado son incorrectas.';
            }
        }else{
            $error = 'Usted ya ha enviado una solicitud de hospedaje para esta publicacion.';
        }

        return $this->render('default/solicitud/solicitud.html.twig', array(
            'solicitud' => $solicitud,
            'form' => $form->createView(),
            'error' => $error,
        ));
    }

    /**
     * Displays a form to edit an existing Solicitud entity.
     * @Route("/accion/{id}/{ok}", name="_accion")
     */
    public function editAction(Request $request, $id, $ok)
    {
        $solicitud = $this->getDoctrine()
            ->getRepository('AppBundle:Solicitud')
            ->find($id);
        $editForm = $this->createForm('AppBundle\Form\SolicitudType', $solicitud);
        $editForm->handleRequest($request);

        if (!empty($solicitud)) {
            $solicitud->setOk($ok);
            $em = $this->getDoctrine()->getManager();
            $em->persist($solicitud);
            $em->flush();
            if ($ok == 2){
                $publicacion = $this->getDoctrine()
                    ->getRepository('AppBundle:Publicacion')
                    ->findOneBy(['publicacion' => $solicitud->getPublicacion()]);
                $publicacion->setReservado(true);
            }

            return $this->redirectToRoute('lista_solicitudes');
        }
    }

    /**
     * Deletes a Solicitud entity.
     * @Route("/eliminarSolicitud/{id}", name="_eliminarSolicitud")
     */
    public function deleteAction(Request $request, $id)
    {
        $solicitud = $this->getDoctrine()
            ->getRepository('AppBundle:Solicitud')
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($solicitud);
        $em->flush();
        return $this->redirectToRoute('lista_solicitudes');
    }

    /**
     * Creates a form to delete a Solicitud entity.
     *
     * @param Solicitud $solicitud The Solicitud entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Solicitud $solicitud)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('_eliminarSolicitud', array('id' => $solicitud->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
