<?php

namespace Iaato\IaatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ConnexionController extends Controller
{
    public function indexAction()
    {
        return $this->render('IaatoIaatoBundle:Home:index.html.twig',array('content' => 'Connexion'));
	
    }

}
