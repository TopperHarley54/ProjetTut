<?php

  mysql_connect("sql2.olmpe.in","269lcxat","kevin");
  mysql_select_db("269lcxat");
  $sql=mysql_query("SELECT * FROM '"..$_REQUEST['arti']."' ORDER BY 'id_article'");
  while($row=mysql_fetch_assoc($sql))
  $output[]=$row;
  print(json_encode($output));
  mysql_close();


?>

