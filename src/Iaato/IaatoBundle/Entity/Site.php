<?php

namespace Iaato\IaatoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Site
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Iaato\IaatoBundle\Entity\SiteRepository")
 */
class Site
{

    /**
     * @ORM\OneToMany(targetEntity="Iaato\IaatoBundle\Entity\Step", mappedBy="site")
     * @ORM\JoinColumn(nullable=false)
    */
    private $step;

    /**
     * @ORM\ManyToOne(targetEntity="Iaato\IaatoBundle\Entity\SubZone", inversedBy="site") 
     * @ORM\JoinColumn(nullable=false) //Interdit de créer un site sans une zone
    */
    private $subzone;

    /**
     * @ORM\ManyToMany(targetEntity="Iaato\IaatoBundle\Entity\Activity",cascade={"persist"}) //Un site propose plusieurs activités et une activité est rattachée à plusieurs sites
    */
    private $activity;

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
     * @ORM\Column(name="nameSite", type="string", length=255)
     */
    private $nameSite;

    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="float")
     */
    private $latitude;

    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="float")
     */
    private $longitude;

    /**
     * @var boolean
     *
     * @ORM\Column(name="iaato", type="boolean")
     */
    private $iaato;


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
     * Set nameSite
     *
     * @param string $nameSite
     * @return Site
     */
    public function setNameSite($nameSite)
    {
        $this->nameSite = $nameSite;
    
        return $this;
    }

    /**
     * Get nameSite
     *
     * @return string 
     */
    public function getNameSite()
    {
        return $this->nameSite;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     * @return Site
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    
        return $this;
    }

    /**
     * Get latitude
     *
     * @return float 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     * @return Site
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    
        return $this;
    }

    /**
     * Get longitude
     *
     * @return float 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set iaato
     *
     * @param boolean $iaato
     * @return Site
     */
    public function setIaato($iaato)
    {
        $this->iaato = $iaato;
    
        return $this;
    }

    /**
     * Get iaato
     *
     * @return boolean 
     */
    public function getIaato()
    {
        return $this->iaato;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->activity = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add activity
     *
     * @param \Iaato\IaatoBundle\Entity\Activity $activity
     * @return Site
     */
    public function addActivity(\Iaato\IaatoBundle\Entity\Activity $activity)
    {
        $this->activity[] = $activity;
    
        return $this;
    }

    /**
     * Remove activity
     *
     * @param \Iaato\IaatoBundle\Entity\Activity $activity
     */
    public function removeActivity(\Iaato\IaatoBundle\Entity\Activity $activity)
    {
        $this->activity->removeElement($activity);
    }

    /**
     * Get activity
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * Set zone
     *
     * @param \Iaato\IaatoBundle\Entity\Zone $zone
     * @return Site
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

    /**
     * Add step
     *
     * @param \Iaato\IaatoBundle\Entity\Step $step
     * @return Site
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
     * Set subzone
     *
     * @param \Iaato\IaatoBundle\Entity\SubZone $subzone
     * @return Site
     */
    public function setSubzone(\Iaato\IaatoBundle\Entity\SubZone $subzone)
    {
        $this->subzone = $subzone;
    
        return $this;
    }

    /**
     * Get subzone
     *
     * @return \Iaato\IaatoBundle\Entity\SubZone 
     */
    public function getSubzone()
    {
        return $this->subzone;
    }
}