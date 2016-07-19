<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Comision;

/**
 * Comision controller.
 *
 */
class ComisionController extends Controller
{
    /*
    public function comisionesAction(Request $request)
    {
        $comision = new Comision();
        $form = $this->createForm('AppBundle\Form\ComisionType', $comision);
        $form->handleRequest($request);

        $comisiones = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $form->getData();
        }

        return $this->render('comision/index.html.twig', array(
            'form'=>$form->createView(),
            'comisiones'=>$comisiones,
        ));
    }
    */

    /**
     * Lists all Comision entities.
     *
     * @Route("/admin/comisiones", name="comision_index")
     */
    public function indexAction(Request $request)
    {
        $total = 0;
        $comision = new Comision();
        $form = $this->createForm('AppBundle\Form\ComisionType', $comision);
        $form->handleRequest($request);

        $comisiones = [];
        if ($form->isSubmitted() && $form->isValid()) {
        }
        /*
        foreach ($comisions as $comision){
            $total += $comision->getGanancia();
        }
        $pagos = $em->getRepository('AppBundle:Pago')->findAll();
        foreach ($pagos as $pago){
            $total += $pago->getMonto();
        }
        */
        return $this->render('comision/index.html.twig', array(
            'comisions' => $comisiones,
            'total' => $total,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new Comision entity.
     *
     * @Route("/newComision/{id}", name="_newComision")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request,$id)
    {
        $comision = new Comision();
        $porcentaje = $this->getDoctrine()->getRepository('AppBundle:Porcentaje')->findBy(array(),array('id'=>'DESC'));

        $publicacion = $this->getDoctrine()->getRepository('AppBundle:Publicacion')->find($id);
        $form = $this->createForm('AppBundle\Form\ComisionType', $comision);
        $comision->setFecha(new \DateTime('today'));
        $comision->setPublicacion($id);
        $comision->setPorcentaje($porcentaje[0]->getPorcentaje());
        $comision->setMonto($publicacion->getCosto());
        $comision->setGanancia($publicacion->getCosto()*$comision->getPorcentaje()/100);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($comision);
            $em->flush();
        }
    }
}
