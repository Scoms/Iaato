<?php

namespace Iaato\IaatoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Society
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Iaato\IaatoBundle\Entity\SocietyRepository")
 */
class Society
{

    /**
     * @ORM\OneToMany(targetEntity="Iaato\IaatoBundle\Entity\Ship",mappedBy="society", cascade={"remove"})
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
     * @ORM\Column(name="labelSociety", type="string", length=255,unique=true)
     */
    private $labelSociety;


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
     * Set labelSociety
     *
     * @param string $labelSociety
     * @return Society
     */
    public function setLabelSociety($labelSociety)
    {
        $this->labelSociety = $labelSociety;
    
        return $this;
    }

    /**
     * Get labelSociety
     *
     * @return string 
     */
    public function getLabelSociety()
    {
        return $this->labelSociety;
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
     * @return Society
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
      return $this->getLabelSociety();
    }
}