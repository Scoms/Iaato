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
                        //return $this->forward('IaatoIaatoBundle:CSVUp:step', array('data' => $data));
                        break;
                    case "sites":
                        //return $this->forward('IaatoIaatoBundle:CSVUp:site', array('data' => $data));
                        break;
                    case "types":
                        return $this->forward('IaatoIaatoBundle:CSVUp:type', array('data' => $data));
                        break;
                    case "zones":
                        //return $this->forward('IaatoIaatoBundle:CSVUp:zone', array('data' => $data));
                        break;
                    case "subZones":
                        //return $this->forward('IaatoIaatoBundle:CSVUp:subzone', array('data' => $data));
                        break;
                    default:
                        break;
                }
			}
		}
		return $this->render('IaatoIaatoBundle:CSV:upload.html.twig', array('form' => $form->createView()));
        
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
        $ship = new Ship();
        $ship->setNameShip($lin[0]);
        $ship->setCode($lin[3]);
        $ship->setNbPassenger($lin[6]);
        
        if($em->getRepository("IaatoIaatoBundle:Society")->findOneBy(array('labelSociety' => $lin[1]))!=NULL){
            if($em->getRepository("IaatoIaatoBundle:Type")->findOneBy(array('labelType' => $lin[2]))!=NULL){
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
    fclose($handle);
	return $this->render('IaatoIaatoBundle:CSV:show.html.twig', array('cpt_done' => $cpt_done, 'cpt_total' => $cpt_total,'name' => "ships", 'error' => $errors));
  }
  
  // Ok
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
  
  // Ok
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
                if($em->getRepository("IaatoIaatoBundle:TimeSlotLabel")->findOneBy(array('tslabel' => $lin[2]))!= NULL){
                
                    $ship = $em->getRepository("IaatoIaatoBundle:Ship")->findOneBy(array('nameShip' => $lin[0]));
                    $step->setShip($ship);
                    
                    $site = $em->getRepository("IaatoIaatoBundle:Site")->findOneBy(array('nameSite' => $lin[1]));
                    $step->setSite($site);
                    
                    $tsl = $em->getRepository("IaatoIaatoBundle:TimeSlotLabel")->findOneBy(array('tslabel' => $lin[2]));
                    
                    // Besoin d'avoir la table tomeSlot remplie...
                    $timeSlot = $em->getRepository("IaatoIaatoBundle:TimeSlot")->findOneBy(array('label' => $tsl));
                    $step->setTimeslot($timeSlot);
                    $cpt++;
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
        
        if($em->getRepository("IaatoIaatoBundle:Society")->findOneBy(array('labelSociety' => $lin[0]))==NULL){
            $site = new Site();
            $soc->setLabelSociety($lin[0]);
            $em->persist($soc);
            $em->flush();
            $cpt_done++;
        }
        else{
            $line_num = $cpt_total+1;
            array_push($errors,"Line " . $line_num . " :  this site already exist...");
        }
    }
    
    fclose($handle);
	return $this->render('IaatoIaatoBundle:CSV:show.html.twig', array('cpt_done' => $cpt_done, 'cpt_total' => $cpt_total, 'name' => "sites", 'error' => $errors));
  }
  
  // A tester
  public function typeAction($data)
  {
    $handle = fopen($data, "r");
    $cpt_done = 0;
    $cpt_total = 0;
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
    }
    
    fclose($handle);
	return $this->render('IaatoIaatoBundle:CSV:show.html.twig', array('cpt_done' => $cpt_done, 'cpt_total' => $cpt_total, 'name' => "types"));
  }
  
  public function zoneAction($data)
  {
    $handle = fopen($data, "r");
    $cpt_done = 0;
    $cpt_total = 0;
    $lin = fgetcsv($handle,1000,";"); // Pour sauter la première ligne 
    
    while(($lin = fgetcsv($handle,1000,";")) !== FALSE){
        $cpt_total++;
        $em = $this->getDoctrine()->getEntityManager();
        
        if($em->getRepository("IaatoIaatoBundle:Zone")->findOneBy(array('labelZone' => $lin[0]))==NULL){
            $zone = new Zone();
            $zone->setLabelZone($lin[0]);
            $em->persist($zone);
            $em->flush();
            $cpt_done++;
        }
    }
    
    fclose($handle);
	return $this->render('IaatoIaatoBundle:CSV:show.html.twig', array('cpt_done' => $cpt_done, 'cpt_total' => $cpt_total, 'name' => "zones"));
  }
  
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
  
}

?>
