<?php
	header( 'content-type: text/html; charset=utf-8' );
	
	include_once 'Client.php';
	
	//gère l'inscription dans la base de données
	if(isset($_POST) && isset($_POST['login']) && isset($_POST['mdp']) && isset($_POST['prenom']) 
	&& isset($_POST['nom']) && isset($_POST['email'])){			
		
		$user = new Client();
				
		$user->login_client = $_POST['login'];
		$user->mdp_client = $_POST['mdp'];
		$user->prenom_client = $_POST['prenom'];
		$user->nom_client = $_POST['nom'];
		$user->mail_client = $_POST['email'];
				
		$user->insert();
				
		header('Location: PromoSphere.php?a=Connexion');	
	}
	
?>