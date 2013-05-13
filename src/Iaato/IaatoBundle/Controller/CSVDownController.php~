<?php

namespace Iaato\IaatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;

class CSVDownController extends Controller
{
  public function indexAction()
  {  
    return $this->render('IaatoIaatoBundle:CSV:download.html.twig');
  }
  
  public function downAction($file)
  {
    $path = '/opt/lampp/htdocs/Iaato/template_csv/';
    $response = new Response();
    $response->setContent(file_get_contents($path.$file));
    $response->headers->set('Content-Type', 'application/force-download'); // modification du content-type pour forcer le téléchargement (sinon le navigateur internet essaie d'afficher le document)
    $response->headers->set('Content-disposition', 'filename='. $file);

    return $response;
  }
  
  public function activityAction()
  {
    return $this->forward('IaatoIaatoBundle:CSVDown:down', array('file' => 'activities.csv'));    
  }
  
  public function siteAction()
  {
    return $this->forward('IaatoIaatoBundle:CSVDown:down', array('file' => 'sites.csv'));    
  }
  
  public function shipAction()
  {
    return $this->forward('IaatoIaatoBundle:CSVDown:down', array('file' => 'ships.csv'));    
  }
  
  public function societyAction()
  {
    return $this->forward('IaatoIaatoBundle:CSVDown:down', array('file' => 'societies.csv'));    
  }
  
  public function stepAction()
  {
    $request = $this->get('request');
    $years = array();
    $months = array();
    $y = date("Y");
    $msg = "pas de message";
        
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
    
    if($request->getMethod() == 'POST')
    {
      $form->bind($request);
      if($form->isValid())
      {
	$filename = "steps_".$form["year"]->getData()."_".$form["month"]->getData();
	if($this->rechercheCSV("ok"))
	  $msg = "téléchargement ".$filename;
	else
	  $msg = "création ".$filename;
      }
    }
    return $this->render('IaatoIaatoBundle:Step:choose.html.twig',array(
      "form"=>$form->createView(),
      "msg"=>$msg,
    ));
    //return $this->forward('IaatoIaatoBundle:CSVDown:down', array('file' => 'steps.csv'));    
  }
  
  public function subZoneAction()
  {
    return $this->forward('IaatoIaatoBundle:CSVDown:down', array('file' => 'subZones.csv'));    
  }
  
  public function typeAction()
  {
    return $this->forward('IaatoIaatoBundle:CSVDown:down', array('file' => 'types.csv'));    
  }
  
  public function zoneAction()
  {
    return $this->forward('IaatoIaatoBundle:CSVDown:down', array('file' => 'zones.csv'));    
  }
  public function rechercheCSV($name)
  {
    return false;
  }
}

?>
