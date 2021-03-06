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

class HomeController extends Controller
{
  public function indexAction()
  {
    $em = $this->getDoctrine()->getManager();
    $datetime = new \Datetime();
    $datetime->setTime(0,0);
        
    $repo_step = $em->getRepository('IaatoIaatoBundle:Step');
    $repo_date = $em->getRepository('IaatoIaatoBundle:Date');
    $repo_ts = $em->getRepository('IaatoIaatoBundle:TimeSlot');
    
    $date = $repo_date->findOneBy(array('date'=>$datetime));
    $timeslot = $repo_ts->findBy(array('date'=>$date));
    if($date != null)
      $array_step = $repo_step->findBy(array('timeslot'=>$timeslot));
    else
      $array_step = array();
    return $this->render('IaatoIaatoBundle:Home:index.html.twig',array(
      'array_ship' => $array_step,
      'date' => $date,
      ));
  } 
}
?>

