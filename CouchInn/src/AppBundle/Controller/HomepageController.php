<?php
/**
 * Created by PhpStorm.
 * User: rkzap
 * Date: 5/20/2016
 * Time: 12:29 AM
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomepageController extends Controller
{
    /**
     * @Route("/home", name="_home")
     */
    public function homePageController(){
        return $this->render(':default:homepage.html.twig');
    }
}