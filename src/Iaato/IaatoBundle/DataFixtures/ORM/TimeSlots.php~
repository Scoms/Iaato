<?php
// vim: set et sw=4 ts=4 sts=4 fdm=marker ff=unix fenc=utf8
/**
 * TimeSlots.php
 *
 * @author
 * @date 2013/03/26
 * @link
 */

namespace Iaato\IaatoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Iaato\IaatoBundle\Entity\TimeSlot;
use Iaato\IaatoBundle\Entity\TimeSlotLabel;


class TimeSlots extends AbstractFixture implements OrderedFixtureInterface{
	
	/**
	 * {@inheritDoc}
	*/
	public function load(ObjectManager $manager)
	{
	  $date_list = $manager->getRepository('IaatoIaatoBundle:Date')->findAll();
	  $label_list = $manager->getRepository('IaatoIaatoBundle:TimeSlotLabel')->findAll();
	  foreach($date_list as $date)
	  {
	    foreach($label_list as $label)
	    {
		$ts = new TimeSlot;
		$ts->setLabelTimeSlot($label);
		$ts->setDate($date);
		$manager->persist($ts);	
		$manager->flush();
	    
	    }
	  }
	}
  	public function getOrder(){
	  return 2; // the order in which fixtures will be loaded
	}

}


?>

