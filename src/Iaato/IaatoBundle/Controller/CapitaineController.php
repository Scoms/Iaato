<?php

namespace Iaato\IaatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use JMS\SecurityExtraBundle\Annotation\Secure;

class CapitaineController extends Controller
{

    /**
    * @Secure(roles="ROLE_CAPITAINE , ROLE_ADMIN")
    *
    */
    public function indexAction()
    {
        return $this->render('IaatoIaatoBundle:Capitaine:index.html.twig',array('content' => 'Capitaine'));
    }

}
