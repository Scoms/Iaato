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
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Iaato\IaatoBundle\Entity\Society;

class Companys extends AbstractFixture implements OrderedFixtureInterface{

	/**
	 * {@inheritDoc}
	*/
	public function load(ObjectManager $manager)
	{
	  $handle = fopen('template_csv/remplis/societies.csv','r');
	  $row = 2;
	      while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
	      {
		  $num = count($data);
		  $row++;
		  $company = new Society;
		  $company->setLabelSociety($data[0]);
		  if($manager->getRepository('IaatoIaatoBundle:Society')->findOneBy(array("labelSociety"=>$data[0])) == "")
		  { 
		      $manager->persist($company);       
		      $manager->flush();
		   }   
	      }
	    fclose($handle);
  	}

  	public function getOrder(){

	  return 0; // the order in which fixtures will be loaded
	
	}

}


?>

