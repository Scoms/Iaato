<?php

namespace Iaato\IaatoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SubZone
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Iaato\IaatoBundle\Entity\SubZoneRepository")
 */
class SubZone
{

    /**
     * @ORM\ManyToOne(targetEntity="Iaato\IaatoBundle\Entity\Zone", inversedBy="subZone")
     * @ORM\JoinColumn(nullable=false)
    */
    private $zone;

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
     * @ORM\Column(name="labelSubZ", type="string", length=255)
     */
    private $labelSubZ;


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
     * Set labelSubZ
     *
     * @param string $labelSubZ
     * @return SubZone
     */
    public function setLabelSubZ($labelSubZ)
    {
        $this->labelSubZ = $labelSubZ;
    
        return $this;
    }

    /**
     * Get labelSubZ
     *
     * @return string 
     */
    public function getLabelSubZ()
    {
        return $this->labelSubZ;
    }

    /**
     * Set zone
     *
     * @param \Iaato\IaatoBundle\Entity\Zone $zone
     * @return SubZone
     */
    public function setZone(\Iaato\IaatoBundle\Entity\Zone $zone)
    {
        $this->zone = $zone;
    
        return $this;
    }

    /**
     * Get zone
     *
     * @return \Iaato\IaatoBundle\Entity\Zone 
     */
    public function getZone()
    {
        return $this->zone;
    }
    public function __toString()
    {
      return $this->getLabelSubZ();
    }
}