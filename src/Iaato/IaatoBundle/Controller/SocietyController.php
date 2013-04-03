<?php

namespace Iaato\IaatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\Security\Core\SecurityContext;

class SocietyController extends Controller
{
  public function indexAction()
  {
  
    return $this->render('IaatoIaatoBundle:Society:index.html.twig');
  }
  public function addAction()
  {
    return $this->render('IaatoIaatoBundle:Society:add.html.twig');
  }
  public function removeAction()
  {
    return $this->render('IaatoIaatoBundle:Society:remove.html.twig');
  }
}

?>