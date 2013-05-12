<?php
// vim: set et sw=4 ts=4 sts=4 fdm=marker ff=unix fenc=utf8
/**
 * Dates.php
 *
 * @author
 * @date 2013/03/26
 * @link
 */

namespace Iaato\IaatoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Iaato\IaatoBundle\Entity\Date;



class Dates extends AbstractFixture implements OrderedFixtureInterface{
	
	/**
	 * {@inheritDoc}
	*/
	public function load(ObjectManager $manager)
	{
	  $d = new \DateTime("10/11/2013");
	  $i = 0;
	  for($i = 0; $i < 100; $i++)
	  {
	    $date = new Date;
	    $date->setDate($d);	
	    $manager->persist($date);	
	    $manager->flush();
	    $d->add(new \DateInterval('P1D'));
	  }
  	}

  	public function getOrder(){
	  return 1; // the order in which fixtures will be loaded
	}

}


?>

