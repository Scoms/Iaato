<?php

// StepController.php

namespace Iaato\IaatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Bridge\Doctrine\Form\ChoiceList\EntityChoiceList;

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
      $years = array();
      $months = array();
      $y = date("Y");
      for($i=0;$i<5;$i++)
	$years[$y+$i] = $y+$i;
      
      for($i=1;$i<=12;$i++)
	$months[$i] = $i;
      
      $form = $this->createFormBuilder();
      $form
	->add('year','choice',array(
	"choices"=>$years,
	"required"=>"true",))
	->add('month','choice',array(
	"choices"=>$months,
	"required"=>"true",
	));
      $form = $form->getForm();
      if($request->getMethod()=='POST')
      {
	$form->bind($request);
	if($form->isValid())
	{
	  return $this->add2Action($form["year"]->getData(),$form["month"]->getData(),$param);
	}
      }
      return $this->render('IaatoIaatoBundle:Step:add.html.twig',array(
      'form' => $form->createView(),
      ));
    }
    public function add2Action($y,$m,$param=null)
    {
      
      $em = $this->getDoctrine()->getManager();
      $request = $this->get('request');
      $repo_tsl = $em->getRepository('IaatoIaatoBundle:TimeSlot');
      $form = $this->createFormBuilder();
      if($param == 'day')
      {
	$date = date($y,$m);
	$array_days = array();
	$mois = mktime( 0, 0, 0, $m, 1, $y );
	$tsl = new EntityChoiceList($em,'Iaato\IaatoBundle\Entity\TimeSlotLabel');
	for($i=1;$i <= intval(date("t",$mois)) ;$i++)
	{
	  $array_days[$i] = $i;
	}
	$form
	->add('day','choice',array(
	"choices"=>$array_days,
	"required"=>"true",));
	$form->add('timeslot','choice',array(
	  'choice_list' => $tsl,
	  'required' => true,
	  'label'=>'Time Slot'))
	  ;
      }
      else if($param == 'site' )
      {
	$qb = $em->createQueryBuilder();
	$qb->add('select', 'u')->add('from', 'Iaato\IaatoBundle\Entity\Site u')->orderBy('u.nameSite');
	$site = new EntityChoiceList($em,'Iaato\IaatoBundle\Entity\Site');
	$form->add('site','entity',array(
	  'class' => 'Iaato\IaatoBundle\Entity\Site',
	  'query_builder' => $qb,
	  'required' => true,
	  'label'=>'Site'))
	  ;
      }
      
      $form = $form->getForm();
      if($request->getMethod() == 'POST')
      {
	$form->bind($request);
	if($form->isValid())
	{
	  if($param == 'day')
	  {
	    return $this->addByDayAction($y,$m,$form["day"]->getData(),$form["timeslot"]->getData());
	  }
	  if($param == 'site' )
	  {
	    return $this->addBySiteAction($y,$m,$form["site"]->getData());
	  }
	}
      }
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
      
      $em = $this->getDoctrine()->getManager();
      $repo_site = $em->getRepository('IaatoIaatoBundle:Site');
      $repo_step = $em->getRepository('IaatoIaatoBundle:Step');
      $repo_timeslot = $em->getRepository('IaatoIaatoBundle:TimeSlot');
      $repo_date = $em->getRepository('IaatoIaatoBundle:Date');
      
      $date = $repo_date->findOneBy(array('date'=>$date_time));
      $timeslot = $repo_timeslot->findOneBy(array('date'=>$date,'label'=>$tsl));
      $array_step = $repo_step->findBy(array('timeslot'=>$timeslot));
      $array_site_full = $repo_site->findAll();
      $array_site = array();
      /*
      foreach($array_site_full as $site)
      {
	$in = false;
	foreach($array_step as $step )
	{
	  if($site == $step->getSite())
	  {
	    $in = true;
	  }
	}
	if($in == false)
	  array_push($array_site,$site);
      }*/
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
      return $this->render('IaatoIaatoBundle:Step:addByDay.html.twig',array(
	"form"=>$form->createView(),
	'day'=>$jour,
	));
    }
    public function addBySiteAction($y,$m,$site)
    {
      return $this->render('IaatoIaatoBundle:Step:addBySite.html.twig',array(
	"form"=>$form->createView(),
	));
    }
}
