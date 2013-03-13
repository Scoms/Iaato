<?php

namespace Iaato\IaatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SecretariatController extends Controller
{
    public function indexAction()
    {
        return $this->render('IaatoIaatoBundle:Secretariat:index.html.twig',array('content' => 'Secrétariat'));
	
    }

}
