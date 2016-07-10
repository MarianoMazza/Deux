<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Publicacion;
use AppBundle\Entity\Pregunta;
use AppBundle\Form\PreguntaType;

/**
 * Pregunta controller.
 *
 */
class PreguntaController extends Controller
{
    /**
     * Lists all Pregunta entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $preguntas = $em->getRepository('AppBundle:Pregunta')->findAll();

        return $this->render(':default/pregunta:index.html.twig', array(
            'preguntas' => $preguntas,
        ));
    }

    /**
     * Lists all Publicacion entities.
     * @Route("/home/misPreguntas", name="_misPreguntas")
     */
    public function myQuestions()
    {
        $em = $this->getDoctrine()->getManager();
        $preguntas = $em->getRepository('AppBundle:Pregunta')->findAll();

        return $this->render(':default/pregunta:misPreguntas.html.twig', array(
            'preguntas' => $preguntas,
            'user' => $this->getUser(),
        ));
    }

    /**
     * Lists all Publicacion entities.
     * @Route("/home/misRespuestas", name="_misRespuestas")
     */
    public function myResponses()
    {
        $em = $this->getDoctrine()->getManager();
        $preguntas = $em->getRepository('AppBundle:Pregunta')->findAll();

        return $this->render(':default/pregunta:misRespuestas.html.twig', array(
            'preguntas' => $preguntas,
            'user' => $this->getUser(),
        ));
    }


    /**
     * Creates a new Pregunta entity.
     *
     * @Route("/new/{id}", name="_nuevaPregunta")
     */
    public function newAction(Request $request,$id)
    {
        $publicacion = $this->getDoctrine()
            ->getRepository('AppBundle:Publicacion')
            ->find($id);
        $preguntum = new Pregunta();
        $preguntum->setDeUsuario($this->getUser());
        $preguntum->setPublicacion($publicacion);
        $preguntum->setAUsuario($publicacion->getUsuario());
        $preguntum->setRespondido(false);
        $preguntum->setRespuesta('');
        $preguntum->setFecha(new \DateTime('now'));
        $form = $this->createForm('AppBundle\Form\PreguntaType', $preguntum);
        $form
            ->remove('respuesta')
            ->remove('Responder');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($preguntum);
            $em->flush();

            return $this->redirectToRoute('_mostrarPublicacion', array('id' => $publicacion->getId()));
        }

        return $this->render(':default/pregunta:new.html.twig', array(
            'preguntum' => $preguntum,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Pregunta entity.
     *
     */
    public function showAction(Pregunta $preguntum)
    {
        $deleteForm = $this->createDeleteForm($preguntum);

        return $this->render(':default/pregunta:show.html.twig', array(
            'preguntum' => $preguntum,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Pregunta entity.
     * @Route("/newResp/{id}", name="_nuevaRespuesta")
     */
    public function editAction(Request $request,$id)
    {
        $preguntum = $this->getDoctrine()
            ->getRepository('AppBundle:Pregunta')
            ->find($id);
        $deleteForm = $this->createDeleteForm($preguntum);
        $editForm = $this->createForm('AppBundle\Form\PreguntaType', $preguntum);
        $editForm 
            ->remove('pregunta')
            ->remove('Preguntar');
        $editForm->handleRequest($request);
        $publicacion = $preguntum->getPublicacion();

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $preguntum->setRespondido(true);
            $em = $this->getDoctrine()->getManager();
            $em->persist($preguntum);
            $em->flush();

            return $this->redirectToRoute('_mostrarPublicacion', array('id' =>$publicacion->getId()));
        }

        return $this->render(':default/pregunta:responder.html.twig', array(
            'preguntum' => $preguntum,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Pregunta entity.
     * @Route("/eliminarRespuesta/{id}",name="_eliminarRespuesta")
     */
    public function deleteAction(Request $request, $id)
    {
        $preguntum = $this->getDoctrine()
            ->getRepository('AppBundle:Pregunta')
            ->find($id);
        $form = $this->createDeleteForm($preguntum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($preguntum);
            $em->flush();
        }

        return $this->redirectToRoute('pregunta_index');
    }

    /**
     * Creates a form to delete a Pregunta entity.
     *
     * @param Pregunta $preguntum The Pregunta entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Pregunta $preguntum)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('_eliminarRespuesta', array('id' => $preguntum->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
