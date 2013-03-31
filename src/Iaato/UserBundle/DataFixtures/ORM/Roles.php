<?php
// src/Iaato/UserBundle/DataFixtures/ORM/Roles.php
 
namespace Iaato\UserBundle\DataFixtures\ORM;
 
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Iaato\UserBundle\Entity\Role; 

class Roles implements FixtureInterface
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
}
