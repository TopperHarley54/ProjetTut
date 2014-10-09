<?php

	include_once 'Magasin.php';
	
	$m = new Magasin();

	if(isset($_POST['nom'])){
			$m->nom_magasin = $_POST['nom'];
	}
	if(isset($_POST['num'])){
		$m->numero = $_POST['num'];
	}
	if(isset($_POST['rue'])){
		$m->rue = $_POST['rue'];
	}
	if(isset($_POST['ville'])){
		$m->ville = $_POST['ville'];
	}
	if(isset($_POST['cd'])){
		$m->codepostal = $_POST['cd'];
	}
	if(isset($_POST['desc'])){
		$m->description = $_POST['desc'];
	}
	if(isset($_POST['tel'])){
		$m->tel_magasin = $_POST['tel'];
	}
	
	$m->id_commercant =  $_SESSION['profil']['userid'];
	$m->insert();
?>