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
		$repo_s_zone = $manager->getRepository('IaatoIaatoBundle:SubZone');
		$handle = fopen('template_csv/remplis/sites.csv','r');
		$data = fgetcsv($handle, 1000, ";");
		while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
		{
		  $site = new Site;
		  $site->setNameSite($data[0]);
		  $site->setLatitude($data[1]);
		  $site->setLongitude($data[2]);
		  
		  if($data[3] == "false")
		    $site->setIaato(false);
		  else
		    $site->setIaato(true);
		  
		  if($data[5] == "")
		    $data[5] = $data[4];
		    
		  $site->setSubzone($repo_s_zone->findOneBy(array("labelSubZ"=>$data[5])));
		  $manager->persist($site);       
		  $manager->flush();
	      }
	    fclose($handle);
  	}

  	public function getOrder(){

	  return 2; // the order in which fixtures will be loaded
	
	}

}


?>

