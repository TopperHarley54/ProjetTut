<?php
	header( 'content-type: text/html; charset=utf-8' );
	
	include_once 'Client.php';
	include_once 'Commercant.php';
	
	//gère l'inscription dans la base de données
	if(isset($_POST) && isset($_POST['login']) && isset($_POST['mdp']) && isset($_POST['prenom']) 
	&& isset($_POST['nom']) && isset($_POST['email'])){			
		
		if ($_POST['choix']=='0'){
			$user = new Client();
			$user->login_client = $_POST['login'];
			$user->mdp_client = $_POST['mdp'];
			$user->prenom_client = $_POST['prenom'];
			$user->nom_client = $_POST['nom'];
			$user->mail_client = $_POST['email'];
		}else{
			$user = new Commercant();
			$user->login_com = $_POST['login'];
			$user->mdp_com = $_POST['mdp'];
			$user->nom_com = $_POST['nom'];
			$user->prenom_com = $_POST['prenom'];
			$user->mail_com = $_POST['email'];
		}
		
				
		$user->insert();
				
		header('Location: PromoSphere.php?a=Connexion');	
	}
	
?>