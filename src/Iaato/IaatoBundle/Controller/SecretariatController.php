<?php

namespace Iaato\IaatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

class SecretariatController extends Controller
{

    /**
    * @Secure(roles="ROLE_SECRETARIAT")
    */
    public function indexAction()
    {
        return $this->render('IaatoIaatoBundle:Secretariat:index.html.twig',array('content' => 'Secrétariat'));
	
    }

}
