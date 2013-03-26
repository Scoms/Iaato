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
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Iaato\IaatoBundle\Entity\Society;

class Societies extends AbstractFixture implements FixtureInterface{
	
	/**
	 * {@inheritDoc}
	*/
	public function load(ObjectManager $manager){
		
		$label = array('Club Cruise Fleet & Technical Department', 'Quark Expeditions', 'Oceanwide Expeditions');		
		
		foreach ($label as $i => $label) {
			$societies[$i] = new Society;
			$societies[$i]->setLabelSociety($label);
    			$manager->persist($societies[$i]);
		
			$this->addReference($label, $societies[$i]);
		}
		
		// On déclenche l'enregistrement
		$manager->flush();

  	}

}


?>

