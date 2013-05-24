<?php

namespace Iaato\IaatoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Phone
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Iaato\IaatoBundle\Entity\PhoneRepository")
 */
class Phone
{
    /**
     * @ORM\ManyToOne(targetEntity="Iaato\IaatoBundle\Entity\Ship", inversedBy="phone") //Un phone pour un seul bateau mais un bateau peut avoir plusieurs phones
     * @ORM\JoinColumn(nullable=false) //Interdit de créer un phone non rattaché à un bateau
    */
    private $ship;

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
     * @ORM\Column(name="numberPhone", type="string", length=15)
     */
    private $numberPhone;


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
     * Set numberPhone
     *
     * @param string $numberPhone
     * @return Phone
     */
    public function setNumberPhone($numberPhone)
    {
        $this->numberPhone = $numberPhone;
    
        return $this;
    }

    /**
     * Get numberPhone
     *
     * @return string 
     */
    public function getNumberPhone()
    {
        return $this->numberPhone;
    }

    /**
     * Set ship
     *
     * @param \Iaato\IaatoBundle\Entity\Ship $ship
     * @return Phone
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
}
