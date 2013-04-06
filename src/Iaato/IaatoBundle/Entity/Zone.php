<?php

namespace Iaato\IaatoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Zone
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Iaato\IaatoBundle\Entity\ZoneRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="x", type="string")
 */
 
 // * @ORM\DiscriminatorMap({"subzone" = "SubZone"}) // Ligne )à rajouter mais génère des erreurs 
class Zone
{

    /**
     * @ORM\OneToMany(targetEntity="Iaato\IaatoBundle\Entity\Site", mappedBy="zone")
     * @ORM\JoinColumn(nullable=false) //Une zone est rattachée à au moins un site
    */
    private $site;
    
    /**
     * @ORM\ManyToOne(targetEntity="Iaato\IaatoBundle\Entity\Type", inversedBy="ship") //Un bateau a un seul type mais un type est rattaché à plusieurs bateaux
     * @ORM\JoinColumn(nullable=false) //Interdit de créer un bateau sans son type
    */
    private $idtype;
    
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
}
