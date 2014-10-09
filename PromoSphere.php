<?php
include_once 'Controller.php' ; 
session_start();

$c = new Controller() ;  
$c->callAction( $_GET );
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">


<script language="JavaScript">
<!--
    var txt = "Promo Sphère - Spot Them All  -  ";
var espera=200;
var refresco=null;
function rotulo_title() {
        document.title=txt;
        txt=txt.substring(1,txt.length)+txt.charAt(0);
        refresco=setTimeout("rotulo_title()",espera);}
rotulo_title();
// -->
</script>

<head>
<link href="css/bootstrap.css" rel="stylesheet">
<link rel="stylesheet" href="style.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Promo Sphère - Buy Them All</title>
</head>
<body>
</body>

<script src="/bootstrap/js/bootstrap-collapse.js"></script>
<script src="/bootstrap/js/bootstrap-transition.js"></script>
		
</html>


