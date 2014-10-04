<?php

	include_once 'Client.php';
	include_once 'Affichage.php';
	include_once 'Commercant.php';
	
	class Connexion {
		
		public static function Authentification($log, $pass) {
			$c = new Client();
			$c = Client::findByLogin($log);
			if( Client::findByLogin($log)->mail_client != null ){
				$c = new Client();
				$c = Client::findByLogin($log);
				if($c->mdp_client==$pass){
					Connexion::charger($c);
				}else{
					header('Location: PromoSphere.php?a=Connexion');
				}
			}else if(Commercant::findById($log) != null){
				$c = new Commercant();
				$c = Commercant::findByLogin($log);
				if($c->mdp_com == $pass){
					Connexion::charger($c);
				}else{
					header('Location: PromoSphere.php?a=Connexion');
				}
			}
		}
		
		public static function charger($utilisateur) {			
			session_start();
			/*if($utilisateur->id_client != null){
				$profil = array('userid'=>$utilisateur->id_client, 'login'=>$utilisateur->login_client, 'prenom'=>$utilisateur->prenom_client);
			}else{
				$profil = array('userid'=>$utilisateur->id_com, 'login'=>$utilisateur->login_com, 'prenom'=>$utilisateur->prenom_com);
			}*/
			
			$profil = array('userid'=>$utilisateur->id_client, 'login'=>$utilisateur->login_client, 'prenom'=>$utilisateur->prenom_client);
			
			$_SESSION['profil']=$profil;
			header('Location: PromoSphere.php?a=accueil');
			exit();
		}
	}
	
	if(isset($_POST['login']) && isset($_POST['mdp'])){
		Connexion::Authentification($_POST['login'],$_POST['mdp']);
	}else{
		header('Location: PromoSphere.php?a=Connexion');
	}
	
?>