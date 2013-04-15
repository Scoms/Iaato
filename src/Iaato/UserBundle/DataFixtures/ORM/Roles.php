<?php
// src/Iaato/UserBundle/DataFixtures/ORM/Roles.php
 
namespace Iaato\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Iaato\UserBundle\Entity\Role; 

class Roles extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
	  
                           
    $userRole = new Role;
    $userRole->setNom("ROLE_ADMIN");
    $manager->persist($userRole);
    $userRole = new Role;
    $userRole->setNom("ROLE_CAPITAINE");
    $manager->persist($userRole);
    $userRole = new Role;
    $userRole->setNom("ROLE_SECRETARIAT");
    $manager->persist($userRole);
    $manager->flush();
  }
  public function getOrder()
  {
    return 3; // the order in which fixtures will be loaded
  }
}

?>
