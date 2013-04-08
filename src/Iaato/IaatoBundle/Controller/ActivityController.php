<?php

namespace Iaato\IaatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Iaato\IaatoBundle\Entity\Activity;
use Symfony\Component\Security\Core\SecurityContext;

class ActivityController extends Controller
{
  public function indexAction(){
    
    $em = $this->getDoctrine()->getEntityManager();
    $query = $em->createQuery('SELECT a.labelActivity FROM IaatoIaatoBundle:Activity a');
    $activities = $query->getResult();
    return $this->render('IaatoIaatoBundle:Activity:index.html.twig', array('activities' => $activities));
  
  }

  public function addAction(){

    $activity = new Activity();
    $formBuilder = $this->createFormBuilder($activity);
    $formBuilder
      ->add('labelActivity','text');
    $form = $formBuilder->getForm();

    $request = $this->get('request');

    if ($request->getMethod() == 'POST'){
      $form->bind($request);
      
      if ($form->isValid()){
        $em = $this->getDoctrine()->getManager();
        
        if($em->getRepository("IaatoIaatoBundle:Activity")->findOneBy(array('labelActivity' => $activity->getLabelActivity()))!=NULL)
          return $this->render('IaatoIaatoBundle:Activity:add.html.twig',array(
            'form'=>$form->createView(),
            'error'=>'Society "'.$activity->getLabelActivity().'" not added : Label already exists',
            'sucess'=>''
          ));

          $em->persist($activity);
          $em->flush();
          
          return $this->render('IaatoIaatoBundle:Activity:add.html.twig',array(
            'form'=>$form->createView(),
            'sucess'=>'Society "'.$activity->getLabelActivity().'" added.',
            'error'=>''
          ));
      }

    }
    
    return $this->render('IaatoIaatoBundle:Activity:add.html.twig',array(
      'form'=>$form->createView(),
      'error'=>'',
      'sucess'=>''));
  }

  public function removeAction(){

    $em = $this->getDoctrine()->getEntityManager();
    $activities = $em->getRepository("IaatoIaatoBundle:Activity")->findAll();
    $stack = array();

    foreach($activities as $activity)
      $stack[$activity->getLabelActivity()] = $activity->getLabelActivity();      
    $activity = new Activity();

    $formBuilder = $this->createFormBuilder($activity);
    $formBuilder
      ->add('labelActivity', 'choice', array(
        'choices' => $stack,
        'required' => false,'label'=>'Activity','multiple'=>false
    ));       
    $form = $formBuilder->getForm();
    
    $request = $this->get('request');

    if ($request->getMethod() == 'POST'){
    $form->bind($request);
    if ($form->isValid()){
        unset($stack[$activity->getLabelActivity()]);
        
        $activity = $em->getRepository("IaatoIaatoBundle:Activity")->findOneBy(array('labelActivity'=>$activity->getLabelActivity()));
        $formBuilder = $this->createFormBuilder($activity);
        $formBuilder
          ->add('labelActivity', 'choice', array(
        'choices' => $stack,
        'required' => false,'label'=>'Activity','multiple'=>false
        ));
        $form = $formBuilder->getForm();
    
        $em->remove($activity);
        $em->flush();
        return $this->render('IaatoIaatoBundle:Activity:remove.html.twig',array(
        'form'=>$form->createView(),
        'success'=>'The activity "'.$activity->getLabelActivity().'" has been removed succesfully.',
        'error'=>''));
    }
    
    return $this->render('IaatoIaatoBundle:Activity:remove.html.twig',array(
      'form'=>$form->createView(),
      'success'=>'',
      'error'=>'ERROR : something wrong happened but i don\'t know what ! '));
    }

    return $this->render('IaatoIaatoBundle:Activity:remove.html.twig',array(
      'form'=>$form->createView(),
      'success'=>'',
      'error'=>''));

  }

}

?>