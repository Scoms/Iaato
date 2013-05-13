<?php
// vim: set et sw=4 ts=4 sts=4 fdm=marker ff=unix fenc=utf8
/**
 * Zone.php
 *
 * @author
 * @date 2013/03/26
 * @link
 */


namespace Iaato\IaatoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Iaato\IaatoBundle\Entity\Zone;

class Zones extends AbstractFixture implements OrderedFixtureInterface{

	/**
	 * {@inheritDoc}
	*/
	public function load(ObjectManager $manager){
		
		$handle = fopen('template_csv/remplis/zones.csv','r');
		$data = fgetcsv($handle, 1000, ";");
		while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
		{
		  $zone = new Zone;
		  $zone->setLabelZone($data[0]);
		  if($manager->getRepository('IaatoIaatoBundle:Zone')->findOneBy(array("labelZone"=>$data[0])) == "")
		  { 
		      $manager->persist($zone);       
		      $manager->flush();
		   }   
	      }
	    fclose($handle);
  	}

  	public function getOrder(){

	  return 0; // the order in which fixtures will be loaded
	
	}

}


?>

