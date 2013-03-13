<?php

namespace Iaato\IaatoBundle\Entity;

class Contact
{
private $nom;
private $email;
private $message;

public function __construct()
{

}
public function getNom()
{
  return $this->nom;
}

public function getEmail()
{
  return $this->email;
}

public function getMessage()
{
  return $this->message;
}

}
?>