<?php
// src/Iaato/UserBundle/Entity/User.php
 
namespace Iaato\UserBundle\Entity;
 

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
 
/**
 * @ORM\Entity(repositoryClass="Iaato\UserBundle\Entity\UserRepository")
 */
class User implements UserInterface, \Serializable 
{
      /**
   * @ORM\ManyToOne(targetEntity="Iaato\IaatoBundle\Entity\Ship")
   */
  private $ship;
  /**
   * @var integer $id 
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;
 
  /**
   * @ORM\Column(name="username", type="string", length=255, unique=true)
   */
  private $username;
 
  /**
   * @ORM\Column(name="password", type="string", length=255)
   */
  private $password;
 
  /**
   * @ORM\Column(name="salt", type="string", length=255)
   */
  private $salt;
 
  	/**
   * @ORM\Column(name="roles",type="array")
   */
  private $roles;
 
  public function __construct()
  {
    $this->roles = array();
  }
   /**
    * Add roles
    *
    * @param $roles
    */
  public function setRoles($role) // addCategorie sans « s » !
  {
    // Ici, on utilise l'ArrayCollection vraiment comme un tableau, avec la syntaxe []
    $this->roles = $role;
  }

  /**
    * Get roles
    *
    * @return Doctrine\Common\Collections\Collection
    */
  public function getRoles() // Notez le « s », on récupère une liste de catégories ici !
  {
	return $this->roles;
  }
 
  public function getId()
  {
    return $this->id;
  }
 
  public function setUsername($username)
  {
    $this->username = $username;
    return $this;
  }
 
  public function getUsername()
  {
    return $this->username;
  }
 
  public function setPassword($password)
  {
    $this->password = $password;
    return $this;
  }
 
  public function getPassword()
  {
    return $this->password;
  }
 
  public function setSalt($salt)
  {
    $this->salt = $salt;
    return $this;
  }
 
  public function getSalt()
  {
    return $this->salt;
  }
  
  public function eraseCredentials()
  {
  }


    /**
     * Set ship
     *
     * @param \Iaato\IaatoBundle\Entity\Ship $ship
     * @return User
     */
    public function setShip(\Iaato\IaatoBundle\Entity\Ship $ship = null)
    {
        $this->ship = $ship;
    
        return $this;
    }

    /**
     * Get ship
     *
     * @return \Iaato\IaatoBundle\Entity\Ship 
     */
    public function getShip()
    {
        return $this->ship;
    }

    /**
     * Add ship
     *
     * @param \Iaato\IaatoBundle\Entity\Ship $ship
     * @return User
     */
    public function addShip(\Iaato\IaatoBundle\Entity\Ship $ship)
    {
        $this->ship[] = $ship;
    
        return $this;
    }

    /**
     * Remove ship
     *
     * @param \Iaato\IaatoBundle\Entity\Ship $ship
     */
    public function removeShip(\Iaato\IaatoBundle\Entity\Ship $ship)
    {
        $this->ship->removeElement($ship);
    }
 
    public function serialize()
    {
	  return serialize($this->id);
    }

    public function unserialize($data)
    {
	  $this->id = unserialize($data);
    }

}