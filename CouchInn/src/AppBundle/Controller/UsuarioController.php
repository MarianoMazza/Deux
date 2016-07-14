<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Filter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Usuario;
use AppBundle\Form\UsuarioType;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Usuario controller.
 */
class UsuarioController extends Controller
{
    /**
     * @Route("/admin/cantEnMes", name="_cantidadEnMes")
     */
    public function usuariosRegistradosMes(Request $request)
    {
        $error = null;
        $mes = new Filter();
        $form = $this->createForm('AppBundle\Form\mesType', $mes);
        
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $usuariosTotal = $em->getRepository('AppBundle:Usuario')->findAll();
        $usuarios = array();
        if($mes->getfechaDisponibleInicio()==null) {
            return $this->render(':default/administrador:cantUsuarios.html.twig', array(
                'form' => $form->createView(),
            ));
        }
        foreach($usuariosTotal as $user)
        {
            if ($user->getFechaRegistro()->format('M') == $mes->getfechaDisponibleInicio()->format('M') and $user->getFechaRegistro()->format('Y') == $mes->getfechaDisponibleInicio()->format('Y')){
                $usuarios[] = $user;
            }
        }
        return $this->render(':default/administrador:cantidadUsuariosMes.html.twig', array(
            'usuarios' => count($usuarios),
        ));
    }
    /**
     * Lists all Usuario entities.
     * @Route("/admin/usuarios", name="_listaDeUsuarios")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $usuarios = $em->getRepository('AppBundle:Usuario')->findAll();
        return $this->render(':default/administrador:listaUsuarios.html.twig', array(
            'cant' => count($usuarios),
            'usuarios' => $usuarios,
        ));
    }
    /**
     * return boolean
     */
    public function esPremium()
    {
        if (!$this->getUser()->getPagos()->isEmpty()) {
            if($this->getUser()->getPagos()->last()->estaVencido()){
                return false;
            }
            else return true;
        }
        return false;
    }
    /**
     * Finds and displays a Usuario entity.
     * @Route("/user/miperfil", name="_miperfil")
     */
    public function showAction()
    {
        $usuario = $this->getUser();
        $deleteForm = $this->createDeleteForm($usuario);

        return $this->render(':default/usuario:perfil.html.twig', array(
            'usuario' => $usuario,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Usuario entity.
     * @Route("/user/modificar", name="_modificar")
     */
    public function editAction(Request $request)
    {
        $usuario = $usuario = $this->getDoctrine()->getRepository('AppBundle:Usuario')->find($this->getUser()->getId());
        $deleteForm = $this->createDeleteForm($usuario);
        $editForm = $this->createForm('AppBundle\Form\UsuarioType', $usuario);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();

            return $this->redirectToRoute('_miperfil', array('id' => $usuario->getId()));
        }

        $editForm->remove('plainPassword');
        return $this->render(':default/usuario:modificarInformacion.html.twig', array(
            'usuario' => $usuario,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Usuario entity.
     * @Route("/admin/eliminarUsuario/{id}", name="_eliminarUsuario")
     */
    public function deleteAction(Request $request, $id)
    {
        try {
            $usuario = $this->getDoctrine()->getRepository('AppBundle:Usuario')->find($id);
            if ($usuario->getRoles() == $this->getUser()->getRoles()){
                throw new Exception ('Usted no tiene privilegios suficientes para realizar esta acción.');
            }
            $form = $this->createDeleteForm($usuario);
            $form->handleRequest($request);
            if (!empty($usuario)) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($usuario);
                $em->flush();
                return $this->redirectToRoute('_listaDeUsuarios');
            }
        } catch (Exception $e) {
            return $this->redirectToRoute('_error', [
                'err'=>$e->getMessage()
            ]);
        }
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