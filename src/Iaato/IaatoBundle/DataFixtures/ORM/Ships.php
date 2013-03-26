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
use Iaato\IaatoBundle\Entity\Ship;
use Iaato\IaatoBundle\Entity\Type;
use Iaato\IaatoBundle\Entity\Society;

class Ships extends AbstractFixture implements FixtureInterface{

	/**
	 * {@inheritDoc}
	*/
	public function load(ObjectManager $manager){
		
		/*
		$codes = array('C6WC2', 'UAUN', 'UAUO');
		$namesShip = array('Alexander von Humboldt', 'Akademik Ioffe', 'Akademik Sergey Vavilov');
		$nbs = array('150', '125', '190');
		$types = array('ice-strengthned', 'standard', 'standard');
		$societies = array('Club Cruise Fleet & Technical Department', 'Quark Expeditions', 'Quark Expeditions');
		*/

		$ship = new Ship;
		$ship->setCode('C6WC2');
    		$ship->setNameShip('Alexander von Humboldt');
    		$ship->setNameSociety('Club Cruise Fleet & Technical Department');
    		$ship->setNbPassenger('150');
		$ship->setType($this->getReference('standard'));
		$ship->setSociety($this->getReference('Club Cruise Fleet & Technical Department'));
    		$manager->persist($ship);
		
    		$manager->flush();

  	}

}


?>
