<?php

$b = Base::getConnection();
    

$nom = isset($_POST['nom']) ? $_POST['nom'] : '';
$prix = isset($_POST['prix']) ? $_POST['prix'] : '';
$promotion = isset($_POST['promotion']) ? $_POST['promotion'] : '';
$couleur = isset($_POST['couleur']) ? $_POST['couleur'] : '';
$taille = isset($_POST['taille']) ? $_POST['taille'] : '';
$description = isset($_POST['description']) ? $_POST['description'] : ''; 

$flag['code']=0;

$query = $b->prepare("insert into article(nom_article, prix, prix_promo, couleur, taille_dispo, description) values ('$nom' ,'$prix','$promotion','$couleur','$taille','$description') ");
$dbres = $query->execute();
print(json_encode($flag));

mysqli_close($connect);

?>
