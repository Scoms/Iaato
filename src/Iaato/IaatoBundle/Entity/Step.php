<?php

namespace Iaato\IaatoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Step
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Iaato\IaatoBundle\Entity\StepRepository")
 */
class Step
{
    /**
     * @ORM\ManyToOne(targetEntity="Iaato\IaatoBundle\Entity\Ship", inversedBy="step")
     * @ORM\JoinColumn(nullable=false)
    */
    private $ship;

    /**
     * @ORM\ManyToOne(targetEntity="Iaato\IaatoBundle\Entity\Site", inversedBy="step")
     * @ORM\JoinColumn(nullable=false)
    */
    private $site;

    /**
     * @ORM\ManyToOne(targetEntity="Iaato\IaatoBundle\Entity\TimeSlot", inversedBy="step")
     * @ORM\JoinColumn(nullable=false)
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set ship
     *
     * @param \Iaato\IaatoBundle\Entity\Ship $ship
     * @return Step
     */
    public function setShip(\Iaato\IaatoBundle\Entity\Ship $ship)
    {
        $this->ship = $ship;
    
        return $this;
    }

    /**
     * Get ship
     *
     * @return \Iaato\IaatoBundle\Entity\Ship 
     */
    public function getShip()
    {
        return $this->ship;
    }

    /**
     * Set site
     *
     * @param \Iaato\IaatoBundle\Entity\Site $site
     * @return Step
     */
    public function setSite(\Iaato\IaatoBundle\Entity\Site $site)
    {
        $this->site = $site;
    
        return $this;
    }

    /**
     * Get site
     *
     * @return \Iaato\IaatoBundle\Entity\Site 
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Set timeslot
     *
     * @param \Iaato\IaatoBundle\Entity\TimeSlot $timeslot
     * @return Step
     */
    public function setTimeslot(\Iaato\IaatoBundle\Entity\TimeSlot $timeslot)
    {
        $this->timeslot = $timeslot;
    
        return $this;
    }

    /**
     * Get timeslot
     *
     * @return \Iaato\IaatoBundle\Entity\TimeSlot 
     */
    public function getTimeslot()
    {
        return $this->timeslot;
    }
}