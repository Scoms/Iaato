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
}
