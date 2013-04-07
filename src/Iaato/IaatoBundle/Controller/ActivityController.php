<?php

namespace Iaato\IaatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Iaato\IaatoBundle\Entity\Activity;
use Symfony\Component\Security\Core\SecurityContext;

class ActivityController extends Controller
{
  public function indexAction(){
    
    $em = $this->getDoctrine()->getEntityManager();
    $query = $em->createQuery('SELECT a.labelActivity FROM IaatoIaatoBundle:Activity a');
    $activities = $query->getResult();
    return $this->render('IaatoIaatoBundle:Activity:index.html.twig', array('activities' => $activities));
  
  }

  public function addAction()
  {
    return $this->render('IaatoIaatoBundle:Activity:add.html.twig');
  }
  public function removeAction()
  {
    return $this->render('IaatoIaatoBundle:Activity:remove.html.twig');
  }
}

?>