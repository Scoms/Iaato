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
use Iaato\IaatoBundle\Entity\Site;
use Iaato\IaatoBundle\Entity\Zone;
use Iaato\IaatoBundle\Entity\SubZone;

class Zones extends AbstractFixture implements OrderedFixtureInterface{

	/**
	 * {@inheritDoc}
	*/
	public function load(ObjectManager $manager){
		/*
		$label = array('Antartic Peninsula', 'Falklands', 'South Georgia');		
		
		foreach ($label as $i => $label) {
			$zones[$i] = new Zone;
			$zones[$i]->setLabelZone($label);
    			$manager->persist($zones[$i]);
			$this->addReference($label, $zones[$i]);
			$zones[$i]->setSubZone($this->getReference('Gerlache Strait'));
		}
		
		// On déclenche l'enregistrement
		$manager->flush();
*/
  	}

  	public function getOrder(){

	  return 2; // the order in which fixtures will be loaded
	
	}

}


?>

