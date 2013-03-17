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
	
	public function setNom($nom){
		$this->nom = $nom;
	}
	
	public function getEmail(){
		return $this->email;
	}
	
	public function setEmail($email){
		$this->email = $email;
	}

	public function getSujet(){
		return $this->sujet;
	}

	public function setSujet($sujet){
		$this->sujet = $sujet;
	}

	public function getMessage(){
		return $this->message;
	}
	
	public function setMessage($message){
		$this->message = $message;
	}
}

?>
