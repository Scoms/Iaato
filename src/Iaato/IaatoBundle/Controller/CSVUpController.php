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
                        return $this->forward('IaatoIaatoBundle:CSVUp:ship', array('data' => $data , 'filename' => $filename));
                        break;
                    case "societies":
                        return $this->forward('IaatoIaatoBundle:CSVUp:society', array('data' => $data , 'filename' => $filename));
                        break;
                    case "activities":
                        return $this->forward('IaatoIaatoBundle:CSVUp:activity', array('data' => $data , 'filename' => $filename));
                        break;
                    case "steps":
                        return $this->forward('IaatoIaatoBundle:CSVUp:step', array('data' => $data , 'filename' => $filename));
                        break;
                    case "sites":
                        return $this->forward('IaatoIaatoBundle:CSVUp:site', array('data' => $data , 'filename' => $filename));
                        break;
                    case "types":
                        return $this->forward('IaatoIaatoBundle:CSVUp:type', array('data' => $data , 'filename' => $filename));
                        break;
                    case "zones":
                        return $this->forward('IaatoIaatoBundle:CSVUp:zone', array('data' => $data , 'filename' => $filename));
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
  public function shipAction($data, $filename)
  {
    $handle = fopen($data, "r");
    $p = "CSV/Save/" . $filename;
    $save = fopen($p, "a");
    
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
                    
                    // Sauvegarde des données dans un fichier csv en plus de la base de données
                    fputcsv($save, $lin, ';');
                    
                    
                    
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
    fclose($save);
	return $this->render('IaatoIaatoBundle:CSV:show.html.twig', array('cpt_done' => $cpt_done, 'cpt_total' => $cpt_total,'name' => "ships", 'error' => $errors));
  }
  
  // Ok tested
  public function societyAction($data, $filename)
  {
    $handle = fopen($data, "r");
    $p = "CSV/Save/" . $filename;
    $save = fopen($p, "a");
    
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
            
            fputcsv($save, $lin, ';');
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
  public function activityAction($data, $filename)
  {
    $handle = fopen($data, "r");
    $p = "CSV/Save/" . $filename;
    $save = fopen($p, "a");
    
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
            
            fputcsv($save, $lin, ';');
        }  
        else{
            $line_num = $cpt_total+1;
            array_push($errors, "Line " . $line_num . " : this activity already exists.");
        }      
    }
    fclose($handle);
	return $this->render('IaatoIaatoBundle:CSV:show.html.twig', array('cpt_done' => $cpt_done, 'cpt_total' => $cpt_total, 'name' => "activities", 'error' => $errors));
  }
  
  // Ok
  public function stepAction($data, $filename)
  {
    $handle = fopen($data, "r");
    $p = "CSV/Save/" . $filename;
    $save = fopen($p, "a");
    
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
                    if($em->getRepository("IaatoIaatoBundle:TimeSlot")->findOneBy(array('date' => $date,'label' => $tsl))!= NULL){
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
                    
                    fputcsv($save, $lin, ';');
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
    $i = 0;
    $cpt_done = 0;
    $cpt_total = 0;
    $lines = 1;
    $errors = array();
    $success = array();
    $lin = fgetcsv($handle,1000,";"); // Pour sauter la première ligne 
    
    $ship = $this->get('security.context')->getToken()->getUser()->getShip();
    
    $infos = explode("_",$filename);
    $m = intval($infos[3]);
    $y = intval($infos[2]);
    while(($lin = fgetcsv($handle,1000,";")) !== FALSE)
    {
      
      //Si la ligne contient des informations, sinon l'on affiche pas d'erreur
      $d = $lin[0];
      $lines++;
      $datetime = new \DateTime;
      $datetime->setDate($y,$m,$d);
      //On récupère le timeslot
      
      $site_name = $lin[2];
      $site = $repo_site->findOneBy(array("nameSite"=>$site_name));
      $date = $repo_date->findOneBy(array("date"=>$datetime));
      $timeslotlabel = $repo_tsl->findOneBy(array("label"=>$lin[1]));
      $timeslot = $repo_ts->findOneBy(array("label"=>$timeslotlabel,"date"=>$date));
      //On supprime tout ce qui se trouve au même timeslot
      if($i == 0)
      foreach($repo_ts->findBy(array('date'=>$date)) as $ts)
	foreach( $repo_step->findBy(array('timeslot'=>$ts,'ship'=>$ship)) as $old_step)
	{
	  $manager->remove($old_step);
	}
      
      $i++;
      if($i==5)
	$i=0;
      $manager->flush();
      if($lin[1] != '' &&  $lin[2] != '')
      {
	$cpt_total++;
	
	
	//On cherche si le step existe déja
	$test_step = $repo_step->findOneBy(array("timeslot"=>$timeslot,"ship"=>$ship,"site"=>$site));
	
	// Pas de step, on en crée un 
	if($test_step == null)
	{
	  //Pas de Step existant
	  // 3 tests à faire : site, ship, date
	  
	  //On vérifie si le site n'est pas déja réservé
	  $test_step2 = $repo_step->findOneBy(array("timeslot"=>$timeslot,"site"=>$site));
	  //Pas de reservation enregistré
	  if($test_step2 != null)
	    array_push($errors,"Line " . $lines . " :  the site is already booked by ($ship).");
	 
	 //Création de la reservation 
	  else
	  {
	    //Si la date n'existe pas et que les deux autre champ sont remplis on l'ajoute
	    if($date == null)
	    {
	      $date = new Date();
	      $date->setDate($datetime);
	      $manager->persist($date);
	      $manager->flush();
	    }
	    if($site == null)
	      array_push($errors,"Line " . $lines . " :  site does not exist ($site_name)");
	    
	      
	    if($timeslot == null)
	    {
	      
	      if($timeslotlabel == null)
		array_push($errors,"Line " . $lines . " :  timeslotlabel does not exist ($lin[1])");
	      else
	      {
		$timeslot = new TimeSlot();
		$timeslot->setDate($date);
		$timeslot->setLabelTimeSlot($timeslotlabel);
		$manager->persist($timeslot);
	      }
	    }
	    
	    if($site != null && $timeslot != null)
	    {
	      //Si le site est IAATO et Si il existe déjà une réservation pour ce site 
	      if($site->getIaato())
	      {
		$test_step3 = $repo_step->findOneBy(array('ship'=>$ship,'site'=>$site));
		if($test_step3!=null)
		{
		  if($test_step3->getTimeSlot()->getLabelTimeSlot() == 'overnight' || $timeslot->getLabelTimeSlot() == 'overnight')
		  {
		    $step = new Step();
		    $step->setSite($site);
		    $step->setTimeslot($timeslot);
		    $step->setShip($ship);
		    $manager->persist($step);
		    $manager->flush();
		    $cpt_done++;
		    array_push($success,"Line " . $lines . " :  step confirmed. (".$datetime->format('Y-m-d')." : ".$timeslotlabel->getLabel()." : ".$site->getNameSite()." )");
		  }
		  else
		  {
		    if($test_step3->getTimeSlot()->getDate() === $date)
		      array_push($errors,"Line " . $lines . " :  Already booked before this day : ".$test_step3->getSite()->getNameSite()." ".$test_step3->getTimeSlot()->getLabelTimeSlot()->getLabel());
		    else
		    {
		      $step = new Step();
		      $step->setSite($site);
		      $step->setTimeslot($timeslot);
		      $step->setShip($ship);
		      $manager->persist($step);
		      $manager->flush();
		      $cpt_done++;
		      array_push($success,"Line " . $lines . " :  step confirmed. (".$datetime->format('Y-m-d')." : ".$timeslotlabel->getLabel()." : ".$site->getNameSite()." )");
		    }
		  }
		}
		else
		{
		  $step = new Step();
		  $step->setSite($site);
		  $step->setTimeslot($timeslot);
		  $step->setShip($ship);
		  $manager->persist($step);
		  $manager->flush();
		  $cpt_done++;
		  array_push($success,"Line " . $lines . " :  step confirmed. (".$datetime->format('Y-m-d')." : ".$timeslotlabel->getLabel()." : ".$site->getNameSite()." )");
		}
	      }
	      else
	      {
		$step = new Step();
		$step->setSite($site);
		$step->setTimeslot($timeslot);
		$step->setShip($ship);
		$manager->persist($step);
		$manager->flush();
		$cpt_done++;
		array_push($success,"Line " . $lines . " :  step confirmed. (".$datetime->format('Y-m-d')." : ".$timeslotlabel->getLabel()." : ".$site->getNameSite()." )");
	      }
	    }
	   }
	}
	else
	{
	  array_push($success,"Line " . $lines. " :  step confirmed. (".$datetime->format('Y-m-d')." : ".$timeslotlabel->getLabel()." : ".$site->getNameSite()." )");
	  $cpt_done++;
	}
      }
    }
    fclose($handle);
	return $this->render('IaatoIaatoBundle:CSV:show_el.html.twig', array('cpt_done' => $cpt_done, 'cpt_total' => $cpt_total, 'name' => "steps", 'error' => $errors));
  }
  // Ok tested
  public function siteAction($data, $filename)
  {
    $handle = fopen($data, "r");
    $p = "CSV/Save/" . $filename;
    $save = fopen($p, "a");
    
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
                
                fputcsv($save, $lin, ';');
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
  public function typeAction($data, $filename)
  {
    $handle = fopen($data, "r");
    $p = "CSV/Save/" . $filename;
    $save = fopen($p, "a");
    
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
            
            fputcsv($save, $lin, ';');
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
  public function zoneAction($data, $filename)
  {
    $handle = fopen($data, "r");
    $p = "CSV/Save/" . $filename;
    $save = fopen($p, "a");
    
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
            
            fputcsv($save, $lin, ';');
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
