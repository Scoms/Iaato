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
use Iaato\IaatoBundle\Entity\Site;
use Iaato\IaatoBundle\Entity\Zone;

class Sites extends AbstractFixture implements OrderedFixtureInterface{

	/**
	 * {@inheritDoc}
	*/
	public function load(ObjectManager $manager){
		
		$site = new Site;
		$site->setNameSite('Aitcho Islands');
		$site->setLatitude('62.24');
		$site->setLongitude('59.47');
		$site->setIaato('1');
		$site->setZone($this->getReference('Falklands'));
    	
    	$manager->persist($site);		
    	$manager->flush();

  	}

  	public function getOrder(){

	  return 3; // the order in which fixtures will be loaded
	
	}

}


?>

