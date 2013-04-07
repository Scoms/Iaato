<?php
// vim: set et sw=4 ts=4 sts=4 fdm=marker ff=unix fenc=utf8
/**
 * Zones.php
 *
 * @author
 * @date 2013/03/26
 * @link
 */

namespace Iaato\IaatoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Iaato\IaatoBundle\Entity\Type;
use Iaato\IaatoBundle\Entity\Zone;
use Iaato\IaatoBundle\Entity\Society;



class Zones extends AbstractFixture implements OrderedFixtureInterface{
	
	/**
	 * {@inheritDoc}
	*/
	public function load(ObjectManager $manager){
		/*$zones = array('Antartic Peninsula', 'Argentina', 'Falklands','South Georgia');
		foreach ($zones as $zone) 
		{
			$obj = new Zone;
			$obj->setLabelZone($zone);
			$obj->setType($this->getReference('standard'));
    			$manager->persist($obj);
		}
		$manager->flush();
		*/
  	}
  	public function getOrder()
	{
	  return 2; // the order in which fixtures will be loaded
	}

}


?>

