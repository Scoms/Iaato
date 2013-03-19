<?php

namespace Iaato\IaatoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TimeSlot
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Iaato\IaatoBundle\Entity\TimeSlotRepository")
 */
class TimeSlot
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
     * @ORM\Column(name="labelTimeSlot", type="string", length=255)
     */
    private $labelTimeSlot;


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
     * Set labelTimeSlot
     *
     * @param string $labelTimeSlot
     * @return TimeSlot
     */
    public function setLabelTimeSlot($labelTimeSlot)
    {
        $this->labelTimeSlot = $labelTimeSlot;
    
        return $this;
    }

    /**
     * Get labelTimeSlot
     *
     * @return string 
     */
    public function getLabelTimeSlot()
    {
        return $this->labelTimeSlot;
    }
}
