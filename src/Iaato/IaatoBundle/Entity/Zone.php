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
}
