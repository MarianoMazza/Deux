<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Usuario;
use AppBundle\Form\UsuarioType;

/**
 * Usuario controller.
 */
class UsuarioController extends Controller
{
    /**
     * @Route("/recoveryPass", name="_recoveryPass")
     */
    public function recoverPassAction(Request $request)
    {
        $usuario = $this->getDoctrine()->getRepository('AppBundle:Usuario')->findOneBy(['username'=>'admin']);
        $random = random_int(11111,99999);
        $usuario->setPassword((string)$random);

        $em = $this->getDoctrine()->getManager();
        $em->persist($usuario);
        $em->flush();

        return $this->render(':default/usuario:recoverPass.html.twig', [
            'admin'=>$usuario
        ]);
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
     * Finds and displays a Usuario entity.
     * @Route("/miperfil", name="_miperfil")
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
     * @Route("/modificar", name="_modificar")
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

            return $this->redirectToRoute('_hecho', array('id' => $usuario->getId()));
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
     * @Route("/admin/eliminar/{id}", name="_eliminarUsuario")
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
                return $this->render(':default:hecho.html.twig');
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
