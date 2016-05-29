<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Publicacion;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller
{
    /**
     * @Route("/", name="_index")
     */
    public function indexAction(){
       return $this->render(':default:index.html.twig');
    }
}