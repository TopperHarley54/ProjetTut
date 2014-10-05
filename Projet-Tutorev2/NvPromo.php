<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<?php

	include_once "Article.php";
	
		$a = new article();
		
		if(isset($_POST['cbarre'])){
			$a->id_article = $_POST['cbarre'];
			echo $_POST['cbarre'];
		}
		if(isset($_POST['narticle'])){
			$a->nom_article = $_POST['narticle'];
			echo $_POST['narticle'];
		}
		if(isset($_POST['prix'])){
			$a->prix = $_POST['prix'];
			echo $_POST['prix'];
		}
		if(isset($_POST['prixprom'])){
			$a->prix_promo = $_POST['prixprom'];
			echo $_POST['prixprom'];
		}
		if(isset($_POST['desc'])){
			$a->description = $_POST['desc'];
			echo $_POST['desc'];
		}
		if(isset($_POST['image'])){
			$a->photo = $_POST['image'];
		}
		if(isset($_POST['taille'])){
			$a->taille_dispo = $_POST['taille'];
			echo $_POST['taille'];
		}
		if(isset($_POST['datedeb'])){
			$a->datedebut = $_POST['datedeb'];
			echo $_POST['datedeb'];
		}
		if(isset($_POST['datefin'])){
			$a->datefin = $_POST['datefin'];
			echo $_POST['datefin'];
		}
		
		$a->insert();
		//header('Location: PromoSphere.php?a=toutePromo');	
	

?>