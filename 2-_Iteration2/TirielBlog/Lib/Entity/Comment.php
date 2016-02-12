<?php

namespace Lib\Entity;

class Comment
{
	private $id;
	private $pseudo = "A.nonymous";
	private $mailAdress = "example@provider.com";
	private $gHash;
	private $comment;
	
	public function getId()
	{
		return $this->id;
	}
	
	public function setId($id)
	{
		if (isset($id) && is_int($id)) {
			$this->id = $id;
		}
	}
	
	public function getPseudo()
	{
		return $this->pseudo;
	}
	
	public function setPseudo($pseudo)
	{
		if(isset($pseudo) && is_string($pseudo)) {
			$this->pseudo = $pseudo;
		}
	}
	
	public function getMailAdress()
	{
		return $this->mailAdress;
	}
	
	public function setMailAdress($mail)
	{
		if(preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#i', $mail)) {
			$this->mailAdress = $mail;
		}
	}
	
	public function setGravatar()
	{
		$this->gHash = md5(strtolower(trim($this->mailAdress)));
	}
}
