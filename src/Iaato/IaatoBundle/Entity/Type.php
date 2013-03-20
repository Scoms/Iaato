<?php

namespace Iaato\IaatoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Type
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Iaato\IaatoBundle\Entity\TypeRepository")
 */
class Type
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
     * @ORM\Column(name="labelType", type="string", length=255)
     */
    private $labelType;


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
     * Set labelType
     *
     * @param string $labelType
     * @return Type
     */
    public function setLabelType($labelType)
    {
        $this->labelType = $labelType;
    
        return $this;
    }

    /**
     * Get labelType
     *
     * @return string 
     */
    public function getLabelType()
    {
        return $this->labelType;
    }
}