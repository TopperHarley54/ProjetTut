<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<?php

	include_once "Article.php";
	
		$a = new article();
		
		if(isset($_POST['cbarre'])){
			$a->code_barre = $_POST['cbarre'];
		}
		if(isset($_POST['narticle'])){
			$a->nom_article = $_POST['narticle'];
		}
		if(isset($_POST['prix'])){
			$a->prix = $_POST['prix'];
		}
		if(isset($_POST['prixprom'])){
			$a->prix_promo = $_POST['prixprom'];
		}
		if(isset($_POST['desc'])){
			$a->description = $_POST['desc'];
		}
		if(isset($_POST['taille'])){
			if($_FILES['avatar']['name'] != null){
					$dossier = 'image/';
					
					$info = new SplFileInfo($_FILES['avatar']['name']);
					$ext = $info->getExtension();
					$file =Article::Nbimage().'.'.$ext;
					$_FILES['avatar']['name'] = $file;
					
					$fichier = basename($_FILES['avatar']['name']);
					if(move_uploaded_file($_FILES['avatar']['tmp_name'], $dossier . $fichier)) {
						$a->photo = $dossier . $_FILES['avatar']['name'];
		
					}else{ 
						echo 'Echec de l\'upload !';
					}			
			
			}
		}
		if(isset($_POST['taille'])){
			$a->taille_dispo = $_POST['taille'];
		}
		if(isset($_POST['couleur'])){
			$a->couleur = $_POST['couleur'];
		}
		if(isset($_POST['datedeb'])){
			$a->datedebut = $_POST['datedeb'];
		}
		if(isset($_POST['datefin'])){
			$a->datefin = $_POST['datefin'];
		}
		echo $a->id_article;
		$a->insert();
		//header('Location: PromoSphere.php?a=toutePromo');	
	

?>