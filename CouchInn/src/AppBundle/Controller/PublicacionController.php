<?php

namespace AppBundle\Controller;

use Doctrine\ORM\Mapping as ORM;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Publicacion;
use AppBundle\Form\PublicacionType;

/**
 * Publicacion controller.
 *
 */
class PublicacionController extends Controller
{
    /**
     * Lists all Publicacion entities.
     * @Route("/home/publicaciones", name="_listaPubli")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $publicaciones = $em->getRepository('AppBundle:Publicacion')->findAll();

        return $this->render(':default/publicacion:publicaciones.html.twig', array(
            'publicaciones' => $publicaciones,
            'user' => $this->getUser(),
        ));
    }


    /**
     * Lists all Publicacion entities.
     * @Route("/home/misPublicaciones", name="_misPublicaciones")
     */
    public function myAction()
    {



        $publicaciones = $this->getUser()->getPublicaciones();

        return $this->render(':default/publicacion:publicaciones.html.twig', array(
            'publicaciones' => $publicaciones,
            'user' => $this->getUser(),
        ));
    }


    /**
     * @Route("/home/altaPublicacion", name="_altaPubli")
     */
    public function newAction(Request $request)
    {
        $error = null;
        $publicacion = new Publicacion();
        $publicacion->setUsuario($this->getUser());

        $form = $this->createForm('AppBundle\Form\PublicacionType', $publicacion);
        $form->handleRequest($request);
  
        if (!empty($publicacion) and new \DateTime('today') <= $publicacion->getFechaDisponibleInicio() and $publicacion->getFechaDisponibleInicio() < $publicacion->getFechaDisponibleFin()) {
            $foto = $form['foto']->getData();
            $dir = 'uploads/fotos';

            $extension = $foto->guessExtension();
            if (!$extension) {
                $extension = 'bin';
            }
            $name = md5(uniqid()).'.'.$extension;
            $foto->move($dir, $name);
            $publicacion->setPath($name);

            $em = $this->getDoctrine()->getManager();
            $em->persist($publicacion);
            $em->flush();

            return $this->redirectToRoute('_listaPubli', array('id' => $publicacion->getId()));
        }elseif ($form->isSubmitted()){
            $error = 'Las fechas que usted ha ingresado son incorrectas.';
        }

        return $this->render(':default/publicacion:altaPubli.html.twig', array(
            'publicacion' => $publicacion,
            'form' => $form->createView(),
            'error' => $error,
        ));
    }

    /**
     * Finds and displays a Publicacion entity.
     * @Route("/home/publicaciones/{id}", name="_mostrarPublicacion")
     */
    public function showAction($id)
    {
        $publicacion = $this->getDoctrine()
            ->getRepository('AppBundle:Publicacion')
            ->find($id);
        $calificacionesBuenas = $this->getDoctrine()
            ->getRepository('AppBundle:CalificacionPublicacion')
            ->findBy([
                'calificacion'=>1,
            ]);
        $calificacionesMalas = $this->getDoctrine()
            ->getRepository('AppBundle:CalificacionPublicacion')
            ->findBy([
                'calificacion'=>2,
            ]);
        $calificacionDelusuarioBuenas = $this->getDoctrine()
            ->getRepository('AppBundle:CalificacionUsuario')
            ->findBy([
                'calificacion'=>1,
            ]);
        $calificacionesDelUsuarioMalas = $this->getDoctrine()
            ->getRepository('AppBundle:CalificacionUsuario')
            ->findBy([
                'calificacion'=>2,
            ]);
        $deleteForm = $this->createDeleteForm($publicacion);

        return $this->render(':default/publicacion:mostrarPublicacion.html.twig', array(
            'calificacionesBuenas'=>count($calificacionesBuenas),
            'calificacionesMalas'=>count($calificacionesMalas),
            'calificacionDelUsuarioBuenas'=>count($calificacionDelusuarioBuenas),
            'calificacionesDelUsuarioMalas'=>count($calificacionesDelUsuarioMalas),
            'publicacion' => $publicacion,
            'comentarios' => $publicacion->getComentarios(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Publicacion entity.
     * @Route("/home/publicacion/{id}/modificar", name="_modificarPublicacion")
     */
    public function editAction(Request $request, $id)
    {
        $publicacion = $this->getDoctrine()
            ->getRepository('AppBundle:Publicacion')
            ->find($id);
        $deleteForm = $this->createDeleteForm($publicacion);
        $editForm = $this->createForm('AppBundle\Form\PublicacionType', $publicacion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $foto = $editForm['foto']->getData();
            $dir = 'uploads/fotos';

            $extension = $foto->guessExtension();
            if (!$extension) {
                $extension = 'bin';
            }
            $name = md5(uniqid()).'.'.$extension;
            $foto->move($dir, $name);
            $publicacion->setPath($name);

            $em = $this->getDoctrine()->getManager();
            $em->persist($publicacion);
            $em->flush();

            return $this->redirectToRoute('_mostrarPublicacion', array('id' => $publicacion->getId()));
        }

        return $this->render(':default/publicacion:modificarPublicacion.html.twig', array(
            'publicacion' => $publicacion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Publicacion entity.
     * @Route("/home/publicacion/eliminar/{id}", name="_eliminarPublicacion")
     */
    public function deleteAction(Request $request, $id)
    {
        $publicacion = $this->getDoctrine()
            ->getRepository('AppBundle:Publicacion')
            ->find($id);

        $form = $this->createDeleteForm($publicacion);
        $form->handleRequest($request);

        if (!empty($publicacion) and !empty($publicacion->getComentarios())) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($publicacion);
            $em->flush();
        }

        return $this->redirectToRoute('_listaPubli');
    }

    /**
     * Creates a form to delete a Publicacion entity.
     *
     * @param Publicacion $publicacion The Publicacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Publicacion $publicacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('_eliminarPublicacion', array('id' => $publicacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
