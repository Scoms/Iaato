<?php

// StepController.php

namespace Iaato\IaatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\Security\Core\SecurityContext;

class StepController extends Controller
{
    public function indexAction()
    {
      $em = $this->getDoctrine()->getEntityManager();
      return $this->render('IaatoIaatoBundle:Step:show.html.twig');
    }
    public function addAction()
    {
      $em = $this->getDoctrine()->getEntityManager();
      return $this->render('IaatoIaatoBundle:Step:add.html.twig');
    }
    public function removeAction()
    {
      $em = $this->getDoctrine()->getEntityManager();
      return $this->render('IaatoIaatoBundle:Step:remove.html.twig');
    }
}
