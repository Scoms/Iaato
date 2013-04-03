<?php
// vim: set et sw=4 ts=4 sts=4 fdm=marker ff=unix fenc=utf8
/**
 * Ship.php
 *
 * @author
 * @date 2013/03/24
 * @link
 */

namespace Iaato\IaatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\Security\Core\SecurityContext;
use Iaato\IaatoBundle\Entity\Ship;
use Iaato\IaatoBundle\Entity\Society;

class ShipController extends Controller {

	public function indexAction(){
		
		$em = $this->getDoctrine()->getEntityManager();
		$query = $em->createQuery('SELECT s.code, s.nameShip, s.nbPassenger, t.labelType, so.labelSociety FROM IaatoIaatoBundle:Ship s LEFT JOIN s.idtype t LEFT JOIN s.society so');
		$ships = $query->getResult();
		return $this->render('IaatoIaatoBundle:Secretariat:ship.html.twig', array('ships' => $ships));
	
	}

	public function addshipAction(){
		$ship = new Ship();
		$society = new Society();
		$society = $this->getDoctrine()->getRepository('IaatoIaatoBundle:Society')->findAll();
		
		foreach($liste_roles as $role)
			array_push($stack,$role->getNom());

		$formBuilder = $this->createFormBuilder($ship);
		$formBuilder
			->add('code',	'text')
			->add('nameShip',	'text')
			->add('society',	'choice', array())
			->add('nbPassenger',	'text')
			->add('type',	'text')
			->add('email',	'email')
			->add('phone',	'text');
		$form = $formBuilder->getForm();
		
		// On récupère la requête
		$request = $this->get('request');
		
		// On vérifie qu'elle est de type POST
		if ($request->getMethod() == 'POST'){

			// On fait le lien requête / formulaire 
			// La variable $ship contient les données entrées par l'utilisateur
			$form->bind($request);
			
			// On vérifie que les valeurs sont correctes
			if ($form->isValid()){

				// On enregistre les données dans la BDD et retourne sur ship.html.twig
				$em = $this->getDoctrine()->getManager();
				$em = persist($ship);
				$em = flush();

				return $this->render('IaatoIaatoBundle:Secretariat:ship.html.twig');
			}

		}
	
		return $this->render('IaatoIaatoBundle:Secretariat:addship.html.twig', array('formaddship' => $form->createView()));
	}

	public function deleteshipAction(){
	
		return $this->render('IaatoIaatoBundle:Secretariat:deleteship.html.twig');

	}

	public function changeshipAction(){

		return $this->render('IaatoIaatoBundle:Secretariat:changeship.html.twig');

	}

}

?>

