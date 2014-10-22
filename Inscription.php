

<?php
	header( 'content-type: text/html; charset=utf-8' );
	
	include_once 'Client.php';
	include_once 'Commercant.php';
	
	//gère l'inscription dans la base de données
	if(isset($_POST)){		
		echo '1';
				
		if ($_POST['type']=='particulier'){
			$user = new Client();
			$user->login_client = str_replace("'","\'",$_POST['pseudo']);
			$user->mdp_client = str_replace("'","\'",$_POST['mdp']);
			$user->prenom_client = str_replace("'","\'",$_POST['prenom']);
			$user->nom_client = str_replace("'","\'",$_POST['nom']);
			$user->mail_client = str_replace("'","\'",$_POST['email']);
		}else if($_POST['type']=='commercant'){
			$user = new Commercant();
			$user->login_com = str_replace("'","\'",$_POST['pseudo']);
			$user->mdp_com = str_replace("'","\'",$_POST['mdp']);
			$user->nom_com = str_replace("'","\'",$_POST['nom']);
			$user->prenom_com = str_replace("'","\'",$_POST['prenom']);
			$user->mail_com = str_replace("'","\'",$_POST['email']);
		}
				
		$user->insert();
				
		
	}
	//header('Location: PromoSphere.php?a=Connexion');	
?>