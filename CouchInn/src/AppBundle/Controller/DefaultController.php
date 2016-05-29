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
        return $this->render(':default:index.html.twig');
    }

    /**
     * @Route("/home", name="_home")
     */
    public function homepageAction(){
        return $this->render(':default:homepage.html.twig');
    }

    /**
     * @Route("/hecho", name="_hecho")
     */
    public function succesAction(){
        return $this->render(':default:hecho.html.twig');
    }
}