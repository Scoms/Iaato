<?php

namespace Iaato\IaatoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Date
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Iaato\IaatoBundle\Entity\DateRepository")
 */
class Date
{

    /**
     * @ORM\OneToMany(targetEntity="Iaato\IaatoBundle\Entity\TimeSlot", mappedBy="date")
    */
    private $timeslot;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date",unique=true)
     */
    private $date;


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
     * Set date
     *
     * @param \DateTime $date
     * @return Date
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timeslot = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add timeslot
     *
     * @param \Iaato\IaatoBundle\Entity\TimeSlot $timeslot
     * @return Date
     */
    public function addTimeslot(\Iaato\IaatoBundle\Entity\TimeSlot $timeslot)
    {
        $this->timeslot[] = $timeslot;
    
        return $this;
    }

    /**
     * Remove timeslot
     *
     * @param \Iaato\IaatoBundle\Entity\TimeSlot $timeslot
     */
    public function removeTimeslot(\Iaato\IaatoBundle\Entity\TimeSlot $timeslot)
    {
        $this->timeslot->removeElement($timeslot);
    }

    /**
     * Get timeslot
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTimeslot()
    {
        return $this->timeslot;
    }
}
