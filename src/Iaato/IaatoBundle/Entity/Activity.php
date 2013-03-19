<?php

namespace Iaato\IaatoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Activity
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Iaato\IaatoBundle\Entity\ActivityRepository")
 */
class Activity
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
     * @ORM\Column(name="labelActivity", type="string", length=255)
     */
    private $labelActivity;


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
     * Set labelActivity
     *
     * @param string $labelActivity
     * @return Activity
     */
    public function setLabelActivity($labelActivity)
    {
        $this->labelActivity = $labelActivity;
    
        return $this;
    }

    /**
     * Get labelActivity
     *
     * @return string 
     */
    public function getLabelActivity()
    {
        return $this->labelActivity;
    }
}
