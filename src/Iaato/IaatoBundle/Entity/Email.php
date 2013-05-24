<?php

namespace Iaato\IaatoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Email
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Iaato\IaatoBundle\Entity\EmailRepository")
 */
class Email
{
    /**
     * @ORM\ManyToOne(targetEntity="Iaato\IaatoBundle\Entity\Ship", inversedBy="email", cascade={"persist"}) //Un email pour un seul bateau mais un bateau peut avoir plusieurs emails
     * @ORM\JoinColumn(nullable=false) //Interdit de créer un email non rattaché à un bateau
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
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;


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
     * Set email
     *
     * @param string $email
     * @return Email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set ship
     *
     * @param \Iaato\IaatoBundle\Entity\Ship $ship
     * @return Email
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