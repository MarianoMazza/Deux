<?php
/**
 * Created by PhpStorm.
 * User: alephzero
 * Date: 28/05/16
 * Time: 18:27
 */

namespace AppBundle\Controller\Admin;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BackendController extends Controller
{
    /**
     * @Route("/admin", name="_backend")
     */
    public function backendAction(){
        return $this->render(':default/administrador:backend.html.twig');
    }
}