<?php

namespace Iaato\IaatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Iaato\IaatoBundle\Entity\Society;
use Iaato\IaatoBundle\Entity\Activity;
use Iaato\IaatoBundle\Entity\Ship;
use Iaato\IaatoBundle\Entity\Email;
use Iaato\IaatoBundle\Entity\Phone;
use Iaato\IaatoBundle\Entity\Type;
use Iaato\IaatoBundle\Entity\Step;
use Iaato\IaatoBundle\Entity\Site;
use Iaato\IaatoBundle\Entity\SubZone;
use Iaato\IaatoBundle\Entity\Zone;
use Iaato\IaatoBundle\Entity\TimeSlot;
use Iaato\IaatoBundle\Entity\TimeSlotLabel;
use Iaato\IaatoBundle\Entity\Date;
use Symfony\Component\Security\Core\SecurityContext;

class CSVUpController extends Controller
{
  
  public function indexAction()
  {
      
	  $form = $this->createFormBuilder()
		->add('file', 'file')
		->getForm();

		$request = $this->get('request');

		// Check if we are posting stuff
		if ($request->getMethod() == 'POST') {
			
			$form->bind($request);
			
			if ($form->isValid()) {
                
				$file = $form->get('file');
                $data = $file->getData();
                
                $filename = $data->getClientOriginalName();
                $name = explode(".", $filename);
                switch($name[0]){
                    case "ships":
                        return $this->forward('IaatoIaatoBundle:CSVUp:ship', array('data' => $data));
                        break;
                    case "societies":
                        return $this->forward('IaatoIaatoBundle:CSVUp:society', array('data' => $data));
                        break;
                    case "activities":
                        return $this->forward('IaatoIaatoBundle:CSVUp:activity', array('data' => $data));
                        break;
                    case "steps":
                        return $this->forward('IaatoIaatoBundle:CSVUp:step', array('data' => $data));
                        break;
                    case "sites":
                        return $this->forward('IaatoIaatoBundle:CSVUp:site', array('data' => $data));
                        break;
                    case "types":
                        return $this->forward('IaatoIaatoBundle:CSVUp:type', array('data' => $data));
                        break;
                    case "zones":
                        return $this->forward('IaatoIaatoBundle:CSVUp:zone', array('data' => $data));
                        break;
                    default:
			return $this->forward('IaatoIaatoBundle:CSVUp:step2', array('filename'=>$filename ,'data' => $data));
                        break;
                }
			}
		}
		return $this->render('IaatoIaatoBundle:CSV:upload.html.twig', array('form' => $form->createView()));
        
  }
  public function indexElAction()
  {
      
	  $form = $this->createFormBuilder()
		->add('file', 'file')
		->getForm();

		$request = $this->get('request');

		// Check if we are posting stuff
		if ($request->getMethod() == 'POST') {
			
			$form->bind($request);
			
			if ($form->isValid()) {
                
				$file = $form->get('file');
                $data = $file->getData();
                
                $filename = $data->getClientOriginalName();
                $name = explode(".", $filename);
                switch($name[0]){
                    case "ships":
                        return $this->forward('IaatoIaatoBundle:CSVUp:ship', array('data' => $data));
                        break;
                    case "societies":
                        return $this->forward('IaatoIaatoBundle:CSVUp:society', array('data' => $data));
                        break;
                    case "activities":
                        return $this->forward('IaatoIaatoBundle:CSVUp:activity', array('data' => $data));
                        break;
                    case "steps":
                        return $this->forward('IaatoIaatoBundle:CSVUp:step', array('data' => $data));
                        break;
                    case "sites":
                        return $this->forward('IaatoIaatoBundle:CSVUp:site', array('data' => $data));
                        break;
                    case "types":
                        return $this->forward('IaatoIaatoBundle:CSVUp:type', array('data' => $data));
                        break;
                    case "zones":
                        return $this->forward('IaatoIaatoBundle:CSVUp:zone', array('data' => $data));
                        break;
                    default:
			return $this->forward('IaatoIaatoBundle:CSVUp:step2', array('filename'=>$filename ,'data' => $data));
                        break;
                }
			}
		}
		return $this->render('IaatoIaatoBundle:CSV:upload_el.html.twig', array('form' => $form->createView()));
        
  }
  
