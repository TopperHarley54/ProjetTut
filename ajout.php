<?php
include_once "Base.php";
$b = Base::getConnection();
    

$nom = isset($_POST['nom']) ? $_POST['nom'] : '';
$prix = isset($_POST['prix']) ? $_POST['prix'] : '';
$promotion = isset($_POST['promotion']) ? $_POST['promotion'] : '';
$couleur = isset($_POST['couleur']) ? $_POST['couleur'] : '';
$taille = isset($_POST['taille']) ? $_POST['taille'] : '';
$description = isset($_POST['description']) ? $_POST['description'] : '';
$nomMag = isset($_POST['magasin']) ? $_POST['magasin'] : '';
$nomVille = isset($_POST['ville']) ? $_POST['ville'] : '';

$flag['code']=0;

$query = $b->prepare("insert into article(nom_article, prix, prix_promo, couleur, taille_dispo, description, ville, magasin) values ('$nom' ,'$prix','$promotion','$couleur','$taille','$description','$nomVille','$nomMag') ");
$dbres = $query->execute();
print(json_encode($flag));

 //mysql_close();

?>
