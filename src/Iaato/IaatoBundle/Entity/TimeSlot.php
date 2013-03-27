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
     * @ORM\OneToMany(targetEntity="Iaato\IaatoBundle\Entity\Step", mappedBy="timeslot")
     * @ORM\JoinColumn(nullable=false)
    */
    private $step;

    /**
     * @ORM\ManyToOne(targetEntity="Iaato\IaatoBundle\Entity\Date", inversedBy="timeslot")
     * @ORM\JoinColumn(nullable=false)
    */
    private $date;

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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->step = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add step
     *
     * @param \Iaato\IaatoBundle\Entity\Step $step
     * @return TimeSlot
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
     * Set date
     *
     * @param \Iaato\IaatoBundle\Entity\Date $date
     * @return TimeSlot
     */
    public function setDate(\Iaato\IaatoBundle\Entity\Date $date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \Iaato\IaatoBundle\Entity\Date 
     */
    public function getDate()
    {
        return $this->date;
    }
}