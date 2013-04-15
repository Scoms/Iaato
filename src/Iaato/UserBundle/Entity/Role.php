<?php
// src/Iaato/UserBundle/Entity/Roles.php
 
namespace Iaato\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
 
/**
 * Iaato\UserBundle\Entity\Roles
 * 
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Iaato\UserBundle\Entity\RoleRepository")
 */
class Role
{
  /**
   * @var integer $id
   * 
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;
 
  /**
   * @var string $nom 
   * 
   * @ORM\Column(name="nom", type="string", length=255, unique=true)
   */
  protected $nom;
   
   /**
    * Get id
    * 
    * @return integer
    */
  public function getId()
  {
    return $this->id;
  }
	/**
	 * Get nom
	 * @return string
	 */
	public function getNom()
	{
		return $this->nom;
	}
	/**
	 * Set nom
	 * 
	 * @param string $nom
	 * @return Role
	 */
	public function setNom($label)
	{
		$this->nom = $label;;
		
		return $this;
	}
}
