<?php
// vim: set et sw=4 ts=4 sts=4 fdm=marker ff=unix fenc=utf8
/**
 * TimeSlotLabels.php
 *
 * @author
 * @date 2013/03/26
 * @link
 */

namespace Iaato\IaatoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Iaato\IaatoBundle\Entity\TimeSlotlabel;



class TimeSlotLabels extends AbstractFixture implements OrderedFixtureInterface{
	
	/**
	 * {@inheritDoc}
	*/
	public function load(ObjectManager $manager)
	{
	    $ts = new TimeSlotLabel;
	    $ts->setTimeSlotLabel("early morning");
	    $manager->persist($ts);
	    $ts = new TimeSlotLabel;
	    $ts->setTimeSlotLabel("morning");
	    $manager->persist($ts);
	    $ts = new TimeSlotLabel;
	    $ts->setTimeSlotLabel("afternoon");
	    $manager->persist($ts);
	    $ts = new TimeSlotLabel;
	    $ts->setTimeSlotLabel("evening");
	    $manager->persist($ts);
	    $ts = new TimeSlotLabel;
	    $ts->setTimeSlotLabel("overnight");
	    $manager->persist($ts);	
	    $manager->flush();
  	}

  	public function getOrder(){
	  return 1; // the order in which fixtures will be loaded
	}

}


?>

