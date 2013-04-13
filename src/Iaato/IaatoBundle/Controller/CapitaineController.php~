<?php

// CapitaineController.php

namespace Iaato\IaatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\Security\Core\SecurityContext;

class CapitaineController extends Controller
{
    public function indexAction()
    {
    
	$request = $this->getRequest();
	$session = $request->getSession();
	$role = $this->get('security.context');
	// Si l'utilisateur est authetifié
	if($role->isGranted('IS_AUTHENTICATED_REMEMBERED'))
	{
	//BON ROLE
	  if( ($role->isGranted('ROLE_CAPITAINE') || $role->isGranted('ROLE_ADMIN')))
	  {
	     return $this->render('IaatoMapBundle:Default:index.html.twig');
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
	  return $this->render('IaatoUserBundle:Security:login.html.twig', array('last_username' => $session->get(SecurityContext::LAST_USERNAME),'error'=> $error,));
    }

}
