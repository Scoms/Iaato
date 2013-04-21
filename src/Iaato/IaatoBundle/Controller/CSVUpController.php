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
                    case "society":
                        return $this->forward('IaatoIaatoBundle:CSVUp:society', array('data' => $data));
                        break;
                    default:
                        break;
                }
			}
		}
		return $this->render('IaatoIaatoBundle:CSV:upload.html.twig', array('form' => $form->createView()));
        
  }
  
  
  
  public function shipAction($data)
  {
    $handle = fopen($data, "r");
    while(($lin = fgetcsv($handle,1000,";")) !== FALSE){
        
        $em = $this->getDoctrine()->getEntityManager();
        $ship = new Ship();
        $ship->setNameShip($lin[0]);
        $ship->setCode($lin[3]);
        $ship->setNbPassenger($lin[6]);
        
        if($em->getRepository("IaatoIaatoBundle:Society")->findOneBy(array('labelSociety' => $lin[1]))!=NULL){
            $society = $em->getRepository("IaatoIaatoBundle:Society")->findOneBy(array('labelSociety' => $lin[1]));
            $ship->setSociety($society);
        }
        
        if($em->getRepository("IaatoIaatoBundle:Type")->findOneBy(array('labelType' => $lin[2]))!=NULL){
            $type = $em->getRepository("IaatoIaatoBundle:Type")->findOneBy(array('labelType' => $lin[2]));
            $ship->setType($type);
        }
        else{
            $type = new Type();
            $type->setLabelType($lin[2]);
            $em->persist($type);
            $ship->setType($type);
        }
        
        if($em->getRepository("IaatoIaatoBundle:Email")->findOneBy(array('email' => $lin[4]))!=NULL){
            /*
             * L'email existe déjà donc il doit déjà être attribué à un autre bateau... donc PROBLEME
            */
            
        }
        else{
            $email = new Email();
            $email->setEmail($lin[4]);
            $email->setShip($ship);
            $em->persist($email);
            $ship->addEmail($email);
        }
        
        if($em->getRepository("IaatoIaatoBundle:Phone")->findOneBy(array('numberPhone' => $lin[5]))!=NULL){
            /*
             * Le phone existe déjà donc il doit déjà être attribué à un autre bateau... donc PROBLEME
            */
        
        }
        else{
            $phone = new Phone();
            $phone->setNumberPhone($lin[4]);
            $phone->setShip($ship);
            $em->persist($phone);
            $ship->addPhone($phone);
        }
            
        $em->persist($ship);
        $em->flush();
        
    }
    fclose($handle);
	return $this->render('IaatoIaatoBundle:CSV:show.html.twig');
  }
  
  public function societyAction($data)
  {
    $handle = fopen($data, "r");
    while(($lin = fgetcsv($handle,1000,";")) !== FALSE){
        
        $em = $this->getDoctrine()->getEntityManager();
        $soc = new Society();
        $ship->setNameShip($lin[0]);
        $ship->setCode($lin[3]);
        $ship->setNbPassenger($lin[6]);
        
        if($em->getRepository("IaatoIaatoBundle:Society")->findOneBy(array('labelSociety' => $lin[1]))!=NULL){
            $society = $em->getRepository("IaatoIaatoBundle:Society")->findOneBy(array('labelSociety' => $lin[1]));
            $ship->setSociety($society);
        }
        
        if($em->getRepository("IaatoIaatoBundle:Type")->findOneBy(array('labelType' => $lin[2]))!=NULL){
            $type = $em->getRepository("IaatoIaatoBundle:Type")->findOneBy(array('labelType' => $lin[2]));
            $ship->setType($type);
        }
        else{
            $type = new Type();
            $type->setLabelType($lin[2]);
            $em->persist($type);
            $ship->setType($type);
        }
        
        if($em->getRepository("IaatoIaatoBundle:Email")->findOneBy(array('email' => $lin[4]))!=NULL){
            /*
             * L'email existe déjà donc il doit déjà être attribué à un autre bateau... donc PROBLEME
            */
            
        }
        else{
            $email = new Email();
            $email->setEmail($lin[4]);
            $email->setShip($ship);
            $em->persist($email);
            $ship->addEmail($email);
        }
        
        if($em->getRepository("IaatoIaatoBundle:Phone")->findOneBy(array('numberPhone' => $lin[5]))!=NULL){
            /*
             * Le phone existe déjà donc il doit déjà être attribué à un autre bateau... donc PROBLEME
            */
        
        }
        else{
            $phone = new Phone();
            $phone->setNumberPhone($lin[4]);
            $phone->setShip($ship);
            $em->persist($phone);
            $ship->addPhone($phone);
        }
            
        $em->persist($ship);
        $em->flush();
        
    }
    fclose($handle);
	return $this->render('IaatoIaatoBundle:CSV:show.html.twig');
  }
  
}

?>
