<?php

	include_once "Base.php";
	include_once "Article.php";
	
	class Liste {
	
		private $id_client;
		private $id_article;
		
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
		
		public function insert(){
			$b = Base::getConnection();
			$query = "INSERT INTO liste values ($this->id_client,$this->id_article)";
			echo $query;
			$res = $b->query($query);
		}
		
		public static function findArtByIdCli($idcli) {
			$c = Base::getConnection();
			$query = $c->prepare("select * from liste where id_client =". $idcli) ;
			$dbres = $query->execute();
			$result = $query->fetchAll(PDO::FETCH_CLASS,"Article");
			return $result;
		}
		
		public static function countArtById($idcli){
			$b = Base::getConnection();
			$req = $b->prepare('SELECT COUNT(id_article) as nombre FROM liste WHERE id_client=:idcli');
			$req->execute( array('idcli'=>$idcli) );
			$result=$req->fetch();
			return $result;
		}
		
		public static function ajoute($art,$cli){
			$count = liste::countArtById($cli);
			if($count['nombre'] == 0){
				$l = new liste();
				$l->id_article = $art;
				$l->id_client = $cli;
				$l->insert();		
			}else{
				echo 'déjà dans votre liste';
			}
		}
		
		public static function supprime($art,$cli){
			$b = Base::getConnection();
			$req = $b->prepare('DELETE FROM liste WHERE id_client=:idcli AND id_article=:idart');
			$req->execute(array('idcli'=>$cli, 'idart'=>$art));
			$result=$req->fetch();
			
			return $result;
		}
	}

		