<?php

namespace Iaato\IaatoBundle\Entity;

class ContactMail
{
private $nom;
private $email;
private $message;

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
// … Les getters et setters
}
?>
