<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Usuario;
use AppBundle\Form\UsuarioType;

/**
 * Usuario controller.
 *
 */
class UsuarioController extends Controller
{
    /**
     * Lists all Usuario entities.
     * @Route("/usuarios", name="_listaDeUsuarios")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $usuarios = $em->getRepository('AppBundle:Usuario')->findAll();

        dump($usuarios);die;
        return $this->render(':default:listaUsuarios.html.twig', array(
            'usuarios' => $usuarios,
        ));
    }
    
    /**
     * Deletes a Usuario entity.
     * @Route("/eliminar/{id}", name="_eliminarUsuario")
     */
    public function deleteAction(Request $request, $id)
    {
        $usuario = $this->getDoctrine()->getRepository('AppBundle:Usuario')->find($id);
        $form = $this->createDeleteForm($usuario);
        $form->handleRequest($request);
        if (!empty($usuario)) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($usuario);
            $em->flush();
            return $this->render(':default:hecho.html.twig');
        }

        return $this->redirectToRoute('_listaDeUsuarios');
    }

    /**
     * Creates a form to elete a Usuario entity.
     *
     * @param Usuario $usuario The Usuario entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Usuario $usuario)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('_eliminarUsuario', array('id' => $usuario->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
