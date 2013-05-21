<?php

namespace Iaato\MapBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Iaato\MapBundle\Controller\GoogleMapAPI;

class DefaultController extends Controller
{
    public function indexAction()
    {
        
	$em = $this->getDoctrine()->getManager();
	$request = $this->getRequest();
	$session = $request->getSession();
	$role = $this->get('security.context');
	$user = $this->get('security.context')->getToken()->getUser();
	$ship = $user->getShip();
	$repo_step = $em->getRepository('IaatoIaatoBundle:Step');
	$ship_id = $ship->getId();
	//On récupère la liste des steps.
	$query_builder = $em->createQueryBuilder();
	$query = $em->createQuery(
	'SELECT st FROM IaatoIaatoBundle:Step st 
	INNER JOIN IaatoIaatoBundle:TimeSlot ts with st.timeslot = ts.id
	INNER JOIN IaatoIaatoBundle:TimeSlotLabel tsl with ts.label = tsl.id
	WHERE st.ship = '.$ship_id.'
	ORDER BY ts.date ASC, tsl.id ASC
	'
	);

      $array_step = $query->getResult();
	// Si l'utilisateur est authetifié
	if($role->isGranted('IS_AUTHENTICATED_REMEMBERED'))
	{
	//BON ROLE
	  if( ($role->isGranted('ROLE_CAPITAINE') || $role->isGranted('ROLE_ADMIN')))
	  {
	    return $this->render('IaatoMapBundle:Map:map.html.twig',array('array_step'=>$array_step));
	  }
	  // MAUVAIS ROLE
	}
	// Sinon interface de login
	
	  // On verifie s'il y a des erreurs d'une précédente soumission du formulaire
	  if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) 
	  {
	    $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
	  } 
	  else 
	  {
	    $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
	    $session->remove(SecurityContext::AUTHENTICATION_ERROR);
	  }
	  //Authentification
	  return $this->render('IaatoUserBundle:Security:login.html.twig', array('last_username' => $session->get(SecurityContext::LAST_USERNAME),'error'=> $error,'list_step'=>$list_step));
    }
}
