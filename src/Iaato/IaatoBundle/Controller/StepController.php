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
      $user = $this->get('security.context')->getToken()->getUser();
      $ship = $user->getShip();
      if($ship==NULL)
      {
	//Display a choice box
	$ship = "unkown";
      }
      else
      {
	$ship = $ship->getNameShip();
      }
      
      return $this->render('IaatoIaatoBundle:Step:show.html.twig',array(
	'ship'=>$ship
      ));
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