  // Ok
  public function shipAction($data)
  {
    $handle = fopen($data, "r");
    $errors = array();
    $cpt_done = 0;
    $cpt_total = 0;
    $lin = fgetcsv($handle,1000,";");
    while(($lin = fgetcsv($handle,1000,";")) !== FALSE){
        $cpt_total++;
        $em = $this->getDoctrine()->getEntityManager();
        
        if($em->getRepository("IaatoIaatoBundle:Ship")->findOneBy(array('nameShip' => $lin[0]))==NULL){
            if($em->getRepository("IaatoIaatoBundle:Society")->findOneBy(array('labelSociety' => $lin[1]))!=NULL){
                if($em->getRepository("IaatoIaatoBundle:Type")->findOneBy(array('labelType' => $lin[2]))!=NULL){
                    
                    $ship = new Ship();
                    $ship->setNameShip($lin[0]);
                    $ship->setCode($lin[3]);
                    $ship->setNbPassenger($lin[6]);
                    
                    if($em->getRepository("IaatoIaatoBundle:Email")->findOneBy(array('email' => $lin[4]))==NULL){
                        $email = new Email();
                        $email->setEmail($lin[4]);
                        $email->setShip($ship);
                        $em->persist($email);
                    }
                    else{
                        $email = $em->getRepository("IaatoIaatoBundle:Email")->findOneBy(array('email' => $lin[4]));
                    }
                    if($em->getRepository("IaatoIaatoBundle:Phone")->findOneBy(array('numberPhone' => $lin[5]))==NULL){
                        $phone = new Phone();
                        $phone->setNumberPhone($lin[4]);
                        $phone->setShip($ship);
                        $em->persist($phone);
                    }
                    else{
                        $phone = $em->getRepository("IaatoIaatoBundle:Phone")->findOneBy(array('numberPhone' => $lin[5]));
                    }
                    
                    $society = $em->getRepository("IaatoIaatoBundle:Society")->findOneBy(array('labelSociety' => $lin[1]));
                    $ship->setSociety($society);
                
                    $type = $em->getRepository("IaatoIaatoBundle:Type")->findOneBy(array('labelType' => $lin[2]));
                    $ship->setType($type);
                    
                    $ship->addEmail($email);
                    $ship->addPhone($phone);
                    
                    
                    $cpt_done++;
                    $em->persist($ship);
                    $em->flush();
                    
                }
                else{
                    // Le type de bateau n'existe pas...
                    $line_num = $cpt_total+1;
                    array_push($errors,"Line " . $line_num . " :  the type of ship doesn't exist...");
                }
            }
            else{
                // La société n'existe pas ...
                $line_num = $cpt_total+1;
                array_push($errors, "Line " . $line_num . " :  the society doesn't exist...");
            }
        }
        else{
            $line_num = $cpt_total+1;
            array_push($errors,"Line " . $line_num . " :  this ship already exists");
        }
    }
    fclose($handle);
	return $this->render('IaatoIaatoBundle:CSV:show.html.twig', array('cpt_done' => $cpt_done, 'cpt_total' => $cpt_total,'name' => "ships", 'error' => $errors));
  }
  
  // Ok tested
  public function societyAction($data)
  {
    $handle = fopen($data, "r");
    $cpt_done = 0;
    $cpt_total = 0;
    $errors = array();
    $lin = fgetcsv($handle,1000,";");
    
    while(($lin = fgetcsv($handle,1000,";")) !== FALSE){
        $cpt_total++;
        $em = $this->getDoctrine()->getEntityManager();
        
        if($em->getRepository("IaatoIaatoBundle:Society")->findOneBy(array('labelSociety' => $lin[0]))==NULL){
            $soc = new Society();
            $soc->setLabelSociety($lin[0]);
            $em->persist($soc);
            $cpt_done++;
            $em->flush();
        }
        else{
            $line_num = $cpt_total+1;
            array_push($errors, "Line " . $line_num . " : this society already exists.");
        }
    }
    
    fclose($handle);
	return $this->render('IaatoIaatoBundle:CSV:show.html.twig', array('cpt_done' => $cpt_done, 'cpt_total' => $cpt_total, 'name' => "societies", 'error' => $errors));
  }
  
