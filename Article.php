<?php

	include_once "Base.php";
	
	class article {
		
		private $id_article;
		
		private $code_barre;
		
		private $nom_article;
		
		private $prix;
		
		private $prix_promo;
		
		private $description;
		
		private $photo;
		
		private $taille_dispo;
		
		private $couleur;
		
		private $datedebut;
		
		private $datefin;
		
		private $id_client;
		
		private $id_magasin;
		
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
			if(isset($_SESSION['profil']['com'])){
				$query = "INSERT INTO article(code_barre, nom_article, prix, prix_promo, description, photo, taille_dispo, couleur, datedebut,datefin,id_magasin) VALUES ('$this->code_barre','$this->nom_article',$this->prix,$this->prix_promo,'$this->description','$this->photo','$this->taille_dispo','$this->couleur','$this->datedebut','$this->datefin',$this->id_magasin)";
			}else{
				$query = "INSERT INTO article(code_barre, nom_article, prix, prix_promo, description, photo, taille_dispo, couleur, datedebut,datefin,id_client) VALUES ('$this->code_barre','$this->nom_article',$this->prix,$this->prix_promo,'$this->description','$this->photo','$this->taille_dispo','$this->couleur','$this->datedebut','$this->datefin',$this->id_client)";
			}
			$res = $b->query($query);
			echo $query;
			$lastid = $b->lastInsertId();
			$this->id_article = $lastid;
		}
		
		public function update($code, $nom, $prix, $pripromo, $descri, $phot, $taille, $coul, $idstat) {
			$b = Base::getConnection();
			$save_query = "update article set code_barre=:code, nom_article=:nom, prix=:prix, prix_promo=:pripromo, description=:descri, photo=:phot, taille_dispo=:taille, couleur=:coulwhere id_article=:id_art";
			try{
				$stmt = $b->prepare($save_query);
				$a = $stmt->execute(array(':code'=>$code,':nom'=>$nom, ':prix'=>$prix, ':pripromo'=>$pripromo, ':description'=>$descri, ':phot'=>$phot, ':taille'=>$taille, ':coul'=>$coul, ':idstat'=>$idstat, ':id_art'=>$this->id_article));
				return $a;
			}catch (PDOException $e){
				return null;
			}
		}
		
		public function delete() {
			$db = Base::getConnection();	
			$sth = $db->prepare('DELETE FROM article WHERE id_article = :id_art');
			$a = $sth->execute(array(':id_art'=>$this->id_article));
			return $a;
			throw new Exception("méthode delete() non implantée");
		}
		
		public static function findById($id) {
			$b = Base::getConnection();
			$query = "Select * from article where id_article = :id";
			try{
				$stmt = $b->prepare($query);
				$a= $stmt->execute(array(':id'=>$id));
			}catch (PDOException $e){
				return null;
			}
			$res = array();
			$tab = $stmt->fetch();
			$art = new Article();
			$art->id_article = $tab['id_article'];
			$art->code_barre = $tab['code_barre'];
			$art->nom_article = $tab['nom_article'];
			$art->prix = $tab['prix'];
			$art->prix_promo = $tab['prix_promo'];
			$art->description = $tab['description'];
			$art->photo = $tab['photo'];
			$art->taille_dispo = $tab['taille_dispo'];
			$art->couleur = $tab['couleur'];
			$art->datedebut = $tab['datedebut'];
			$art->datefin = $tab['datefin'];
			$art->id_magasin = $tab['id_magasin'];
			$art->id_client = $tab['id_client'];
			
			return $art;
		}
		
		public static function findByCode($code) {
			$b = Base::getConnection();
			$query = "Select * from article where code_barre = :code";
			try{
				$stmt = $b->prepare($query);
				$a= $stmt->execute(array(':code'=>$code));
			}catch (PDOException $e){
				return null;
			}
			$res = array();
			$tab = $stmt->fetch();
			$art = new Article();
			$art->id_article = $tab['id_article'];
			$art->code_barre = $tab['code_barre'];
			$art->nom_article = $tab['nom_article'];
			$art->prix = $tab['prix'];
			$art->prix_promo = $tab['prix_promo'];
			$art->description = $tab['description'];
			$art->photo = $tab['photo'];
			$art->taille_dispo = $tab['taille_dispo'];
			$art->couleur = $tab['couleur'];
			$art->datedebut = $tab['datedebut'];
			$art->datefin = $tab['datefin'];
			$art->id_magasin = $tab['id_magasin'];
			$art->id_client = $tab['id_client'];
			return $mag;
		}
		
		public static function findByNom($nom) {
			$b = Base::getConnection();
			$query = "Select * from article where nom_article = :nom";
			try{
				$stmt = $b->prepare($query);
				$a= $stmt->execute(array(':nom'=>$nom));
			}catch (PDOException $e){
				return null;
			}
			$res = array();
			$tab = $stmt->fetch();
			$art = new Article();
			$art->id_article = $tab['id_article'];
			$art->code_barre = $tab['code_barre'];
			$art->nom_article = $tab['nom_article'];
			$art->prix = $tab['prix'];
			$art->prix_promo = $tab['prix_promo'];
			$art->description = $tab['description'];
			$art->photo = $tab['photo'];
			$art->taille_dispo = $tab['taille_dispo'];
			$art->couleur = $tab['couleur'];
			$art->datedebut = $tab['datedebut'];
			$art->datefin = $tab['datefin'];
			$art->id_magasin = $tab['id_magasin'];
			$art->id_client = $tab['id_client'];
			return $mag;
		}
		
		public static function findByPrixpromo($prixpromo) {
			$b = Base::getConnection();
			$query = "Select * from article where prix_promo = :prixpromo";
			try{
				$stmt = $b->prepare($query);
				$a= $stmt->execute(array(':prixpromo'=>$prixpromo));
			}catch (PDOException $e){
				return null;
			}
			$res = array();
			$tab = $stmt->fetch();
			$art = new Article();
			$art->id_article = $tab['id_article'];
			$art->code_barre = $tab['code_barre'];
			$art->nom_article = $tab['nom_article'];
			$art->prix = $tab['prix'];
			$art->prix_promo = $tab['prix_promo'];
			$art->description = $tab['description'];
			$art->photo = $tab['photo'];
			$art->taille_dispo = $tab['taille_dispo'];
			$art->couleur = $tab['couleur'];
			$art->datedebut = $tab['datedebut'];
			$art->datefin = $tab['datefin'];
			$art->id_magasin = $tab['id_magasin'];
			$art->id_client = $tab['id_client'];
			return $mag;
		}
		
		public static function findByTaille($taille) {
			$b = Base::getConnection();
			$query = "Select * from article where taille_dispo = :taille";
			try{
				$stmt = $b->prepare($query);
				$a= $stmt->execute(array(':taille'=>$taille));
			}catch (PDOException $e){
				return null;
			}
			$res = array();
			$tab = $stmt->fetch();
			$art = new Article();
			$art->id_article = $tab['id_article'];
			$art->code_barre = $tab['code_barre'];
			$art->nom_article = $tab['nom_article'];
			$art->prix = $tab['prix'];
			$art->prix_promo = $tab['prix_promo'];
			$art->description = $tab['description'];
			$art->photo = $tab['photo'];
			$art->taille_dispo = $tab['taille_dispo'];
			$art->couleur = $tab['couleur'];
			$art->datedebut = $tab['datedebut'];
			$art->datefin = $tab['datefin'];
			$art->id_magasin = $tab['id_magasin'];
			$art->id_client = $tab['id_client'];
			
			return $mag;
		}
		
		public static function findByCouleur($couleur) {
			$b = Base::getConnection();
			$query = "Select * from article where couleur = :couleur";
			try{
				$stmt = $b->prepare($query);
				$a= $stmt->execute(array(':couleur'=>$couleur));
			}catch (PDOException $e){
				return null;
			}
			$res = array();
			$tab = $stmt->fetch();
			$art = new Article();
			$art->id_article = $tab['id_article'];
			$art->code_barre = $tab['code_barre'];
			$art->nom_article = $tab['nom_article'];
			$art->prix = $tab['prix'];
			$art->prix_promo = $tab['prix_promo'];
			$art->description = $tab['description'];
			$art->photo = $tab['photo'];
			$art->taille_dispo = $tab['taille_dispo'];
			$art->couleur = $tab['couleur'];
			$art->datedebut = $tab['datedebut'];
			$art->datefin = $tab['datefin'];
			$art->id_magasin = $tab['id_magasin'];
			$art->id_client = $tab['id_client'];
			return $mag;
		}
		
		public static function findAll() {
		
			$c = Base::getConnection();
			$query = $c->prepare("select * from article order by id_article DESC") ;
			$dbres = $query->execute();
			$result = $query->fetchAll(PDO::FETCH_CLASS,"article");
			return $result;
		}
		
		public static function EnleverPromo($id){
			$b = Base::getConnection();
			$req = $b->prepare('Delete from article where id_article = :id');
			$req->execute(array('id'=>$id));
			$result=$req->fetch();
			
			return $result;
		}
		
		public static function Nbimage(){
			$b = Base::getConnection();
			$query = "Select * from compteur";
			try{
				$stmt = $b->prepare($query);
				$a= $stmt->execute();
			}catch (PDOException $e){
				return null;
			}
			$res = array();
			$tab = $stmt->fetch();
			$compteur = $tab['nbimage'];
			$temp = $compteur + 1;
			
			$b = Base::getConnection();
			$req = $b->prepare("update compteur set nbimage = :temp where 1");
			$req->execute(array('temp'=>$temp));
			$result=$req->fetch();
			
			return $compteur;
		}		
		
		public static function LastInsert(){
			$b = Base::getConnection();
			$query ="SELECT * FROM article a1 WHERE a1.id_article=(SELECT MAX(a2.id_article) FROM article a2)";
			try{
				$stmt = $b->prepare($query);
				$a= $stmt->execute(array());
			}catch (PDOException $e){
				return null;
			}
			$res = array();
			$tab = $stmt->fetch();
			$art = new Article();
			$art->id_article = $tab['id_article'];
			$art->code_barre = $tab['code_barre'];
			$art->nom_article = $tab['nom_article'];
			$art->prix = $tab['prix'];
			$art->prix_promo = $tab['prix_promo'];
			$art->description = $tab['description'];
			$art->photo = $tab['photo'];
			$art->taille_dispo = $tab['taille_dispo'];
			$art->couleur = $tab['couleur'];
			$art->datedebut = $tab['datedebut'];
			$art->datefin = $tab['datefin'];
			$art->id_magasin = $tab['id_magasin'];
			$art->id_client = $tab['id_client'];	
			return $art;
		}
	}
?>
