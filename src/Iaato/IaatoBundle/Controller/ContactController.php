<?php

namespace Iaato\IaatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ContactController extends Controller
{
    public function indexAction()
    {
        return $this->render('IaatoIaatoBundle:Contact:index.html.twig',array('content' => 'contact'));
	
    }

}

?>
