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
      //$query = $em->createQuery('SELECT s FROM IaatoIaatoBundle:Step s INNER JOIN IaatoIaatoBundle:TimeSlot ts ORDER BY ts.date');
      /*
      $em = $this->getDoctrine()->getEntityManager();
$qb = $em->createQueryBuilder()
        ->select('c.name, i.id, i.image, i.name, i.description, m.id, m.quantity, m.value, m.qty_received, m.custom_image, m.custom_name, m.custom_description, u.user1fname, u.user1lname, u.user2fname, u.user2lname')
        ->from('Categories', 'c')
        ->innerJoin('Items', 'i', 'ON', 'c.id = i.category_id')
        ->innerJoin('MemberItems', 'm', 'ON', 'i.id = m.item_id')
        ->innerJoin('User', 'u', 'ON', 'm.memberinfo_id = u.id')
        ->where('u.id = ?', $slug)
        ->orderBy('c.id', 'ASC')
        ->getQuery();

$memberItems = $qb->getResult();*/
     $query = $em->createQuery(
     'SELECT st FROM IaatoIaatoBundle:Step st 
     INNER JOIN IaatoIaatoBundle:TimeSlot ts with st.timeslot = ts.id
     WHERE st.ship = '.$ship_id.'
     ORDER BY ts.date ASC
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
}
