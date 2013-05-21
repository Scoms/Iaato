<?php
// vim: set et sw=4 ts=4 sts=4 fdm=marker ff=unix fenc=utf8
/**
 * Site.php
 *
 * @author
 * @date 2013/03/26
 * @link
 */


namespace Iaato\IaatoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Iaato\IaatoBundle\Entity\Activity;

class Activities extends AbstractFixture implements OrderedFixtureInterface{

	/**
	 * {@inheritDoc}
	*/
	public function load(ObjectManager $manager){
		$handle = fopen('template_csv/remplis/activities.csv','r');
		$data = fgetcsv($handle, 1000, ";");
		while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
		{
		  $A = new Activity;
		  $A->setLabelActivity($data[0]);
		  $manager->persist($A);       
		  $manager->flush();
	      }
	    fclose($handle);
  	}

  	public function getOrder(){

	  return 0; // the order in which fixtures will be loaded
	
	}

}


?>

