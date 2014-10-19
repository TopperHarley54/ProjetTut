<?php
include_once 'Base.php';

$b = Base::getConnection();


	$req = $b->prepare('select count(login_client) as nombre FROM client WHERE login_client= :log');
	$req->execute(array(':log'=>$_GET['pseudo']));
	
	$req2 = $b->prepare('select count(login_commercant) as nombre FROM commercant WHERE login_commercant= :log');
	$req2->execute(array(':log'=>$_GET['pseudo']));


$result = $req->fetch();
$result2 = $req2->fetch();
 
if ($result['nombre'] + $result2['nombre'] >= 1){
  echo '1';
}else{
  echo '0';
}
 
?>