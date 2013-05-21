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
use Iaato\IaatoBundle\Entity\SubZone;
class SubZones extends AbstractFixture implements OrderedFixtureInterface{

	/**
	 * {@inheritDoc}
	*/
	public function load(ObjectManager $manager)
	{
	  $repo_zone = $manager->getRepository('IaatoIaatoBundle:Zone');
	  $repo_szone = $manager->getRepository('IaatoIaatoBundle:Subzone');
	  $handle = fopen('template_csv/remplis/subzones.csv','r');
		$data = fgetcsv($handle, 1000, ";");
		while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
		{
		  $zone = new Subzone;
		  $zone->setLabelSubZ($data[1]);
		  $zone->setZone($repo_zone->findOneBy(array('labelZone'=>$data[0])));
		  if($repo_szone->findOneBy(array("labelSubZ"=>$data[1],"zone"=>$zone->getZone()))=="")
		  {
		    $manager->persist($zone);
		    $manager->flush();
		  }
	      }
	    fclose($handle);
	    
	    //On attribut une sous zone eponyme à chaque zone pour des raisons pratique d'applications
	    foreach($repo_zone->findAll() as $zone)
	    {
	      $s_zone = new SubZone;
	      $s_zone->setLabelSubZ($zone->getLabelZone());
	      $s_zone->setZone($zone);
	      $manager->persist($s_zone);
	    }
	    $manager->flush();
  	}

  	public function getOrder(){

	  return 1; // the order in which fixtures will be loaded
	
	}

}


?>

