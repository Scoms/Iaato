<?php

namespace Iaato\IaatoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SubZone
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Iaato\IaatoBundle\Entity\SubZoneRepository")
 */
class SubZone extends Zone
{

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
}
