<?php

namespace Iaato\IaatoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Type
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Iaato\IaatoBundle\Entity\TypeRepository")
 */
class Type
{

    /**
     * @ORM\OneToMany(targetEntity="Iaato\IaatoBundle\Entity\Ship",mappedBy="idtype")
     * @ORM\OneToMany(targetEntity="Iaato\IaatoBundle\Entity\Zone",mappedBy="idtype")
    */
    private $ship;
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
     * @ORM\Column(name="labelType", type="string", length=255)
     */
    private $labelType;


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
     * Set labelType
     *
     * @param string $labelType
     * @return Type
     */
    public function setLabelType($labelType)
    {
        $this->labelType = $labelType;
    
        return $this;
    }

    /**
     * Get labelType
     *
     * @return string 
     */
    public function getLabelType()
    {
        return $this->labelType;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ship = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add ship
     *
     * @param \Iaato\IaatoBundle\Entity\Ship $ship
     * @return Type
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

    /**
     * Get ship
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getShip()
    {
        return $this->ship;
    }

    public function __toString()
    {
      return $this->getLabelType();
    }

}