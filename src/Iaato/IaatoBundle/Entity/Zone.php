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
     * @ORM\OneToMany(targetEntity="Iaato\IaatoBundle\Entity\Site", mappedBy="zone")
     * @ORM\JoinColumn(nullable=false) //Une zone est rattachée à au moins un site
    */
    private $site;

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
        $this->site = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add site
     *
     * @param \Iaato\IaatoBundle\Entity\Site $site
     * @return Zone
     */
    public function addSite(\Iaato\IaatoBundle\Entity\Site $site)
    {
        $this->site[] = $site;
    
        return $this;
    }

    /**
     * Remove site
     *
     * @param \Iaato\IaatoBundle\Entity\Site $site
     */
    public function removeSite(\Iaato\IaatoBundle\Entity\Site $site)
    {
        $this->site->removeElement($site);
    }

    /**
     * Get site
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSite()
    {
        return $this->site;
    }
}
