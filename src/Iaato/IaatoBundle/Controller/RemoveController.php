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

class RemoveController extends Controller
{

	public function indexAction()
	{
		$em = $this->getDoctrine()->getEntityManager();
		$liste_user = $em->getRepository("IaatoUserBundle:User")->findAll();
		$stack = array();
		foreach($liste_user as $util)
			array_push($stack,$util->getUsername());
		sort($stack);
		$user = new User();
		$formBuilder = $this->createFormBuilder($user);
		$formBuilder
			->add('username', 'text');
		$form = $formBuilder->getForm();
		$request = $this->get('request');	
		if ($request->getMethod() == 'POST')
		{
			$form->bind($request);
			if ($form->isValid())
			{
				$em = $this->getDoctrine()->getManager();
				$nom = $user->getUsername();
				$user = $em->getRepository('IaatoUserBundle:User')->findOneBy(array('username' => $nom));
				$em->remove($user);
				$em->flush();
				return $this->render('IaatoIaatoBundle:Remove:sucess.html.twig',array('nom'=>$nom));
			}	
			return $this->render('IaatoIaatoBundle:Remove:fail.html.twig');
		}
		else
		{
			return $this->render('IaatoIaatoBundle:Remove:index.html.twig',array( 'form_supp' => $form->createView(),'liste_user'=> $stack));
		}
	}
	
}
?>
