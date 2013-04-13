<?php

namespace Iaato\IaatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Iaato\IaatoBundle\Entity\Society;
use Symfony\Component\Security\Core\SecurityContext;

class SiteController extends Controller
{
  public function indexAction()
  {
    return $this->render('IaatoIaatoBundle:Site:index.html.twig');
  }
  public function addAction()
  {
    return $this->render('IaatoIaatoBundle:Site:add.html.twig');
  }
  public function removeAction()
  {
    return $this->render('IaatoIaatoBundle:Site:remove.html.twig');
  }
}

?>