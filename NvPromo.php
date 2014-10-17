<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<?php

	session_start();
	include_once "Article.php";
	include_once "Magasin.php";
	
		$a = new article();
		
		if(isset($_POST['cbarre'])){
			$a->code_barre = str_replace("'","\'",$_POST['cbarre']);
			
		}
		if(isset($_POST['narticle'])){
			$a->nom_article = str_replace("'","\'",$_POST['narticle']);
		}
		if(isset($_POST['prix'])){
			$a->prix = str_replace("'","\'",$_POST['prix']);
		}
		if(isset($_POST['prixprom'])){
			$a->prix_promo = str_replace("'","\'",$_POST['prixprom']);
		}
		if(isset($_POST['desc'])){
			$a->description = str_replace("'","\'",$_POST['desc']);
		}
		if(isset($_FILES['photo']['name'])){
					$dossier = 'image/';
					
					$info = new SplFileInfo($_FILES['photo']['name']);
					$ext = $info->getExtension();
					$file =Article::Nbimage().'.'.$ext;
					$_FILES['photo']['name'] = $file;
					
					$fichier = basename($_FILES['photo']['name']);
					if(move_uploaded_file($_FILES['photo']['tmp_name'], $dossier . $file)) {
						$a->photo = $dossier . $_FILES['photo']['name'];
		
					}else{ 
						echo 'Echec de l\'upload !';
					}
		}
		if(isset($_POST['taille'])){
			$a->taille_dispo = str_replace("'","\'",$_POST['taille']);
		}
		if(isset($_POST['couleur'])){
			$a->couleur = str_replace("'","\'",$_POST['couleur']);
		}
		if(isset($_POST['datedeb'])){
			$a->datedebut = $_POST['datedeb'];
		}
		if(isset($_POST['datefin'])){
			$a->datefin = $_POST['datefin'];
		}
		if(isset($_SESSION['profil']['cli'])){
			$a->id_client = $_SESSION['profil']['userid'];
		}
		if(isset($_SESSION['profil']['com'])){
			$m = Magasin::findByNom($_POST['magasin']);
			$a->id_magasin = $m->id_magasin;
		}
		$a->insert();
		header('Location: PromoSphere.php?a=toutePromo');	
	

?>