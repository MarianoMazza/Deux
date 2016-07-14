<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comision;
use AppBundle\Entity\Publicacion;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
     * @Route("/publicacion/solicitudes/{id}", name="lista_solicitudes")
     */
    public function indexAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $publicacion = $this->getDoctrine()
            ->getRepository('AppBundle:Publicacion')
            ->find($id);

        $solicitudes = $em->getRepository('AppBundle:Solicitud')->findBy([
            'publicacion'=>$publicacion,
        ]);

        return $this->render(
            'default/solicitud/notificaciones.html.twig', array(
            'solicitudes' => $solicitudes,
            'publicacion'=>$publicacion,
            'user' => $this->getUser(),
        ));
    }

    /**
     * Lists all Solicitud entities.
     * @Route("/user/misSolicitudes", name="lista_de_mis_solicitudes")
     */
    public function indexSolicitudesAction(){
        return $this->render('default/solicitud/misSolicitudes.html.twig', array(
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
            ])
            ->add('submit', SubmitType::class, [
                'label'=>'Enviar mi solicitud',
            ]);
        $form->handleRequest($request);

        $solicitudes = $this->getDoctrine()
            ->getRepository('AppBundle:Solicitud')
            ->findOneBy([
                'usuario'=>$this->getUser(),
                'publicacion'=>$publicacion,
            ]);

        if (empty($solicitudes)){
            if ($form->isSubmitted() && $solicitud->getDesde() <= $solicitud->getHasta()) {
                $solicitud->setPublicacion($publicacion);
                $solicitud->setFecha(new \DateTime('today'));
                $solicitud->setOk(1);
                $solicitud->setUsuario($this->getUser());
                $em = $this->getDoctrine()->getManager();
                $em->persist($solicitud);
                $em->flush();


                return $this->redirectToRoute('_mostrarPublicacion', array('id' => $solicitud->getPublicacion()->getId()));
            }elseif ($form->isSubmitted()){
                $error = 'Las fechas que usted ha ingresado son incorrectas.';
            }
        }else{
            $error = 'Usted ya ha enviado una solicitud de hospedaje para esta publicacion.';
        }

        return $this->render('default/solicitud/solicitud.html.twig', array(
            'publicacion' => $publicacion,
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
                    ->findOneBy(['id' => $solicitud->getPublicacion()]);
                $publicacion->setReservado(true);

                //Alta de la comision correspondiente a la publicacion en la que se aceptó la solicitud
                $comision = new Comision();
                $porcentaje = $this->getDoctrine()->getRepository('AppBundle:Porcentaje')->findBy(array(),array('id'=>'DESC'));

                $publicacion = $this->getDoctrine()->getRepository('AppBundle:Publicacion')->find($solicitud->getPublicacion()->getId());
                $form = $this->createForm('AppBundle\Form\ComisionType', $comision);
                $comision->setFecha(new \DateTime('today'));
                $comision->setPublicacion($id);
                $comision->setPorcentaje($porcentaje[0]->getPorcentaje());
                $comision->setMonto($publicacion->getCosto());
                $comision->setGanancia($publicacion->getCosto()*$comision->getPorcentaje()/100);

                $form->handleRequest($request);

                $em = $this->getDoctrine()->getManager();
                $em->persist($comision);
                $em->flush();
            }
        }
        return $this->redirectToRoute('lista_de_mis_solicitudes');
    }

    /**
     * Deletes a Solicitud entity.
     * @Route("/eliminarSolicitud/{id}", name="_eliminarSolicitud")
     */
    public function deleteAction($id)
    {
        $solicitud = $this->getDoctrine()
            ->getRepository('AppBundle:Solicitud')
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($solicitud);
        $em->flush();
        return $this->redirectToRoute('lista_de_mis_solicitudes');
    }
}
