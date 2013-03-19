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
}