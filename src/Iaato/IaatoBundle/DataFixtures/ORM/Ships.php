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

class Ships extends AbstractFixture implements OrderedFixtureInterface{

	/**
	 * {@inheritDoc}
	*/
	public function load(ObjectManager $manager){
		/*
	$ship = new Ship;
	$ship->setCode('C6WC2');
	$ship->setNameShip('Alexander von Humboldt');
	$ship->setNbPassenger('150');
	$ship->setType($this->getReference('standard'));
	$ship->setSociety($this->getReference('Club Cruise Fleet & Technical Department'));

    	$manager->persist($ship);		
    	$manager->flush();
*/
  	}

  	public function getOrder(){

	  return 2; // the order in which fixtures will be loaded
	
	}

}


?>

