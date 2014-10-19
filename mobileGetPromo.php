<?php
include_once "Base.php";

  $b = Base::getConnection();
	$query = $b->prepare("select * from article order by id_article DESC") ;
  $dbres = $query->execute();
  while ($row =$query->fetch()) {
    $output[]=$row;
  }

  print(json_encode($output));
  mysql_close();
?>

