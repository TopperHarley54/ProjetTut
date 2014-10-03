<?php

	include_once "Base.php";

	class Statut{
		
		private $id_statut;
		
		private $libelle;
		
		private $pourcentage;
		
		private $date_debut;
		
		private $date_fin;
		
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
			$query = "INSERT INTO statut values ('', '$this->libelle', '$this->pourcentage', '$this->date_debut', '$this->date_fin')";
			$res = $b->query($query);
			$lastid = $b->lastInsertId();
			$this->id = $lastid;
		}
		
		
		public function update($libelle, $pourcentage, $date_debut, $date_fin) {
		$b = Base::getConnection();
		$save_query = "update statut set libelle=:libel, pourcentage=:pourcen, date_debut=:date_deb, date_fin=:date_f where id_statut = :id_stat";
			try{
				$stmt = $b->prepare($save_query);
				$a = $stmt->execute(array(':libel'=>$libelle,':pourcen'=>$pourcentage, ':date_deb'=>$date_debut, ':date_f'=>$date_fin, ':id_stat'=>$this->id_statut));
				return $a;
			}catch (PDOException $e){
				return null;
			}
		}
		
		public function delete() {
			$db = Base::getConnection();	
			$sth = $db->prepare('DELETE FROM statut WHERE id_statut = :id');
			$a = $sth->execute(array(':id'=>$this->id_statut));
			return $a;
			throw new Exception("méthode delete() non implantée");
		}
		
		public static function findById($id) {
			$b = Base::getConnection();
			$query = "Select * from statut where id_statut = :id";
			try{
				$stmt = $b->prepare($query);
				$a= $stmt->execute(array(':id'=>$id));
			}catch (PDOException $e){
				return null;
			}
			$res = array();
			$tab = $stmt->fetch();
			$stat = new Statut();
			$stat->id_statut = $tab['id_statut'];
			$stat->libelle = $tab['libelle'];
			$stat->pourcentage = $tab['pourcentage'];
			$stat->date_debut = $tab['date_debut'];
			$stat->date_fin = $tab['date_fin'];
			return $stat;
		}
		
		public static function findByPourcen($pourcen) {
			$b = Base::getConnection();
			$query = "Select * from statut where pourcentage = :pour";
			try{
				$stmt = $b->prepare($query);
				$a= $stmt->execute(array(':pour'=>$pourcen));
			}catch (PDOException $e){
				return null;
			}
			$res = array();
			$tab = $stmt->fetch();
			$stat = new Statut();
			$stat->id_statut = $tab['id_statut'];
			$stat->libelle = $tab['libelle'];
			$stat->pourcentage = $tab['pourcentage'];
			$stat->date_debut = $tab['date_debut'];
			$stat->date_fin = $tab['date_fin'];
			return $stat;
		}
	
		public static function findByDatefin($datefin) {
			$b = Base::getConnection();
			$query = "Select * from statut where date_fin = :datef";
			try{
				$stmt = $b->prepare($query);
				$a= $stmt->execute(array(':datef'=>$datefin));
			}catch (PDOException $e){
				return null;
			}
			$res = array();
			$tab = $stmt->fetch();
			$stat = new Statut();
			$stat->id_statut = $tab['id_statut'];
			$stat->libelle = $tab['libelle'];
			$stat->pourcentage = $tab['pourcentage'];
			$stat->date_debut = $tab['date_debut'];
			$stat->date_fin = $tab['date_fin'];
			return $stat;
		}
		
	}

?>