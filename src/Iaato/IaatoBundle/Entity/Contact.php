<?php

namespace Iaato\IaatoBundle\Entity;

class Contact{
	
	private $nom;
	private $email;
	private $sujet;
	private $message;

	public function getNom(){
		return $this->nom;
	}
	
	public function setNom(){
		$this->nom = $nom;
	}
	
	public function getEmail(){
		return $this->email;
	}
	
	public function setEmail(){
		$this->email = $email;
	}

	public function getSujet(){
		return $this->sujet;
	}

	public function setSujet(){
		$this->sujet = $sujet;
	}

	public function getMessage(){
		return $this->message;
	}
	
	public function setMessage(){
		$this->message = $message;
	}
}

?>
