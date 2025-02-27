<?php
/**
 * Created by PhpStorm.
 * User: alephzero
 * Date: 28/05/16
 * Time: 15:33
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="_index")
     */
    public function indexAction(){
        if ($this->getUser() ==null) {
            return $this->render(':default:index.html.twig');
        }
        else{
            $em = $this->getDoctrine()->getManager();
            dump($this->getUser());
            $publicaciones = $em->getRepository('AppBundle:Publicacion')->findAll();
            return $this->render(':default/publicacion:publicaciones.html.twig', array(
                'publicaciones' => $publicaciones,
                'user' => $this->getUser(),
            ));
        }
    }

    /**
     * @Route("/hecho", name="_hecho")
     */
    public function succesAction(){
        return $this->render(':default:hecho.html.twig');
    }

    /**
     * @Route("/hecho2", name="_hecho2")
     */
    public function succesAction2(){
        return $this->render(':default:hecho2.html.twig');
    }

    /**
     * @Route("/hecho3", name="_hecho3")
     */
    public function succesAction3(){
        return $this->render(':default:hecho3.html.twig');
    }

    /**
     * @Route("/error/{err}", name="_error")
     */
    public function errorAction($err)
    {
        return $this->render(':default:error.html.twig', [
            'error'=>$err
        ]);
    }
    /**
     * @Route("/errorDeTipo", name="_errorTipo")
     */
    public function errorTipoAction()
    {
        return $this->render(':default:errorTipo.html.twig');
    }
    /**
     * @Route("/ayuda", name="_ayuda")
     */
    public function ayudaAction(){
        return $this->render(':default:ayuda.html.twig');
    }
}