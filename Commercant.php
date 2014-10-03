<?php

	include_once "Base.php";
	
	class Commercant {
		
		private $id_com;
		
		private $login_com;
		
		private $mdp_com;
		
		private $nom_com;
		
		private $prenom_com;
		
		private $mail_com;
		
		
		public function __construct() {
  		}
		
		public function __get($attr_name) {
			if (property_exists( __CLASS__, $attr_name)) { 
			  return $this->$attr_name;
			} 
  		}
		
		public function __set($attr_name, $attr_val) {
			if (property_exists( __CLASS__, $attr_name)){
				return $this->$attr_name=$attr_val;
			}	
		}
		
		public function insert() {
			$b = Base::getConnection();
			$query = "INSERT INTO commercant values ('', '$this->login_com', '$this->mdp_com', '$this->nom_com', '$this->prenom_com', '$this->mail_com')";
			$res = $b->query($query);
			$lastid = $b->lastInsertId();
			$this->id = $lastid;
		}
		
		
		public function update($login, $mdp, $nom, $prenom, $mail) {
		$b = Base::getConnection();
		$save_query = "update commercant set login_commercant=:login, mdp_commercant=:mdp, nom_commercant=:nom, prenom_commercant=:prenom, mail_commercant=:mail where id_commercant = :id_com";
			try{
				$stmt = $b->prepare($save_query);
				$a = $stmt->execute(array(':login'=>$login,':mdp'=>$mdp, ':nom'=>$nom, ':prenom'=>$prenom, ':mail'=>$mail, ':id_com'=>$this->id_com));
				return $a;
			}catch (PDOException $e){
				return null;
			}
		}
		
		public function delete() {
			$db = Base::getConnection();	
			$sth = $db->prepare('DELETE FROM commercant WHERE id_commercant = :id');
			$a = $sth->execute(array(':id'=>$this->id_com));
			return $a;
			throw new Exception("méthode delete() non implantée");
		}
		
		public static function findById($id) {
			$b = Base::getConnection();
			$query = "Select * from commercant where id_commercant = :id";
			try{
				$stmt = $b->prepare($query);
				$a= $stmt->execute(array(':id'=>$id));
			}catch (PDOException $e){
				return null;
			}
			$res = array();
			$tab = $stmt->fetch();
			$com = new Commercant();
			$com->id_com = $tab['id_commercant'];
			$com->login_com = $tab['login_commercant'];
			$com->mdp_com = $tab['mdp_commercant'];
			$com->nom_com = $tab['nom_commercant'];
			$com->prenom_com = $tab['prenom_commercant'];
            $com->mail_com = $tab['mail_commercant'];
			return $com;
		}
		
		public static function findByLogin($log) {
			$b = Base::getConnection();
			$query = "Select * from commercant where login_commercant = :login";
			try{
				$stmt = $b->prepare($query);
				$a= $stmt->execute(array(':login'=>$log));
			}catch (PDOException $e){
				return null;
			}
			$res = array();
			$tab = $stmt->fetch();
			$com = new Commercant();
			$com->id_com = $tab['id_commercant'];
			$com->login_com = $tab['login_commercant'];
			$com->mdp_com = $tab['mdp_commercant'];
			$com->nom_com = $tab['nom_commercant'];
			$com->prenom_com = $tab['prenom_commercant'];
            $com->mail_com = $tab['mail_commercant'];
			return $com;
		}
		
		public static function findByNom($nom) {
			$b = Base::getConnection();
			$query = "Select * from commercant where nom_commercant = :nom";
			try{
				$stmt = $b->prepare($query);
				$a= $stmt->execute(array(':nom'=>$nom));
			}catch (PDOException $e){
				return null;
			}
			$res = array();
			$tab = $stmt->fetch();
			$com = new Commercant();
			$com->id_com = $tab['id_commercant'];
			$com->login_com = $tab['login_commercant'];
			$com->mdp_com = $tab['mdp_commercant'];
			$com->nom_com = $tab['nom_commercant'];
			$com->prenom_com = $tab['prenom_commercant'];
            $com->mail_com = $tab['mail_commercant'];
			return $com;
		}
		
		public static function findByMail($mail) {
			$b = Base::getConnection();
			$query = "Select * from commercant where mail_commercant = :mail";
			try{
				$stmt = $b->prepare($query);
				$a= $stmt->execute(array(':mail'=>$mail));
			}catch (PDOException $e){
				return null;
			}
			$res = array();
			$tab = $stmt->fetch();
			$com = new Commercant();
			$com->id_com = $tab['id_commercant'];
			$com->login_com = $tab['login_commercant'];
			$com->mdp_com = $tab['mdp_commercant'];
			$com->nom_com = $tab['nom_commercant'];
			$com->prenom_com = $tab['prenom_commercant'];
            $com->mail_com = $tab['mail_commercant'];
			return $com;
		}
		
	}
	
?>