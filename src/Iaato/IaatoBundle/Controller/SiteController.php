<?php

namespace Iaato\IaatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Bridge\Doctrine\Form\ChoiceList\EntityChoiceList;
use Iaato\IaatoBundle\Entity\Site;
use Iaato\IaatoBundle\Entity\SubZone;
use Symfony\Component\Security\Core\SecurityContext;

class SiteController extends Controller{

  public function indexAction(){

    $em = $this->getDoctrine()->getEntityManager();
    $sites = $em->getRepository('IaatoIaatoBundle:Site')->findAll();
    return $this->render('IaatoIaatoBundle:Site:index.html.twig', array('sites' => $sites));
  }

  public function addAction(){

      $site = new Site();

      $entityManager = $this->getDoctrine()->getEntityManager();

      $subzones = new EntityChoiceList($entityManager,'Iaato\IaatoBundle\Entity\SubZone');

      $formBuilder = $this->createFormBuilder($site);
      $formBuilder
        ->add('nameSite','text')
        ->add('latitude', 'text')
        ->add('longitude', 'text')
        ->add('iaato', 'checkbox', array(
          'required' => false
        ))
        ->add('subzone','choice',array('choice_list'=> $subzones,
          'label'=>'SubZones',
          'empty_value' => '-- Choose a subzone --'
        ));
      $form = $formBuilder->getForm();
      $request = $this->get('request');
      
      if ($request->getMethod() == 'POST'){
      
      $form->bind($request);

      if ($form->isValid()){
          $em = $this->getDoctrine()->getManager();
          
          if($em->getRepository("IaatoIaatoBundle:Site")->findOneBy(array('nameSite' => $site->getNameSite()))!=NULL)
            return $this->render('IaatoIaatoBundle:Site:add.html.twig',array(
                'form'=>$form->createView(),
                'error'=>'Site "'.$site->getNameSite().'" not added : Name already exists',
                'sucess'=>''
              ));
          
          $em->persist($site);
          $em->flush();
        
          return $this->render('IaatoIaatoBundle:Site:add.html.twig',array(
            'form'=>$form->createView(),
            'sucess'=>'Site "'.$site->getNameSite().'" added.',
            'error'=>''
          ));       
      }

      }

      return $this->render('IaatoIaatoBundle:Site:add.html.twig',array(
        'form'=>$form->createView(),
          'error'=>'',
          'sucess'=>''
      ));

  }

  public function removeAction(){
  
    $em = $this->getDoctrine()->getEntityManager();
    $sites = $em->getRepository("IaatoIaatoBundle:Site")->findAll();
    $stack = array();

    foreach($sites as $site)
      $stack[$site->getNameSite()] = $site->getNameSite();      
    $site = new Site();

    $formBuilder = $this->createFormBuilder($site);
    $formBuilder
      ->add('nameSite', 'choice', array(
        'choices' => $stack,
        'required' => false,'label'=>'Site','multiple'=>false
    ));       
    $form = $formBuilder->getForm();
    
    $request = $this->get('request');

    if ($request->getMethod() == 'POST'){
    $form->bind($request);
    if ($form->isValid()){
        unset($stack[$site->getNameSite()]);
        
        $site = $em->getRepository("IaatoIaatoBundle:Site")->findOneBy(array('nameSite'=>$site->getNameSite()));
        $formBuilder = $this->createFormBuilder($site);
        $formBuilder
          ->add('nameSite', 'choice', array(
        'choices' => $stack,
        'required' => false,'label'=>'Site','multiple'=>false
        ));
        $form = $formBuilder->getForm();
    
        $em->remove($site);
        $em->flush();
        return $this->render('IaatoIaatoBundle:Site:remove.html.twig',array(
        'form'=>$form->createView(),
        'success'=>'The site "'.$site->getNameSite().'" has been removed succesfully.',
        'error'=>''));
    }
    
    return $this->render('IaatoIaatoBundle:Site:remove.html.twig',array(
      'form'=>$form->createView(),
      'success'=>'',
      'error'=>'ERROR : something wrong happened but i don\'t know what ! '));
    }

    return $this->render('IaatoIaatoBundle:Site:remove.html.twig',array(
      'form'=>$form->createView(),
      'success'=>'',
      'error'=>''));

  }

}

?>