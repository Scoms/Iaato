<?php
// vim: set et sw=4 ts=4 sts=4 fdm=marker ff=unix fenc=utf8
/**
 * HomeController.php
 *
 * @author
 * @date 2013/03/13
 * @link
 */

namespace Iaato\IaatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Iaato\UserBundle\Entity\User;

class AdminController extends Controller
{
	public function indexAction()
	{
		$entityManager = $this->getDoctrine()->getEntityManager();
		/*
		 * Formulaire d'inscription
		 */
		$liste_roles = $entityManager->getRepository("IaatoUserBundle:Role")->findAll();
		$stack = array();
		foreach($liste_roles as $role)
			array_push($stack,$role->getNom());
		$user = new User();
		$formBuilder = $this->createFormBuilder($user);
		$formBuilder
			->add('username',	'text')
			->add('roles', 'choice', array(
        'choices' => array("ROLE_ADMIN"=>"administrateur","ROLE_SECRETARIAT"=>"secretariat","ROLE_CAPITAINE"=>"capitaine"),
        'required' => false,'label'=>'Roles','multiple'=>true
    ))
			->add('password', 'repeated', array(
			'type' => 'password',
			'invalid_message' => 'The password fields must match.',
			'options' => array('attr' => array('class' => 'password-field')),
			'required' => true,
			'first_options'  => array('label' => 'Password'),
			'second_options' => array('label' => 'Repeat Password'),
				))
			;
				
		$form = $formBuilder->getForm();
		/*
		 * Formulaire de suppression
		*/
		
		$request = $this->get('request');
			
		if ($request->getMethod() == 'POST')
		{
			$form->bind($request);
			if ($form->isValid())
			{
				$em = $this->getDoctrine()->getManager();
				$user->setPassword(sha1($user->getPassword()));
				$user->setSalt('');
				$em->persist($user);
				$em->flush();
			}			
				return $this->render('IaatoIaatoBundle:Admin:sucess.html.twig');
		}
		return $this->render('IaatoIaatoBundle:Admin:index.html.twig',array('form_add' => $form->createView()));
	}
	
}
?>

