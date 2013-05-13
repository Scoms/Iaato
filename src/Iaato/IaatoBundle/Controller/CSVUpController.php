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
                        break;
                }
			}
		}
		return $this->render('IaatoIaatoBundle:CSV:upload.html.twig', array('form' => $form->createView()));
        
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
