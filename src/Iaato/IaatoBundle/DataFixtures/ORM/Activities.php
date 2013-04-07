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
use Iaato\IaatoBundle\Entity\Activity;

class Activities extends AbstractFixture implements OrderedFixtureInterface{
	
	/**
	 * {@inheritDoc}
	*/
	public function load(ObjectManager $manager){
		
		$label = array('Randonnée', 'Ballade en zodiac', 'Camping');		
		
		foreach ($label as $i => $label) {
			$activities[$i] = new Activity;
			$activities[$i]->setLabelActivity($label);
    			$manager->persist($activities[$i]);
			$this->addReference($label, $activities[$i]);
		}
		
		// On déclenche l'enregistrement
		$manager->flush();

  	}
  	public function getOrder()
	{
	  return 1; // the order in which fixtures will be loaded
	}

}


?>

