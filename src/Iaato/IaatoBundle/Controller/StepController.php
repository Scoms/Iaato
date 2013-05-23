<?php

// StepController.php

namespace Iaato\IaatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Bridge\Doctrine\Form\ChoiceList\EntityChoiceList;
use Iaato\IaatoBundle\Entity\Step;

class StepController extends Controller
{
    public function indexAction()
    {
      $em = $this->getDoctrine()->getEntityManager();
      $repo_step = $em->getRepository('IaatoIaatoBundle:Step');
      $user = $this->get('security.context')->getToken()->getUser();
      $ship = $user->getShip();
      $ship_id = $ship->getId();
      //On récupère la liste des steps.
      $query_builder = $em->createQueryBuilder();
     $query = $em->createQuery(
     'SELECT st FROM IaatoIaatoBundle:Step st 
     INNER JOIN IaatoIaatoBundle:TimeSlot ts with st.timeslot = ts.id
     INNER JOIN IaatoIaatoBundle:TimeSlotLabel tsl with ts.label = tsl.id
     WHERE st.ship = '.$ship_id.'
     ORDER BY ts.date ASC, tsl.id ASC
     '
     );

      $list_step = $query->getResult();
      return $this->render('IaatoIaatoBundle:Step:show.html.twig',array(
	'ship'=>$ship,
	'list_step'=>$list_step,
      ));
    }
    public function addAction($param=null)
    {
      $request=$this->getRequest();
      $em = $this->getDoctrine()->getEntityManager();
      $form_day = $this->createFormBuilder();
      $form_day
	->add('date', 'date',array(
	  'widget' => 'single_text',
	  'input' => 'datetime',
	  'format' => 'dd/MM/yyyy',
	  'attr' => array('class' => 'date'),
	  'empty_data' => false,
	  'empty_value' => 'Choose a date',
	  ));
	  
      $form_day = $form_day->getForm();
      if($request->getMethod()=='POST')
      {
	$form_day->bind($request);
	if($form_day->isValid())
	{
	  return $this->add2Action($form_day["year"]->getData(),$form_day["month"]->getData(),$param);
	}
      }
      return $this->render('IaatoIaatoBundle:Step:add.html.twig',array(
      'form' => $form_day->createView(),
      ));
    }
    public function add2Action($y,$m,$param=null)
    {
      $form;
      $em = $this->getDoctrine()->getManager();
      $request = $this->get('request');
      $repo_tsl = $em->getRepository('IaatoIaatoBundle:TimeSlot');
      $form_day = $this->createFormBuilder();
      $form_site = $this->createFormBuilder();
      $date = date($y,$m);
      $array_days = array();
      $mois = mktime( 0, 0, 0, $m, 1, $y );
      $tsl = new EntityChoiceList($em,'Iaato\IaatoBundle\Entity\TimeSlotLabel');
      for($i=1;$i <= intval(date("t",$mois)) ;$i++)
      {
	$array_days[$i] = $i;
      }
      $form_day
      ->add('day','choice',array(
      "choices"=>$array_days,
      "required"=>"true",));
      $form_day->add('timeslot','choice',array(
	'choice_list' => $tsl,
	'required' => true,
	'label'=>'Time Slot'))
	;
      $qb = $em->createQueryBuilder();
      $qb->add('select', 'u')->add('from', 'Iaato\IaatoBundle\Entity\Site u')->orderBy('u.nameSite');
      $site = new EntityChoiceList($em,'Iaato\IaatoBundle\Entity\Site');
      $form_site->add('site','entity',array(
	'class' => 'Iaato\IaatoBundle\Entity\Site',
	'query_builder' => $qb,
	'required' => true,
	'label'=>'Site'))
	;
      $msg;
      $form_day = $form_day->getForm();
      $form_site = $form_site->getForm();
      if($request->getMethod() == 'POST')
      {
	$form_day->bind($request);
	
	$msg= $form_day['day']->getData();
	
	  if($form_site['site']->getData() != '')
	    return $this->addBySiteAction($y,$m,$form_site["site"]->getData());
	    
	  if($form_day['day']->getData() != '')
	    return $this->addByDayAction($y,$m,$form_day["day"]->getData(),$form_day["timeslot"]->getData());
      }
      if($param == 'day')
	$form = $form_day;
      else 
	$form = $form_site;
	
      return $this->render('IaatoIaatoBundle:Step:add2.html.twig',array(
      'form'=>$form->createView(),
      'param'=>$param,
      'y'=>$y,
      'm'=>$m,
      ));
    }
    public function removeAction()
    {
      $em = $this->getDoctrine()->getEntityManager();
      return $this->render('IaatoIaatoBundle:Step:remove.html.twig');
    }
    public function addByDayAction($y,$m,$d,$tsl)
    {
      $jour = $y."-".$m."-".$d." : ".$tsl;
      $date_time = new \DateTime(''.$y.'-'.$m.'-'.$d.'');
      $request = $this->getRequest();
      
      $ship = $this->get('security.context')->getToken()->getUser()->getShip();
      $em = $this->getDoctrine()->getManager();
      $repo_site = $em->getRepository('IaatoIaatoBundle:Site');
      $repo_step = $em->getRepository('IaatoIaatoBundle:Step');
      $repo_timeslot = $em->getRepository('IaatoIaatoBundle:TimeSlot');
      $repo_date = $em->getRepository('IaatoIaatoBundle:Date');
      
      
      $date = $repo_date->findOneBy(array('date'=>$date_time));
      $timeslot = $repo_timeslot->findOneBy(array('date'=>$date,'label'=>$tsl));
      //$site_booked = $repo_step->findOneBy(array('timeslot'=>$timeslot,'ship'=>$ship))->getSite();
      $site_booked ="ok";
      $array_step = $repo_step->findBy(array('timeslot'=>$timeslot));
      $array_site_full = $repo_site->findAll();
      $array_site = array();

      foreach($array_site_full as $site)
      {
	$in = false;
	foreach($array_step as $step)
	  if($site === $step->getSite())
	    $in = true;
	
	if(!$in)
	  array_push($array_site,$site);
      }
	
      $form = $this->createFormBuilder();
      $form->add('site','choice',array(
	'choices'=>$array_site,
	));
      $form = $form->getForm();
	if($request->getMethod() == 'POST')
	{
	  if($form['site']->getData() != null)
	  {
	    //On vérifie que le site est bien libre au cas ou 
	    if($repo_step->findBy(array('timeslot'=>$timeslot,'site'=>$form["site"]->getData())) == null)
	    {
	      $step = new Step();
	      $step->setShip();
	      $step->setTimeSlot();
	      $step->setSite();
	      $em->pesist();
	      $em->flush();
	      
	      return $this->render('IaatoIaatoBundle:Step:succesAdd.html.twig',array(
		'day'=>$jour,
		'site'=>$site,
		));
	    }
	  }
	}
      return $this->render('IaatoIaatoBundle:Step:addByDay.html.twig',array(
	"form"=>$form->createView(),
	'day'=>$jour,
	'site'=>$site_booked,
	));
    }
    public function addBySiteAction($y,$m,$site)
    {
      return $this->render('IaatoIaatoBundle:Step:addBySite.html.twig',array(
	"form"=>$form->createView(),
	));
    }
}
