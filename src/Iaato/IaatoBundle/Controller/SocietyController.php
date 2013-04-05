<?php

namespace Iaato\IaatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Iaato\IaatoBundle\Entity\Society;
use Symfony\Component\Security\Core\SecurityContext;

class SocietyController extends Controller
{
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $society_list = $em->getRepository("IaatoIaatoBundle:Society")->findAll();
    return $this->render('IaatoIaatoBundle:Society:index.html.twig',array('society_list'=>$society_list));
  }
  public function addAction()
  {
    $society = new Society();
    $formBuilder = $this->createFormBuilder($society);
    $formBuilder
	    ->add('labelSociety','text');
    $form = $formBuilder->getForm();
    $request = $this->get('request');
    if ($request->getMethod() == 'POST')
    {
	$form->bind($request);
	if ($form->isValid())
	{
	  $em = $this->getDoctrine()->getManager();
	  if($em->getRepository("IaatoIaatoBundle:Society")->findOneBy(array('labelSociety' => $society->getLabelSociety()))!=NULL)
	    return $this->render('IaatoIaatoBundle:Society:add.html.twig',array(
	      'form'=>$form->createView(),
	      'error'=>'Society "'.$society->getLabelSociety().'" not added : Label already exists',
	      'sucess'=>''));
	  $em->persist($society);
	  $em->flush();
	  return $this->render('IaatoIaatoBundle:Society:add.html.twig',array(
	    'form'=>$form->createView(),
	    'sucess'=>'Society "'.$society->getLabelSociety().'" added.',
	    'error'=>''));
	}

    }
    return $this->render('IaatoIaatoBundle:Society:add.html.twig',array(
      'form'=>$form->createView(),
      'error'=>'',
      'sucess'=>''));
  }
  public function removeAction()
  {
    $society = new Society();
    $formBuilder = $this->createFormBuilder($society);
    $formBuilder
	    ->add('labelSociety','text');
    $form = $formBuilder->getForm();
    $request = $this->get('request');
    if ($request->getMethod() == 'POST')
    {
	$form->bind($request);
	if ($form->isValid())
	{
	  $em = $this->getDoctrine()->getManager();
	  $em->persist($society);
	  $em->flush();
	  return $this->render('IaatoIaatoBundle:Society:add.html.twig',array('form'=>$form->createView(),'message'=>'Society "" added.'));
	}

    }
    return $this->render('IaatoIaatoBundle:Society:remove.html.twig');
  }
}

?>