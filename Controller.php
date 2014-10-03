<?php

	include_once 'Affichage.php';
	include_once 'liste.php';
	include_once 'Article.php';

class Controller {

private $a;
private $id;

public static function callAction(){
    
    if (isset($_GET['a'])){
        $a=$_GET['a'];
    }else{
        $a="accueil";
         }
    
    if(isset($_GET['id'])){
        $this->id=$_GET['id'];
    }
	
	Affichage::BarreNav();
    
    switch($a){
        case("accueil"):
            Affichage::Accueil();
            break;
			
		case("Connexion"):
			Affichage::Connexion();
			break;
			
		case("Deconnexion"):
			Affichage::Deconnexion();
			break;
			
		case("Inscription"):
			Affichage::Inscription();
			break;
            
        case("addLs"):
			if(isset($_SESSION['profil'])){
				Affichage::AjoutListe($_GET['idart']);
				header('Location: PromoSphere.php?a=AfficherPanier');
			}else{
				echo 'vous devez vous connecter pour ajouter un élèment a votre liste';
			}
            break;
			
		case("supLs"):
			if(isset($_SESSION['profil'])){
				liste::supprime($_GET['idart'],$_SESSION['profil']['userid']);
				header('Location: PromoSphere.php?a=AfficherPanier');
			}else{
				echo 'vous devez vous connecter pour ajouter un élèment a votre liste';
			}
			break;
            
        case("modifProm"):
            Affichage::ModifPromo(Article::findById($_GET['idart']));
            break;
            
        case("supProm"):
            Article::EnleverPromo($_GET['idart']);
			header('Location: PromoSphere.php?a=toutePromo');
            break;
          
        case("SignalerProm"):
            Affichage::NouvelPromo();
            break;
        
        case("toutePromo"):
            Affichage::AfiAll();
            break;
            
        case("AfficherPanier"):
			if(isset($_SESSION['profil'])){
				Affichage::AfiLs();
			}else{
				echo 'vous devez vous connecter pour accéder a votre liste';
			}
            break;
    }



}

}


?>