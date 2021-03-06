<?php

namespace Iaato\IaatoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Zone
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Iaato\IaatoBundle\Entity\ZoneRepository")
 */ 
class Zone
{

    /**
     * @ORM\OneToMany(targetEntity="Iaato\IaatoBundle\Entity\SubZone",mappedBy="zone")
     * @ORM\JoinColumn(nullable=false)
    */
    private $subzone;
    
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
     * @ORM\Column(name="labelZone", type="string", length=255)
    */
    private $labelZone;


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
     * Set labelZone
     *
     * @param string $labelZone
     * @return Zone
     */
    public function setLabelZone($labelZone)
    {
        $this->labelZone = $labelZone;
    
        return $this;
    }

    /**
     * Get labelZone
     *
     * @return string 
     */
    public function getLabelZone()
    {
        return $this->labelZone;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
    
    }
    
    /**
     * Set type
     *
     * @param \Iaato\IaatoBundle\Entity\Type $type
     * @return Zone
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
     * Set idtype
     *
     * @param \Iaato\IaatoBundle\Entity\Type $idtype
     * @return Zone
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
     * Set subZone
     *
     * @param \Iaato\IaatoBundle\Entity\SubZone $subZone
     * @return Zone
     */
    public function setSubZone(\Iaato\IaatoBundle\Entity\SubZone $subZone)
    {
        $this->subZone = $subZone;
    
        return $this;
    }

    /**
     * Get subZone
     *
     * @return \Iaato\IaatoBundle\Entity\SubZone 
     */
    public function getSubZone()
    {
        return $this->subZone;
    }
}