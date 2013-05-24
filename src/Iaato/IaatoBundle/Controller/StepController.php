<?php

// StepController.php

namespace Iaato\IaatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Bridge\Doctrine\Form\ChoiceList\EntityChoiceList;
use Iaato\IaatoBundle\Entity\Step;
use Iaato\IaatoBundle\Entity\Date;
use Iaato\IaatoBundle\Entity\TimeSlot;
use Symfony\Component\HttpFoundation\Response;

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
    public function addAction()
    {
      $request=$this->get('request');
      $em = $this->getDoctrine()->getEntityManager();
      
      $repo_tsl = $em->getRepository('IaatoIaatoBundle:TimeSlotLabel');
      $repo_site = $em->getRepository('IaatoIaatoBundle:Site');
      
      $array_site = $repo_site->findAll();
      $array_tsl = $repo_tsl->findAll();
      
      $y = date('Y');
      $array_year = array();
	array_push($array_year,$y);
      for($i=0;$i<3;$i++)
      {
	$y++;
	array_push($array_year,$y);
      }
      
      $array_months = array('January','February','March','April','May','June','July','August','September','October','November','December');
      
      $form_site = $this->createFormBuilder();
      $form_site
	->add('site','entity',array(
	  'choices'=>$array_site,
	  'class'=>'IaatoIaatoBundle:Site',
	));
	
      $form_day = $this->createFormBuilder();
      $form_day
	->add('date', 'datetime',array(
	  'widget' => 'single_text',
	  'input' => 'datetime',
	  'format' => 'MM/dd/yyyy',
	  'attr' => array('class' => 'date'),
	  'empty_data' => false,
	  'label'=>'Date',
	  ))
	 ->add('tsl','entity',array(
	  'choices'=>$array_tsl,
	  'label'=>'Time Slot',
	  'class'=>'IaatoIaatoBundle:TimeSlotLabel',
	  ));
	  
      $form_day = $form_day->getForm();
      $form_site = $form_site->getForm();
      
      $date = $form_day['date']->getData();
      if($request->getMethod()=='POST')
      {
	//$form_day->bind($request);
	$form_site->bind($request);
	if($form_site->isValid())
	{
	  $site = $form_site['site']->getData();
	    return $this->redirect($this->generateUrl('iaato_step_add_by_site',array('site'=>$site->getNameSite())));
	}
	$form_day->bind($request);
	if($form_day->isValid())
	{
	  $date = $form_day['date']->getData();
	  $tsl= $form_day['tsl']->getData();
	    return $this->redirect($this->generateUrl('iaato_step_add_by_day',array('date'=>$date->format('Y-m-d'),'tsl'=>$tsl->getLabel())));
	} 
      }
      return $this->render('IaatoIaatoBundle:Step:add.html.twig',array(
      'form_day' => $form_day->createView(),
      'form_site'=>$form_site->createView(),
      'msg' => $date,
      ));
    }
    public function removeAction()
    {
      $em = $this->getDoctrine()->getEntityManager();
      $request = $this->get('request');
      $user = $this->get('security.context')->getToken()->getUser();
      $ship = $user->getShip();
  
      $repo_ts = $em->getRepository('IaatoIaatoBundle:TimeSlot');
      $repo_tsl = $em->getRepository('IaatoIaatoBundle:TimeSlotLabel');
      $repo_step = $em->getRepository('IaatoIaatoBundle:Step');
      $repo_site = $em->getRepository('IaatoIaatoBundle:Site');
      $repo_date = $em->getRepository('IaatoIaatoBundle:Date');
      
      $array_tsl = $repo_tsl->findAll();
      
      $form_day = $this->createFormBuilder();
      $form_day
	->add('date', 'datetime',array(
	  'widget' => 'single_text',
	  'input' => 'datetime',
	  'format' => 'MM/dd/yyyy',
	  'attr' => array('class' => 'date'),
	  'empty_data' => false,
	  'label'=>'Date',
	  ))
	 ->add('tsl','entity',array(
	  'choices'=>$array_tsl,
	  'label'=>'Time Slot',
	  'class'=>'IaatoIaatoBundle:TimeSlotLabel',
	  ));

      $form_day = $form_day->getForm();
      
      if($request->getMethod() == 'POST')
      {
	$form_day->bind($request);
	if($form_day->isValid())
	{
	  $array_date = explode('-',$form_day['date']->getData()->format('Y-m-d'));
	  $tsl = $form_day['tsl']->getData();
	  $datetime = new \DateTime();
	  $datetime->setDate($array_date[0],$array_date[1],$array_date[2]);
	  $datetime->setTime(0,0);
	  $date = $repo_date->findOneBy(array('date'=>$datetime));
	  $timeslot = $repo_ts->findOneBy(array('date'=>$date,'label'=>$tsl));
	  $step = $repo_step->findOneBy(array('ship'=>$ship,'timeslot'=>$timeslot));
	  if($step != null)
	  {
	      $site = $step->getSite();
	      $em->remove($step);
	      $em->flush();
	      return $this->render('IaatoIaatoBundle:Step:remove.html.twig',array(
	      'form'=>$form_day->createView(),
	      'msg'=>'The .'.$site.' on '.$timeslot.' is now free',
	  ));
	  }
	      return $this->render('IaatoIaatoBundle:Step:remove.html.twig',array(
	      'form'=>$form_day->createView(),
	      'msg'=>'No bookind this day : '.$timeslot,
	  ));
	}
      }
      
      return $this->render('IaatoIaatoBundle:Step:remove.html.twig',array(
      'form'=>$form_day->createView(),
      'msg'=>''
      ));
    }
    public function addByDayAction($date,$tsl)
    {
      $em = $this->getDoctrine()->getEntityManager();
      $request = $this->getRequest();
      $user = $this->get('security.context')->getToken()->getUser();
      $ship = $user->getShip();
      $msg = null;
     
      $array_date = explode('-',$date);
      
      $repo_site = $em->getRepository('IaatoIaatoBundle:Site');
      $repo_step = $em->getRepository('IaatoIaatoBundle:Step');
      $repo_date = $em->getRepository('IaatoIaatoBundle:Date');
      $repo_ts = $em->getRepository('IaatoIaatoBundle:TimeSlot');
      $repo_tsl = $em->getRepository('IaatoIaatoBundle:TimeSlotLabel');
      
      $datetime = new \DateTime();
      $datetime->setDate($array_date[0],$array_date[1],$array_date[2]);
      $datetime->setTime(0,0);
      $date = $repo_date->findOneBy(array('date'=>$datetime));
      $tsl = $repo_tsl->findOneBy(array('label'=>$tsl));
      $timeslot = $repo_ts->findOneBy(array('date'=>$date,'label'=>$tsl));
      $site_booked = $repo_step->findOneBy(array('timeslot'=>$timeslot));
      if($site_booked != null)
	$site_booked = $site_booked->getSite();
            
      $array_site_full = $repo_site->findAll();
      $array_step = $repo_step->findBy(array('timeslot'=>$timeslot));
      $array_site = array();
     
      $this->createTSandDate($timeslot,$date,$datetime,$tsl,$em);
      $sites_booked = $this->getBookedSitesAction($date,$ship,$timeslot);
      
      
      
      foreach($array_site_full as $site)
      {
	$bool = true;
	foreach($array_step as $step)
	  if($site == $step->getSite())
	    $bool = false;
	if($bool)
	{
	  foreach($sites_booked as $siteb)
	  {
	    if($site === $siteb)
	      $bool = false;
	  }
	}
	if($bool && $site->getIaato())
	  array_push($array_site,$site);
      }
      
      
      $form = $this->createFormBuilder();
      $form->add('site','entity',array(
	  'label'=>'Site',
	  'choices'=>$array_site,
	  'class'=>'IaatoIaatoBundle:Site'
	));
      $form = $form->getForm();
      
      if($request->getMethod() == 'POST')
      {
	$form->bind($request);
	if($form->isValid())
	{
	  if($site_booked == null)
	  {	    
	    $step = new Step();
	    $step->setTimeSlot($timeslot);
	    $step->setShip($ship);
	    $site = $form['site']->getData();
	    $step->setSite($site);
	    $em->persist($step);
	    $em->flush();
	    $msg = "Step added succesfully.";
	  }
	  else
	  {
	    //On vérfie une dernière fois que le site est libre 
	    $step = $repo_step->findOneBy(array('ship'=>$ship,'timeslot'=>$timeslot));
	    $site = $form['site']->getData();
	    $test = $repo_step->findOneBy(array('site'=>$site,'timeslot'=>$timeslot));
	    //C'est bon 
	    if($test == null)
	    {
	      $step->setSite($site);
	      $em->persist($step);
	      $em->flush();
	      $msg = "Step changed succesfully.".$form['site']->getData();
	    }
	    else
	    {
	      $msg = 'TRY AGAIN PLEASE.';
	    }	
	  }
	}
      }
      return $this->render('IaatoIaatoBundle:Step:addByDay.html.twig',array(
	'form'=>$form->createView(),
	'site'=>$site_booked,
	'date'=>$date,
	'msg'=>$msg,
	'tsl'=>$tsl,
      ));
    }
    public function getBookedSitesAction($date,$ship,$timeslot)
    {
      $site_before = null;
      $site_after = null;
      $em = $this->getDoctrine()->getManager();
      $array_res = array();
      $repo_tsl = $em->getRepository('IaatoIaatoBundle:TimeSlotLabel');
      
      $tsl_early_morning = $repo_tsl->findOneBy(array('label'=>'early morning'));
      $tsl_morning= $repo_tsl->findOneBy(array('label'=>'morning'));;
      $tsl_afternoon= $repo_tsl->findOneBy(array('label'=>'afternoon'));;
      $tsl_evening= $repo_tsl->findOneBy(array('label'=>'evening'));;
      $tsl_overnigt= $repo_tsl->findOneBy(array('label'=>'overnight'));;
      
      $repo_step = $em->getRepository('IaatoIaatoBundle:Step');
      $repo_ts = $em->getRepository('IaatoIaatoBundle:TimeSlot');
      
      switch ($timeslot->getLabelTimeSlot()){
	case 'early morning' :
	  $timeslot_temp = $repo_ts->findOneBy(array('date'=>$date,'label'=>$tsl_morning));
	  $site_after = $repo_step->findOneBy(array('timeslot'=>$timeslot_temp,'ship'=>$ship));
	  if($site_after != null)
	    $site_after = $site_after->getSite();
	  break;
	case 'morning' :
	  $timeslot_temp = $repo_ts->findOneBy(array('date'=>$date,'label'=>$tsl_early_morning));
	  $site_before = $repo_step->findOneBy(array('timeslot'=>$timeslot_temp,'ship'=>$ship));
	  $timeslot_temp = $repo_ts->findOneBy(array('date'=>$date,'label'=>$tsl_afternoon));
	  $site_after = $repo_step->findOneBy(array('timeslot'=>$timeslot_temp,'ship'=>$ship));
	  if($site_after !== null)
	    $site_after = $site_after->getSite();
	  if($site_before !== null)
	    $site_before = $site_before->getSite();
	  break;
	case 'afternoon' :
	  $timeslot_temp = $repo_ts->findOneBy(array('date'=>$date,'label'=>$tsl_morning));
	  $site_before = $repo_step->findOneBy(array('timeslot'=>$timeslot_temp,'ship'=>$ship));
	  $timeslot_temp = $repo_ts->findOneBy(array('date'=>$date,'label'=>$tsl_evening));
	  $site_after = $repo_step->findOneBy(array('timeslot'=>$timeslot_temp,'ship'=>$ship));
	  if($site_after != null)
	    $site_after = $site_after->getSite();
	  if($site_before != null)
	    $site_before = $site_before->getSite();
	  break;
	case 'evening' :
	  $timeslot_temp = $repo_ts->findOneBy(array('date'=>$date,'label'=>'afternoon'));
	  $site_before = $repo_step->findOneBy(array('timeslot'=>$timeslot_temp,'ship'=>$ship));
	  if($site_before != null)
	    $site_before = $site_before->getSite();
	  break;
	case 'overnight' :
	// rien à faire 
	  break;
	defaults :
	  break;
	  }
      array_push($array_res,$site_after);
      array_push($array_res,$site_before);
      return $array_res;
    }
    
    public function createTSandDate(&$timeslot,$date,$datetime,$tsl,$em) 
    {
      if($timeslot == null)
      {
	if($date == null)
	{
	  $date = new Date();
	  $date->setDate($datetime);
	  $em->persist($date);
	  $em->flush();
	}
	$timeslot = new TimeSlot();
	$timeslot->setDate($date);
	$timeslot->setLabelTimeSlot($tsl);
	$em->persist($timeslot);
	$em->flush();
      }
    }
    
    public function addBySiteAction($site)
    {
      $em = $this->getDoctrine()->getManager();
      
      $repo_step = $em->getRepository('IaatoIaatoBundle:Step');
      $repo_site = $em->getRepository('IaatoIaatoBundle:Site');
      
      $array_step = $repo_step->findBy(array());
      
      $site = $repo_site->findOneBy(array('nameSite'=>$site));
      $array_disponibility = $repo_step->findBy(array('site'=>$site));
      
      return $this->render('IaatoIaatoBundle:Step:addBySite.html.twig',array(
	'site'=>$site,
	'disponibilities'=>$array_disponibility,
      ));
    }
}
