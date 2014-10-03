<?php
	
	include_once "Base.php";

	
	class Client {
		
		private $id_client;
		
		private $login_client;
		
		private $mdp_client;
		
		private $nom_client;
		
		private $prenom_client;
		
		private $mail_client;
		
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
			$query = "INSERT INTO client values ('', '$this->login_client', '$this->mdp_client', '$this->nom_client', '$this->prenom_client', '$this->mail_client')";
			$res = $b->query($query);
			$lastid = $b->lastInsertId();
			$this->id = $lastid;
		}
		
		public function update($login, $mdp, $nom, $prenom, $mail) {
		$b = Base::getConnection();
		$save_query = "update client set login_client=:login, mdp_client=:mdp, nom_client=:nom, prenom_client=:prenom, mail_client=:mail where id_client = :id_client";
			try{
				$stmt = $b->prepare($save_query);
				$a = $stmt->execute(array(':login'=>$login,':mdp'=>$mdp, ':nom'=>$nom, ':prenom'=>$prenom, ':mail'=>$mail, ':id_client'=>$this->id_client));
				return $a;
			}catch (PDOException $e){
				return null;
			}
		}
			
		public function delete() {
			$db = Base::getConnection();	
			$sth = $db->prepare('DELETE FROM client WHERE id_client = :id;');
			$a = $sth->execute(array(':id'=>$this->id_client));
			return $a;
			throw new Exception("méthode delete() non implantée");
		}
		
		public static function findById($id) {
			$b = Base::getConnection();
			$query = "Select * from client where id_client = :id";
			try{
				$stmt = $b->prepare($query);
				$a= $stmt->execute(array(':id'=>$id));
			}catch (PDOException $e){
				return null;
			}
			$res = array();
			$tab = $stmt->fetch();
			$cli = new Client();
			$cli->id_client = $tab['id_client'];
			$cli->login_client = $tab['login_client'];
			$cli->mdp_client = $tab['mdp_client'];
			$cli->nom_client = $tab['nom_client'];
			$cli->prenom_client = $tab['prenom_client'];
            $cli->mail_client = $tab['mail_client'];
			return $cli;
		}
		
		public static function findByLogin($login) {
			$b = Base::getConnection();
			$query = "Select * from client where login_client = :login";
			try{
				$stmt = $b->prepare($query);
				$a= $stmt->execute(array(':login'=>$login));
			}catch (PDOException $e){
				return null;
			}
			$res = array();
			$tab = $stmt->fetch();
			$cli = new Client();
			$cli->id_client = $tab['id_client'];
			$cli->login_client = $tab['login_client'];
			$cli->mdp_client = $tab['mdp_client'];
			$cli->nom_client = $tab['nom_client'];
			$cli->prenom_client = $tab['prenom_client'];
            $cli->mail_client = $tab['mail_client'];
			return $cli;
		}
		
		public static function findByNom($nom) {
			$b = Base::getConnection();
			$query = "Select * from client where nom_client = :nom";
			try{
				$stmt = $b->prepare($query);
				$a= $stmt->execute(array(':nom'=>$nom));
			}catch (PDOException $e){
				return null;
			}
			$res = array();
			$tab = $stmt->fetch();
			$cli = new Client();
			$cli->id_client = $tab['id_client'];
			$cli->login_client = $tab['login_client'];
			$cli->mdp_client = $tab['mdp_client'];
			$cli->nom_client = $tab['nom_client'];
			$cli->prenom_client = $tab['prenom_client'];
            $cli->mail_client = $tab['mail_client'];
			return $cli;
		}
		
		public static function findByMail($mail) {
			$b = Base::getConnection();
			$query = "Select * from client where mail_client = :mail";
			try{
				$stmt = $b->prepare($query);
				$a= $stmt->execute(array(':mail'=>$mail));
			}catch (PDOException $e){
				return null;
			}
			$res = array();
			$tab = $stmt->fetch();
			$cli = new Client();
			$cli->id_client = $tab['id_client'];
			$cli->login_client = $tab['login_client'];
			$cli->mdp_client = $tab['mdp_client'];
			$cli->nom_client = $tab['nom_client'];
			$cli->prenom_client = $tab['prenom_client'];
            $cli->mail_client = $tab['mail_client'];
			return $cli;
		}
		
	}
	
?>