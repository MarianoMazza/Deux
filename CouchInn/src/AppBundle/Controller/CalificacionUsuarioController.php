<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\CalificacionUsuario;

/**
 * CalificacionUsuario controller.
 *
 */
class CalificacionUsuarioController extends Controller
{
    /**
     * Creates a new CalificacionUsuario entity.
     * @Route("/home/calificacion/{paraUsuario}/{cal}/{publicacionid}", name="_calificacionUsuario")
     */
    public function newAction($paraUsuario, $cal ,$publicacionid)
    {
        $calificacionUsuario = new CalificacionUsuario();
        $usuario = $this->getDoctrine()
            ->getRepository('AppBundle:Usuario')
            ->find($paraUsuario);
        $calificacionUsuario->setDeUsuario($this->getUser());
        $calificacionUsuario->setParaUsuario($usuario);
        $calificacionUsuario->setCalificacion($cal);
        $calificaciones = $this->getDoctrine()
            ->getRepository('AppBundle:CalificacionUsuario')
            ->findOneBy([
                'deUsuario'=>$this->getUser()->getId(),
                'paraUsuario'=>$paraUsuario,
            ]);

        if (empty($calificaciones) and $calificacionUsuario->getParaUsuario() != $this->getUser()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($calificacionUsuario);
            $em->flush();
        }

        return $this->redirectToRoute('_mostrarPublicacion', [
            'id'=>$publicacionid,
        ]);
    }
}
