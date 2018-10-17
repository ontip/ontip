<?php
ob_start();

$competitie_id    = $_POST['competitie_id'];
setcookie ("competitie", $competitie_id , time() +180000);
	  
	  
echo 	  $competitie_id;
	  
header ( "Location: index.php"  ); 
ob_end_flush();
?>


