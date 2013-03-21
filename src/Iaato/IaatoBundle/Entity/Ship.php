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
     * @ORM\ManyToOne(targetEntity="Iaato\IaatoBundle\Entity\Type", inversedBy="ship") //Un bateau a un seul type mais un type est rattaché à plusieurs bateaux
     * @ORM\JoinColumn(nullable=false) //Interdit de créer un bateau sans son type
    */
    private $type;

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
     * @var string
     *
     * @ORM\Column(name="nameSociety", type="string", length=255)
     */
    private $nameSociety;

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
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return \Iaato\IaatoBundle\Entity\Type 
     */
    public function getType()
    {
        return $this->type;
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
}