  // Ok tested
  public function activityAction($data)
  {
    $handle = fopen($data, "r");
    $cpt_done = 0;
    $cpt_total = 0;
    $errors = array();
    $lin = fgetcsv($handle,1000,";"); // Pour sauter la première ligne 
    
    while(($lin = fgetcsv($handle,1000,";")) !== FALSE){
        $cpt_total++;
        $em = $this->getDoctrine()->getEntityManager();
        
        if($em->getRepository("IaatoIaatoBundle:Activity")->findOneBy(array('labelActivity' => $lin[0]))==NULL){
            $activity = new Activity();
            $activity->setLabelActivity($lin[0]);
            $em->persist($activity);
            $cpt_done++;
            $em->flush();
        }  
        else{
            $line_num = $cpt_total+1;
            array_push($errors, "Line " . $line_num . " : this activity already exists.");
        }      
    }
    fclose($handle);
	return $this->render('IaatoIaatoBundle:CSV:show.html.twig', array('cpt_done' => $cpt_done, 'cpt_total' => $cpt_total, 'name' => "activities", 'error' => $errors));
  }
  
  // Need TypeSlot...
  public function stepAction($data)
  {
    $handle = fopen($data, "r");
    $cpt_done = 0;
    $cpt_total = 0;
    $errors = array();
    $lin = fgetcsv($handle,1000,";"); // Pour sauter la première ligne 
    
    while(($lin = fgetcsv($handle,1000,";")) !== FALSE){
        $cpt_total++;
        $em = $this->getDoctrine()->getEntityManager();
        $step = new Step();
        
        if($em->getRepository("IaatoIaatoBundle:Ship")->findOneBy(array('nameShip' => $lin[0]))!= NULL){
            if($em->getRepository("IaatoIaatoBundle:Site")->findOneBy(array('nameSite' => $lin[1]))!= NULL){
                if($em->getRepository("IaatoIaatoBundle:TimeSlotLabel")->findOneBy(array('tslabel' => $lin[3]))!= NULL){
                
                    $ship = $em->getRepository("IaatoIaatoBundle:Ship")->findOneBy(array('nameShip' => $lin[0]));
                    $step->setShip($ship);
                    
                    $site = $em->getRepository("IaatoIaatoBundle:Site")->findOneBy(array('nameSite' => $lin[1]));
                    $step->setSite($site);
                    
                    if($em->getRepository("IaatoIaatoBundle:Date")->findOneBy(array('date' => new \DateTime($lin[2])))!= NULL){
                      $date = $em->getRepository("IaatoIaatoBundle:Date")->findOneBy(array('date' => new \DateTime($lin[2])));
                    }
                    
                    else{
                      $date = new Date();
                      $date->setDate(new \DateTime($lin[2]));
                      $em-persist($date);
                    }
                    
                    $tsl = $em->getRepository("IaatoIaatoBundle:TimeSlotLabel")->findOneBy(array('tslabel' => $lin[3]));
                    if($em->getRepository("IaatoIaatoBundle:TimeSlot")->findBy(array('date' => $date,'label' => $tsl))!= NULL){
                      $timeslot = $em->getRepository("IaatoIaatoBundle:TimeSlot")->findOneBy(array('date' => $date,'label' => $tsl));
                    }
                    else{
                      $timeslot = new TimeSlot();
                      $timeslot->setDate($date);
                      $timeslot->setLabelTimeSlot($tsl);
                      $timeslot->addStep($step);
                      $em->persist($timeslot);
                    }
                    
                    // Besoin d'avoir la table timeSlot remplie...
                    //$timeSlot = $em->getRepository("IaatoIaatoBundle:TimeSlot")->findOneBy(array('label' => $tsl));
                    $step->setTimeslot($timeslot);
                    $cpt_done++;
                    $em->persist($step);
                    $em->flush();
                }
                else{
                    /* Le time slot est pas bon */
                }   
            }
            else{
                /* Le nom de site n'existe pas */
                $line_num = $cpt_total+1;
                array_push($errors,"Line " . $line_num . " :  the site doesn't exist...");
            }
        }
        else{
            /* Le nom de ship n'existe pas */
            $line_num = $cpt_total+1;
            array_push($errors,"Line " . $line_num . " :  the name of the ship doesn't exist...");
        }
        
    }
    
    fclose($handle);
	return $this->render('IaatoIaatoBundle:CSV:show.html.twig', array('cpt_done' => $cpt_done, 'cpt_total' => $cpt_total, 'name' => "steps", 'error' => $errors));
  }
  
