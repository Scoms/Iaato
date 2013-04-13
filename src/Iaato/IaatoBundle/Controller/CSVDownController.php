<?php

namespace Iaato\IaatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Iaato\IaatoBundle\Entity\Society;
use Symfony\Component\Security\Core\SecurityContext;

class CSVDownController extends Controller
{
  public function indexAction()
  {
    return $this->render('IaatoIaatoBundle:CSV:download.html.twig');
  }
}

?>