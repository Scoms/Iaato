<?php

namespace Iaato\IaatoBundle\Entity;

class Article
{
private $titre;
private $auteur;
public function __construct()
{
  $this->auteur = "Coucou";
}

public function getTitre()
{
  return $this->titre;
}
public function getAuteur()
{
  return $this->auteur;
}
// … Les getters et setters
}
?>
