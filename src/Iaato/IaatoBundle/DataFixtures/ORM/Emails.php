<?php
// vim: set et sw=4 ts=4 sts=4 fdm=marker ff=unix fenc=utf8
/**
 * Emails.php
 *
 * @author
 * @date 2013/03/31
 * @link
 */
namespace Iaato\IaatoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Iaato\IaatoBundle\Entity\Email;

class Emails extends AbstractFixture implements OrderedFixtureInterface{

	/**
	 * {@inheritDoc}
	*/
	public function load(ObjectManager $manager){
		
		$email = new Email;
		$email->setEmail('baba@mail.com');
		
		//$email->setShip($this->getReference('ship'));

		//$manager->persist($ship);		
		$manager->flush();

  	}
  	public function getOrder()
	{
	  return 1; // the order in which fixtures will be loaded
	}

}

?>

