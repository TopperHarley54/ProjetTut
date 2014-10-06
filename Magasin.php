<?php

	include_once "Base.php";
	
	class Magasin {
		
		private $id_magasin;
		
		private $nom_magasin;
		
		private $numero;
		
		private $rue;
		
		private $ville;
		
		private $codepostal;
		
		private $description;
		
		private $tel_magasin;
		
		private $id_commercant;
		
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
			$query = "INSERT INTO magasin values ('', '$this->id_magasin', '$this->nom_magasin', '$this->numero', '$this->rue', '$this->ville', '$this->codepostal', '$this->description', '$this->tel_magasin', '$this->id_commercant')";
			$res = $b->query($query);
			$lastid = $b->lastInsertId();
			$this->id = $lastid;
		}
		
		
		public function update($nom, $num, $rue, $ville, $code, $description, $tel) {
		$b = Base::getConnection();
		$save_query = "update magasin set nom_magasin=:nom, numero=:num, rue=:rue, ville=:ville, codepostal=:code, description=:description, tel_magasin=:tel where id_magasin=:id_mag";
			try{
				$stmt = $b->prepare($save_query);
				$a = $stmt->execute(array(':nom'=>$nom,':num'=>$num, ':rue'=>$rue, ':ville'=>$ville, ':code'=>$code, ':description'=>$description, ':tel'=>$tel, ':id_mag'=>$this->id_magasin));
				return $a;
			}catch (PDOException $e){
				return null;
			}
		}
		
		public function delete() {
			$db = Base::getConnection();	
			$sth = $db->prepare('DELETE FROM magasin WHERE id_magasin = :id');
			$a = $sth->execute(array(':id'=>$this->id_magasin));
			return $a;
			throw new Exception("méthode delete() non implantée");
		}
		
		public static function findById($id) {
			$b = Base::getConnection();
			$query = "Select * from magasin where id_magasin = :id";
			try{
				$stmt = $b->prepare($query);
				$a= $stmt->execute(array(':id'=>$id));
			}catch (PDOException $e){
				return null;
			}
			$res = array();
			$tab = $stmt->fetch();
			$mag = new Magasin();
			$mag->id_magasin = $tab['id_magasin'];
			$mag->nom_magasin = $tab['nom_magasin'];
			$mag->numero = $tab['numero'];
			$mag->rue = $tab['rue'];
			$mag->ville = $tab['ville'];
			$mag->codepostal = $tab['codepostal'];
			$mag->description = $tab['description'];
			$mag->tel_magasin = $tab['tel_magasin'];
			$mag->id_commercant = $tab['id_commercant'];
			return $mag;
		}
		
		public static function findByNom($nom) {
			$b = Base::getConnection();
			$query = "Select * from magasin where nom_magasin = :nom";
			try{
				$stmt = $b->prepare($query);
				$a= $stmt->execute(array(':nom'=>$nom));
			}catch (PDOException $e){
				return null;
			}
			$res = array();
			$tab = $stmt->fetch();
			$mag = new Magasin();
			$mag->id_magasin = $tab['id_magasin'];
			$mag->nom_magasin = $tab['nom_magasin'];
			$mag->numero = $tab['numero'];
			$mag->rue = $tab['rue'];
			$mag->ville = $tab['ville'];
			$mag->codepostal = $tab['codepostal'];
			$mag->description = $tab['description'];
			$mag->tel_magasin = $tab['tel_magasin'];
			$mag->id_commercant = $tab['id_commercant'];
			return $mag;
		}
		
		public static function findByVille($ville) {
			$b = Base::getConnection();
			$query = "Select * from magasin where ville = :ville";
			try{
				$stmt = $b->prepare($query);
				$a= $stmt->execute(array(':ville'=>$ville));
			}catch (PDOException $e){
				return null;
			}
			$res = array();
			$tab = $stmt->fetch();
			$mag = new Magasin();
			$mag->id_magasin = $tab['id_magasin'];
			$mag->nom_magasin = $tab['nom_magasin'];
			$mag->numero = $tab['numero'];
			$mag->rue = $tab['rue'];
			$mag->ville = $tab['ville'];
			$mag->codepostal = $tab['codepostal'];
			$mag->description = $tab['description'];
			$mag->tel_magasin = $tab['tel_magasin'];
			$mag->id_commercant = $tab['id_commercant'];
			return $mag;
		}
		
		public static function findByCodepostal($codepostal) {
			$b = Base::getConnection();
			$query = "Select * from magasin where codepostal = :codepostal";
			try{
				$stmt = $b->prepare($query);
				$a= $stmt->execute(array(':codepostal'=>$codepostal));
			}catch (PDOException $e){
				return null;
			}
			$res = array();
			$tab = $stmt->fetch();
			$mag = new Magasin();
			$mag->id_magasin = $tab['id_magasin'];
			$mag->nom_magasin = $tab['nom_magasin'];
			$mag->numero = $tab['numero'];
			$mag->rue = $tab['rue'];
			$mag->ville = $tab['ville'];
			$mag->codepostal = $tab['codepostal'];
			$mag->description = $tab['description'];
			$mag->tel_magasin = $tab['tel_magasin'];
			$mag->id_commercant = $tab['d_commercant'];
			return $mag;
		}
		
	}

?>