  public function step2Action($filename,$data)
  {
    $log = $this->get('logger');
    $manager = $this->getDoctrine()->getManager();
    $repo_site = $manager->getRepository('IaatoIaatoBundle:Site');
    $repo_date = $manager->getRepository('IaatoIaatoBundle:Date');
    $repo_ts = $manager->getRepository('IaatoIaatoBundle:TimeSlot');
    $repo_tsl = $manager->getRepository('IaatoIaatoBundle:TimeSlotLabel');
    $repo_step = $manager->getRepository('IaatoIaatoBundle:Step');
    
    $handle = fopen($data, "r");
    $cpt_done = 0;
    $cpt_total = 0;
    $errors = array();
    $lin = fgetcsv($handle,1000,";"); // Pour sauter la première ligne 
    
    $ship = $this->get('security.context')->getToken()->getUser()->getShip();
    
    $infos = explode("_",$filename);
    $m = intval($infos[3]);
    $y = intval($infos[2]);
    
    while(($lin = fgetcsv($handle,1000,";")) !== FALSE)
    {
      $datetime = new \DateTime;
      $datetime->setDate($y,$m,$cpt_total+1);
      $site_name = $lin[2];
      $site = new Site();
      $site = $repo_site->findOneBy(array("nameSite"=>$site_name));
      //On récupère le timeslot
      $date = $repo_date->findOneBy(array("date"=>$datetime));
      $timeslotlabel = $repo_tsl->findOneBy(array("label"=>$lin[1]));
      $timeslot = $repo_ts->findOneBy(array("label"=>$timeslotlabel,"date"=>$date));
      
      //On cherche si le step existe déja
      $test_step = $repo_step->findOneBy(array("timeslot"=>$timeslot,"ship"=>$ship,"site"=>$site));
      if($test_step == null)
      {
	//Pas de Step existant
	// 3 tests à faire : site, ship, date
	
	//Test sur la date
	if($date == null)
	  array_push($errors,"Line " . ($cpt_total+1) . " :  date does not exist");
	
	if($site == null)
	  array_push($errors,"Line " . ($cpt_total+1) . " :  site does not exist ($site_name)");
	
	  
	if($timeslot == null)
	{
	  
	  if($timeslotlabel == null)
	    array_push($errors,"Line " . ($cpt_total+1) . " :  timeslotlabel does not exist ($lin[1])");
	  else
	  {
	    $timeslot = new TimeSlot();
	    $timeslot->setDate($date);
	    $timeslot->setLabelTimeSlot($timeslotlabel);
	    $manager->persist($timeslot);
	    $manager->flush();
	  }
	}
	
	if($site != null && $timeslot != null)
	{
	  $step = new Step();
	  $step->setSite($site);
	  $step->setTimeslot($timeslot);
	  $step->setShip($ship);
	  $manager->persist($step);
	  $manager->flush();
	}
      }
      else
	array_push($errors,"Line " . ($cpt_total+1) . " :  the step already exists");
      $cpt_total++;
    }
    fclose($handle);
	return $this->render('IaatoIaatoBundle:CSV:show_el.html.twig', array('cpt_done' => $cpt_done, 'cpt_total' => $cpt_total, 'name' => "steps", 'error' => $errors));
  }
  // Ok tested
  public function siteAction($data)
  {
    $handle = fopen($data, "r");
    $cpt_done = 0; 
    $cpt_total = 0;
    $errors = array();
    $lin = fgetcsv($handle,1000,";"); // Pour sauter la première ligne 
    
    while(($lin = fgetcsv($handle,1000,";")) !== FALSE){
        $cpt_total++;
        $em = $this->getDoctrine()->getEntityManager();
        
        if($em->getRepository("IaatoIaatoBundle:Site")->findOneBy(array('nameSite' => $lin[0]))==NULL){
            if($em->getRepository("IaatoIaatoBundle:Zone")->findOneBy(array('labelZone' => $lin[4])) != NULL){
                
                $zone = $em->getRepository("IaatoIaatoBundle:Zone")->findOneBy(array('labelZone' => $lin[4]));
                
                $site = new Site();
                $site->setNameSite($lin[0]);
                $site->setLatitude($lin[1]);
                $site->setLongitude($lin[2]);
                
                if($lin[3] == "true")
                    $site->setIaato(TRUE);
                else
                    $site->setIaato(FALSE);
                
                $site->setZone($zone);
                $em->persist($site);
                $em->flush();
                $cpt_done++;
            }
            else{
                $line_num = $cpt_total+1;
                array_push($errors,"Line " . $line_num . " :  the zone doesn't exist...");
            }
        }
        else{
            $line_num = $cpt_total+1;
            array_push($errors,"Line " . $line_num . " :  this site already exists");
        }
    }
    
    fclose($handle);
	return $this->render('IaatoIaatoBundle:CSV:show.html.twig', array('cpt_done' => $cpt_done, 'cpt_total' => $cpt_total, 'name' => "sites", 'error' => $errors));
  }
  
