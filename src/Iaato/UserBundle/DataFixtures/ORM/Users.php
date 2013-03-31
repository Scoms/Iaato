<?php
// src/Iaato/UserBundle/DataFixtures/ORM/Users.php
 
namespace Iaato\UserBundle\DataFixtures\ORM;
 
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Iaato\UserBundle\Entity\User; 

class Users implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $user = new User;
    $user->setUsername('superadmin');
    $user->setPassword(sha1('iaato2013_LEE'));
    $user->setSalt('');
	$user->setRoles(array('ROLE_ADMIN'));
    $manager->persist($user);
    $user = new User;
    $user->setUsername('secretariat');
    $user->setPassword(sha1('pass'));
    $user->setSalt('');
	$user->setRoles(array('ROLE_SECRETARIAT'));
    $manager->persist($user);
    $user = new User;
    $user->setUsername('capitaine');
    $user->setPassword(sha1('pass'));
    $user->setSalt('');
	$user->setRoles(array('ROLE_CAPITAINE'));
    $manager->persist($user);
    
    /*
    $liste_roles = $manager->getRepository('IaatoUserBundle:Role')->findAll();
	foreach($liste_roles as $role)
	{
			$user->addRole($role);
	}*/
	$manager->flush();
  }
}
