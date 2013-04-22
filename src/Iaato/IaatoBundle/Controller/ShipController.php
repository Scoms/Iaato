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
use Symfony\Bridge\Doctrine\Form\ChoiceList\EntityChoiceList;
use Symfony\Component\Form\FormView;
use Iaato\IaatoBundle\Form\EmailType;
use Iaato\IaatoBundle\Form\PhoneType;
use Iaato\IaatoBundle\Entity\Ship;
use Iaato\IaatoBundle\Entity\Email;
use Iaato\IaatoBundle\Entity\Society;

class ShipController extends Controller {

	public function indexAction(){
		
		$em = $this->getDoctrine()->getEntityManager();
		$query = $em->createQuery('SELECT s.code, s.nameShip, s.nbPassenger, t.labelType, so.labelSociety FROM IaatoIaatoBundle:Ship s LEFT JOIN s.idtype t LEFT JOIN s.society so');
		$ships = $query->getResult();
		return $this->render('IaatoIaatoBundle:Ship:index.html.twig', array('ships' => $ships));
	
	}

	public function addAction(){
		
		$ship = new Ship();
		$entityManager = $this->getDoctrine()->getEntityManager();
		
        $email1 = new Email();
        $ship->addEmail($email1);
        $email2 = new Email();
        $ship->addEmail($email2);
        
        $societies = new EntityChoiceList($entityManager,'Iaato\IaatoBundle\Entity\Society');

		$types = new EntityChoiceList($entityManager,'Iaato\IaatoBundle\Entity\Type');

		$formBuilder = $this->createFormBuilder($ship);
		$formBuilder
			->add('code',	'text')
			->add('nameShip',	'text')
			->add('society','choice',array('choice_list'=> $societies,
				'label'=>'Societies',
				'empty_value' => '-- Choose a society --'
			))
			->add('nbPassenger',	'text')
			->add('type','choice',array('choice_list'=> $types,
				'label'=>'Types',
				'empty_value' => '-- Choose a type --'
			))
			->add('email', 'collection', array('type' => new EmailType()))
			->add('phone', 'collection', array('type' => new PhoneType()));
			
	    $form = $formBuilder->getForm();
	    $request = $this->get('request');
	    
	    if ($request->getMethod() == 'POST'){
			
			$form->bind($request);

			if ($form->isValid()){
		  		$em = $this->getDoctrine()->getManager();
		  		
		  		if($em->getRepository("IaatoIaatoBundle:Ship")->findOneBy(array('code' => $ship->getCode()))!=NULL)
		    		return $this->render('IaatoIaatoBundle:Ship:add.html.twig',array(
		      			'form'=>$form->createView(),
		      			'error'=>'Ship "'.$ship->getCode().'" not added : Code already exists',
		      			'sucess'=>''
		      		));
		  		
		  		$em->persist($ship);
		  		$em->flush();
		  	
		  		return $this->render('IaatoIaatoBundle:Ship:add.html.twig',array(
		    		'form'=>$form->createView(),
		    		'sucess'=>'Ship "'.$ship->getCode().'" added.',
		    		'error'=>''
		    	));	    	
			}

	    }

	    return $this->render('IaatoIaatoBundle:Ship:add.html.twig',array(
	    	'form'=>$form->createView(),
	      	'error'=>'',
	      	'sucess'=>''
	    ));

	}

	public function removeAction(){
	
		$em = $this->getDoctrine()->getEntityManager();
	    $ships = $em->getRepository("IaatoIaatoBundle:Ship")->findAll();
	    $stack = array();

	    foreach($ships as $ship)
		    $stack[$ship->getNameShip()] = $ship->getNameShip();	    
	    $ship = new Ship();

	    $formBuilder = $this->createFormBuilder($ship);
	    $formBuilder
		    ->add('nameShip', 'choice', array(
	        'choices' => $stack,
	        'required' => false,'label'=>'Ship','multiple'=>false
	    ));		    
	    $form = $formBuilder->getForm();
	    
	    $request = $this->get('request');

	    if ($request->getMethod() == 'POST'){
			$form->bind($request);
			if ($form->isValid()){
		  		unset($stack[$ship->getNameShip()]);
		  		
		  		$ship = $em->getRepository("IaatoIaatoBundle:Ship")->findOneBy(array('nameShip'=>$ship->getNameShip()));
		  		$formBuilder = $this->createFormBuilder($ship);
		  		$formBuilder
			    	->add('nameShip', 'choice', array(
					'choices' => $stack,
					'required' => false,'label'=>'Company','multiple'=>false
		    	));
		    	$form = $formBuilder->getForm();
		  
		  		$em->remove($ship);
		  		$em->flush();
		  		return $this->render('IaatoIaatoBundle:Ship:remove.html.twig',array(
		    	'form'=>$form->createView(),
		    	'success'=>'The ship "'.$ship->getNameShip().'" has been removed succesfully.',
		    	'error'=>''));
			}
			
			return $this->render('IaatoIaatoBundle:Ship:remove.html.twig',array(
		    'form'=>$form->createView(),
		    'success'=>'',
		    'error'=>'ERROR : something wrong happened but i don\'t know what ! '));
	    }

	    return $this->render('IaatoIaatoBundle:Ship:remove.html.twig',array(
	      'form'=>$form->createView(),
	      'success'=>'',
	      'error'=>''));

	}

}

?>