  // Ok tested
  public function typeAction($data)
  {
    $handle = fopen($data, "r");
    $cpt_done = 0;
    $cpt_total = 0;
    $errors = array();
    $lin = fgetcsv($handle,1000,";"); // Pour sauter la première ligne 
    
    while(($lin = fgetcsv($handle,1000,";")) !== FALSE){
        $cpt_total++;
        $em = $this->getDoctrine()->getEntityManager();
        
        if($em->getRepository("IaatoIaatoBundle:Type")->findOneBy(array('labelType' => $lin[0]))==NULL){
            $type = new Type();
            $type->setLabelType($lin[0]);
            $em->persist($type);
            $em->flush();
            $cpt_done++;
        }
        else{
            $line_num = $cpt_total+1;
            array_push($errors,"Line " . $line_num . " :  this type already exists");
        }
    }
    
    fclose($handle);
	return $this->render('IaatoIaatoBundle:CSV:show.html.twig', array('cpt_done' => $cpt_done, 'cpt_total' => $cpt_total, 'name' => "types", 'error' => $errors));
  }
  
  // Ok -- Il serait peut-être bien de pouvoir ajouter une zone sans forçément mettre une subzone ?
  public function zoneAction($data)
  {
    $handle = fopen($data, "r");
    $cpt_done = 0;
    $cpt_total = 0;
    $errors = array();
    $lin = fgetcsv($handle,1000,";"); // Pour sauter la première ligne 
    
    while(($lin = fgetcsv($handle,1000,";")) !== FALSE){
        $cpt_total++;
        $em = $this->getDoctrine()->getEntityManager();
        
        if($em->getRepository("IaatoIaatoBundle:SubZone")->findOneBy(array('labelSubZ' => $lin[1]))==NULL){
            
            $subzone = new SubZone();
            $subzone->setLabelSubZ($lin[1]);
            
            if($em->getRepository("IaatoIaatoBundle:Zone")->findOneBy(array('labelZone' => $lin[0]))==NULL){
                $zone = new Zone();
                $zone->setLabelZone($lin[0]);
                $zone->setSubZone($subzone);
            }
            else{
                $zone = $em->getRepository("IaatoIaatoBundle:Zone")->findOneBy(array('labelZone' => $lin[0]));
            }
            
            $em->persist($subzone);
            $em->persist($zone);  
            $em->flush();
            $cpt_done++;
        }
        else{
            $line_num = $cpt_total+1;
            array_push($errors,"Line " . $line_num . " :  this subzone already exists");
        }
    }
    
    fclose($handle);
	return $this->render('IaatoIaatoBundle:CSV:show.html.twig', array('cpt_done' => $cpt_done, 'cpt_total' => $cpt_total, 'name' => "zones", 'error' => $errors));
  }
  
  /*
  public function subZoneAction($data)
  {
    $handle = fopen($data, "r");
    $cpt_done = 0;
    $cpt_total = 0;
    $lin = fgetcsv($handle,1000,";"); // Pour sauter la première ligne 
    
    while(($lin = fgetcsv($handle,1000,";")) !== FALSE){
        $cpt_total++;
        $em = $this->getDoctrine()->getEntityManager();
        
        if($em->getRepository("IaatoIaatoBundle:Zone")->findOneBy(array('labelZone' => $lin[1]))==NULL){
            if($em->getRepository("IaatoIaatoBundle:SubZone")->findOneBy(array('labelSubZ' => $lin[0]))!=NULL){
                //$zone = $em->getRepository("IaatoIaatoBundle:Zone")->findOneBy(array('labelZone' => $lin[1]));
                $subZone = new SubZone();
                $subZone->setLabelSubZ($lin[0]);
                $em->persist($subZone);
                $em->flush();
                $cpt_done++;
            }
        } 
    }
    
    fclose($handle);
	return $this->render('IaatoIaatoBundle:CSV:show.html.twig', array('cpt_done' => $cpt_done, 'cpt_total' => $cpt_total, 'name' => "subZones"));
  }
  * */
  
}

?>
