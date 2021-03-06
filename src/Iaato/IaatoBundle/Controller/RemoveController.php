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
			$stack[$util->getUsername()] = $util->getUsername();
		//sort($stack);
		$user = new User();
		$formBuilder = $this->createFormBuilder($user);
		$formBuilder
			->add('username', 'choice', array(
        'choices' => $stack,
        'required' => false,'label'=>'Roles','multiple'=>false
    ));
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
				if($user==NULL)
				{
				  return $this->render('IaatoIaatoBundle:Remove:index.html.twig',array(
				    'sucess'=>'',
				    'error'=>'ERROR : User "'.$nom.'"does not exist.',
				    'form_supp' => $form->createView(),
				    'liste_user'=> $stack));
				  //  return $this->render('IaatoIaatoBundle:Remove:fail.html.twig',array('reason'=>'User do not exists'));		
				}
				$em->remove($user);
				$em->flush();
				unset($stack[$nom]);
				$formBuilder = $this->createFormBuilder($user);
				$formBuilder
					->add('username', 'choice', array(
			'choices' => $stack,
			'required' => false,'label'=>'Roles','multiple'=>false
		    ));
				$form = $formBuilder->getForm();
				return $this->render('IaatoIaatoBundle:Remove:index.html.twig',array(
				    'sucess'=>'User "'.$nom.'" has been removed succesfully.',
				    'error'=>'',
				    'form_supp' => $form->createView(),
				    'liste_user'=> $stack));
			}	
			return $this->render('IaatoIaatoBundle:Remove:index.html.twig',array(
			  'sucess'=>'',
			  'error'=>'ERROR : Invalid form.',
			  'form_supp' => $form->createView(),
			  'liste_user'=> $stack));
		}
		else
		{
			return $this->render('IaatoIaatoBundle:Remove:index.html.twig',array(
			  'sucess'=>'',
			  'error'=>'',
			  'form_supp' => $form->createView(),
			  'liste_user'=> $stack));
		}
	}
	
}
?>

