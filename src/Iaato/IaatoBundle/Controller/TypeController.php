<?php

namespace Iaato\IaatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Iaato\IaatoBundle\Entity\Type;
use Symfony\Component\Security\Core\SecurityContext;

class TypeController extends Controller
{
  public function indexAction(){

    $em = $this->getDoctrine()->getEntityManager();
    $query = $em->createQuery('SELECT t.labelType FROM IaatoIaatoBundle:Type t');
    $types = $query->getResult();
    return $this->render('IaatoIaatoBundle:Type:index.html.twig', array('types' => $types));
  
  }

  public function addAction(){

    $type = new Type();
    $formBuilder = $this->createFormBuilder($type);
    $formBuilder
      ->add('labelType','text');
    $form = $formBuilder->getForm();

    $request = $this->get('request');

    if ($request->getMethod() == 'POST'){
      $form->bind($request);
      
      if ($form->isValid()){
        $em = $this->getDoctrine()->getManager();
        
        if($em->getRepository("IaatoIaatoBundle:Type")->findOneBy(array('labelType' => $type->getLabelType()))!=NULL)
          return $this->render('IaatoIaatoBundle:Type:add.html.twig',array(
            'form'=>$form->createView(),
            'error'=>'Type "'.$type->getLabelType().'" not added : Label already exists',
            'sucess'=>''
          ));

          $em->persist($type);
          $em->flush();
          
          return $this->render('IaatoIaatoBundle:Type:add.html.twig',array(
            'form'=>$form->createView(),
            'sucess'=>'Type "'.$type->getlabelType().'" added.',
            'error'=>''
          ));
      }

    }
    
    return $this->render('IaatoIaatoBundle:Type:add.html.twig',array(
      'form'=>$form->createView(),
      'error'=>'',
      'sucess'=>''));

  }

  public function removeAction(){

    $em = $this->getDoctrine()->getEntityManager();
    $types = $em->getRepository("IaatoIaatoBundle:Type")->findAll();
    $stack = array();

    foreach($types as $type)
      $stack[$type->getLabelType()] = $type->getLabelType();      
    $type = new Type();

    $formBuilder = $this->createFormBuilder($type);
    $formBuilder
      ->add('labelType', 'choice', array(
        'choices' => $stack,
        'required' => false,'label'=>'Type','multiple'=>false
    ));       
    $form = $formBuilder->getForm();
    
    $request = $this->get('request');

    if ($request->getMethod() == 'POST'){
    $form->bind($request);
    if ($form->isValid()){
        unset($stack[$type->getLabelType()]);
        
        $type = $em->getRepository("IaatoIaatoBundle:TYpe")->findOneBy(array('labelType'=>$type->getLabelType()));
        $formBuilder = $this->createFormBuilder($type);
        $formBuilder
          ->add('labelType', 'choice', array(
        'choices' => $stack,
        'required' => false,'label'=>'Type','multiple'=>false
        ));
        $form = $formBuilder->getForm();
    
        $em->remove($type);
        $em->flush();
        return $this->render('IaatoIaatoBundle:Type:remove.html.twig',array(
        'form'=>$form->createView(),
        'success'=>'The type "'.$type->getLabelType().'" has been removed succesfully.',
        'error'=>''));
    }
    
    return $this->render('IaatoIaatoBundle:Type:remove.html.twig',array(
      'form'=>$form->createView(),
      'success'=>'',
      'error'=>'ERROR : something wrong happened but i don\'t know what ! '));
    }

    return $this->render('IaatoIaatoBundle:Type:remove.html.twig',array(
      'form'=>$form->createView(),
      'success'=>'',
      'error'=>''));

  }

}

?>