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
			->add('message',	'textarea');
		$form = $formBuilder->getForm();
		return $this->render('IaatoIaatoBundle:Contact:index.html.twig', array('content' => 'OUAIS', 'form' => $form->createView()));
	}

	public function mailtoAction(){
		return $this->render('IaatoIaatoBundle:Contact:mailto.html.twig',array('content' => 'Votre message a bien été envoyé'));
	}

}


?>

