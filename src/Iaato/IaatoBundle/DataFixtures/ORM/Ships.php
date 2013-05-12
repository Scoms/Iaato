<?php
// vim: set et sw=4 ts=4 sts=4 fdm=marker ff=unix fenc=utf8
/**
 * Ship.php
 *
 * @author
 * @date 2013/03/26
 * @link
 */


namespace Iaato\IaatoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Iaato\IaatoBundle\Entity\Ship;
use Iaato\IaatoBundle\Entity\Type;
use Iaato\IaatoBundle\Entity\Society;
use Iaato\IaatoBundle\Entity\Email;
use Iaato\IaatoBundle\Entity\Phone;


class Ships extends AbstractFixture implements OrderedFixtureInterface{

	/**
	 * {@inheritDoc}
	*/
	public function load(ObjectManager $manager)
	{
	  
	 $handle = fopen('web/CSV/ships.csv','r');
	  $row = 1;
	      while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
	      {
		  if($row!=1)
		  {
		    $num = count($data);
		    $ship = new Ship;
		    $ship->setNameShip($data[0]);
		    $ship->setSociety($manager->getRepository('IaatoIaatoBundle:Society')->findOneBy(array("labelSociety"=>$data[1])));
		    $ship->setType($manager->getRepository('IaatoIaatoBundle:Type')->findOneBy(array("labelType"=>$data[2])));
		    $ship->setCode($data[3]);
		    // EMAIL 
		    $email = new Email();
		    $email->setEmail($data[4]);
		    $email->setShip($ship);
		    $ship->addEmail($email);
		    
		    // PHONE
		    $phone = new Phone();
		    $phone->setNumberPhone($data[5]);
		    $ship->addPhone($phone);
		    $phone->setShip($ship);
		    
		    $ship->setNbPassenger($data[6]);
		    
		    $manager->persist($phone);
		    $manager->persist($email);
		    $manager->persist($ship);
		    $manager->flush();
		  }
		  $row++;
		  //$ship->setNameShip($data[0]);
		  //$ship->setSociety($manager->getRepository('IaatoIaatoBundle:Society')->findBy(array("labelSociety"=>$data[1])));
		  //if($manager->getRepository('IaatoIaatoBundle:Society')->findOneBy(array("labelSociety"=>$data[0])) == "")
		  //{ 
		  //    $manager->persist($ship);       
		  //    $manager->flush();
		  // }   
	      }
	    fclose($handle);
  	}

  	public function getOrder(){

	  return 2; // the order in which fixtures will be loaded
	
	}

}


?>

