<?php
include_once 'Controller.php' ; 

$c = new Controller() ;  
$c->callAction( $_GET );
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">


<script language="JavaScript">
<!--
    var txt = "Promo Sphère - Buy Them All  -  ";
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
<script type="text/javascript" src="js/bootstrap.js></script>
		<script type="text/javascript">
			var slider = {
					positionIni: 0,
					currentPos: 0,
					tailleNavBar: 170,
					_initialize: function () {
						positionIni = 0;
						tailleNa
						this.listeners();
						return this;
					},
					listeners: function () {
						var me = this;
						$(#caseSli).click(me.move);
					},
					move: function () {
						var me = sliderInstance;
						if (me.currentPos == 0) {
							$('#navbar').animate({ 'margin-left': -(me.tailleNavBar) }, 1000);
							me.currentPos = 1;
						} else {
							$('#navbar').animate({ 'margin-left': 0 }, 1000);
							me.currentPos = 0;
						}
					}
			}
			var sliderInstance = slider._initialize();
		</script>
</html>


