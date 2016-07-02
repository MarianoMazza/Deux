<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Publicacion;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\CalificacionPublicacion;

/**
 * CalificacionPublicacion controller.
 *
 */
class CalificacionPublicacionController extends Controller
{

    /**
     * Creates a new CalificacionPublicacion entity.
     * @Route("/home/publicaciones/calificacionPublicacion/{id}/{cal}", name="_calificarPublicacion")
     */
    public function newAction($id, $cal)
    {
        $calificacionPublicacion = new CalificacionPublicacion();
        $publicacion = $this->getDoctrine()->getRepository('AppBundle:Publicacion')->find($id);
        $calificacionPublicacion->setCalificacion($cal);
        $calificacionPublicacion->setDeUsuario($this->getUser());
        $calificacionPublicacion->setPublicacion($publicacion);
        $calificaciones = $this->getDoctrine()
            ->getRepository('AppBundle:CalificacionPublicacion')
            ->findOneBy([
                'deUsuario'=>$this->getUser()->getId(),
                'publicacion'=>$publicacion,
            ]);

        if (empty($calificaciones) and $publicacion->getUsuario() != $this->getUser()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($calificacionPublicacion);
            $em->flush();
        }

        return $this->redirectToRoute('_mostrarPublicacion', [
            'id'=>$id,
        ]);
    }
}
