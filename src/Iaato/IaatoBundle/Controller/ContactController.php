<?php

// vim: set et sw=4 ts=4 sts=4 fdm=marker ff=unix fenc=utf8
/**
 * ContactController.php
 *
 * @author
 * @date 2013/03/13
 * @link
 */

namespace Iaato\IaatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Iaato\IaatoBundle\Entity\Contact;

class ContactController extends Controller{
	
	public function indexAction(){
		$contact = new Contact();
		$formBuilder = $this->createFormBuilder($contact);
		$formBuilder
			->add('nom',	'text')
			->add('email',	'email')
			->add('sujet',	'text')
			->add('message',	'textarea', array('max_length' => 250));
		$form = $formBuilder->getForm();
	
		$request = $this->get('request');

		if ($request->getMethod() == 'POST'){
			$form->bind($request);
			
			if ($form->isValid()){
				return $this->render('IaatoIaatoBundle:Contact:mailto.html.twig', array(
					'nom' => $contact->getNom(), 
					'email' => $contact->getEmail(),
					'sujet' => $contact->getSujet(),
					'message' => $contact->getMessage()
				));
			}

		}
	
		return $this->render('IaatoIaatoBundle:Contact:index.html.twig', array('form' => $form->createView()));
	}
	
	/*public function setContact
	public function mailtoAction(){
		return $this->render('IaatoIaatoBundle:Contact:mailto.html.twig',array('content' => 'Votre message a bien été envoyé'));
	}*/

}


?>

