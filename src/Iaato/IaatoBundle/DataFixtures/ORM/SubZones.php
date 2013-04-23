<?php
// vim: set et sw=4 ts=4 sts=4 fdm=marker ff=unix fenc=utf8
/**
 * SubZone.php
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
use Iaato\IaatoBundle\Entity\SubZone;

class SubZones extends AbstractFixture implements OrderedFixtureInterface{

	/**
	 * {@inheritDoc}
	*/
	public function load(ObjectManager $manager){
		/*
		$label = array('Gerlache Strait', 'Holtedahl Bay', 'Crystal Sound');		
		
		foreach ($label as $i => $label) {
			$subzones[$i] = new SubZone;
			$subzones[$i]->setLabelSubZ($label);
    			$manager->persist($subzones[$i]);
			$this->addReference($label, $subzones[$i]);
		}
		
		// On déclenche l'enregistrement
		$manager->flush();
*/
  	}

  	public function getOrder(){

	  return 1; // the order in which fixtures will be loaded
	
	}

}


?>

