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
use Iaato\IaatoBundle\Entity\Type;

class Types extends AbstractFixture implements FixtureInterface{
	
	/**
	 * {@inheritDoc}
	*/
	public function load(ObjectManager $manager){
		
		$label = array('standard', 'ice-strengthned', 'ice-breaker');		
		
		foreach ($label as $i => $label) {
			$types[$i] = new Type;
			$types[$i]->setLabelType($label);
    			$manager->persist($types[$i]);
		
			$this->addReference($label, $types[$i]);
		}
		
		// On déclenche l'enregistrement
		$manager->flush();

  	}

}


?>

