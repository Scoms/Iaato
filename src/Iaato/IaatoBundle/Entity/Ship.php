<?php

namespace Iaato\IaatoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ship
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Iaato\IaatoBundle\Entity\ShipRepository")
 */
class Ship
{

    /**
     * 
     * @ORM\OneToMany(targetEntity="Iaato\IaatoBundle\Entity\Step", mappedBy="ship")
     * @ORM\JoinColumn(nullable=false)
    */
    private $step;

	/**
    * @ORM\ManyToOne(targetEntity="Iaato\IaatoBundle\Entity\Type", inversedBy="ship") //Un bateau a un seul type mais un type est rattaché à plusieurs bateaux
     * @ORM\JoinColumn(nullable=false) //Champ type de ship à null si suppression d'un type
    */
    private $idtype;
    
    /**
     * @ORM\ManyToOne(targetEntity="Iaato\IaatoBundle\Entity\Society", inversedBy="ship")
     * @ORM\JoinColumn(nullable=false)
    */
    private $society;

    /**
     * @ORM\OneToMany(targetEntity="Iaato\IaatoBundle\Entity\Email",mappedBy="ship")
    */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity="Iaato\IaatoBundle\Entity\Phone", mappedBy="ship")
    */
    private $phone;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=255)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="nameShip", type="string", length=255)
     */
    private $nameShip;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbPassenger", type="integer")
     */
    private $nbPassenger;


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
     * Set code
     *
     * @param string $code
     * @return Ship
     */
    public function setCode($code)
    {
        $this->code = $code;
    
        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set nameShip
     *
     * @param string $nameShip
     * @return Ship
     */
    public function setNameShip($nameShip)
    {
        $this->nameShip = $nameShip;
    
        return $this;
    }

    /**
     * Get nameShip
     *
     * @return string 
     */
    public function getNameShip()
    {
        return $this->nameShip;
    }

    /**
     * Set nameSociety
     *
     * @param string $nameSociety
     * @return Ship
     */
    public function setNameSociety($nameSociety)
    {
        $this->nameSociety = $nameSociety;
    
        return $this;
    }

    /**
     * Get nameSociety
     *
     * @return string 
     */
    public function getNameSociety()
    {
        return $this->nameSociety;
    }

    /**
     * Set nbPassenger
     *
     * @param integer $nbPassenger
     * @return Ship
     */
    public function setNbPassenger($nbPassenger)
    {
        $this->nbPassenger = $nbPassenger;
    
        return $this;
    }

    /**
     * Get nbPassenger
     *
     * @return integer 
     */
    public function getNbPassenger()
    {
        return $this->nbPassenger;
    }

    /**
     * Set type
     *
     * @param \Iaato\IaatoBundle\Entity\Type $type
     * @return Ship
     */
    public function setType(\Iaato\IaatoBundle\Entity\Type $type)
    {
        $this->idtype = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return \Iaato\IaatoBundle\Entity\Type 
     */
    public function getType()
    {
        return $this->idtype;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->email = new \Doctrine\Common\Collections\ArrayCollection();
        $this->phone = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add email
     *
     * @param \Iaato\IaatoBundle\Entity\Email $email
     * @return Ship
     */
    public function addEmail(\Iaato\IaatoBundle\Entity\Email $email)
    {
        $this->email[] = $email;
    
        return $this;
    }

    /**
     * Remove email
     *
     * @param \Iaato\IaatoBundle\Entity\Email $email
     */
    public function removeEmail(\Iaato\IaatoBundle\Entity\Email $email)
    {
        $this->email->removeElement($email);
    }

    /**
     * Get email
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Add phone
     *
     * @param \Iaato\IaatoBundle\Entity\Phone $phone
     * @return Ship
     */
    public function addPhone(\Iaato\IaatoBundle\Entity\Phone $phone)
    {
        $this->phone[] = $phone;
    
        return $this;
    }

    /**
     * Remove phone
     *
     * @param \Iaato\IaatoBundle\Entity\Phone $phone
     */
    public function removePhone(\Iaato\IaatoBundle\Entity\Phone $phone)
    {
        $this->phone->removeElement($phone);
    }

    /**
     * Get phone
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set society
     *
     * @param \Iaato\IaatoBundle\Entity\Society $society
     * @return Ship
     */
    public function setSociety(\Iaato\IaatoBundle\Entity\Society $society)
    {
        $this->society = $society;
    
        return $this;
    }

    /**
     * Get society
     *
     * @return \Iaato\IaatoBundle\Entity\Society 
     */
    public function getSociety()
    {
        return $this->society;
    }

    /**
     * Set idtype
     *
     * @param \Iaato\IaatoBundle\Entity\Type $idtype
     * @return Ship
     */
    public function setIdtype(\Iaato\IaatoBundle\Entity\Type $idtype)
    {
        $this->idtype = $idtype;
    
        return $this;
    }

    /**
     * Get idtype
     *
     * @return \Iaato\IaatoBundle\Entity\Type 
     */
    public function getIdtype()
    {
        return $this->idtype;
    }

    /**
     * Add step
     *
     * @param \Iaato\IaatoBundle\Entity\Step $step
     * @return Ship
     */
    public function addStep(\Iaato\IaatoBundle\Entity\Step $step)
    {
        $this->step[] = $step;
    
        return $this;
    }

    /**
     * Remove step
     *
     * @param \Iaato\IaatoBundle\Entity\Step $step
     */
    public function removeStep(\Iaato\IaatoBundle\Entity\Step $step)
    {
        $this->step->removeElement($step);
    }

    /**
     * Get step
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStep()
    {
        return $this->step;
    }

    /**
     * Set el
     *
     * @param \Iaato\UserBundle\Entity\User $el
     * @return Ship
     */
    public function setEl(\Iaato\UserBundle\Entity\User $el = null)
    {
        $this->el = $el;
    
        return $this;
    }

    /**
     * Get el
     *
     * @return \Iaato\UserBundle\Entity\User 
     */
    public function getEl()
    {
        return $this->el;
    }

    /**
     * Add el
     *
     * @param \Iaato\UserBundle\Entity\User $el
     * @return Ship
     */
    public function addEl(\Iaato\UserBundle\Entity\User $el)
    {
        $this->el[] = $el;
    
        return $this;
    }

    /**
     * Remove el
     *
     * @param \Iaato\UserBundle\Entity\User $el
     */
    public function removeEl(\Iaato\UserBundle\Entity\User $el)
    {
        $this->el->removeElement($el);
    }

    /**
     * Set user
     *
     * @param \Iaato\UserBundle\Entity\User $user
     * @return Ship
     */
    public function setUser(\Iaato\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Iaato\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
    public function __toString()
    {
      return $this->getNameShip();
    }
}