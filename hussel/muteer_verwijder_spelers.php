<?php 
header("Location: ".$_SERVER['HTTP_REFERER']);
ob_start();

//// Database gegevens. 

include ('mysql.php');



if (isset($_POST['verwijder_spelers'])){
		$verwijder_spelers = 'On';
} else {		
 	$verwijder_spelers = 'Off';
}




	 $query="UPDATE hussel_config SET Waarde = '".$verwijder_spelers."'    where  Vereniging_id = ".$vereniging_id." and Variabele = 'verwijderen_spelers'";   
//	  echo $query;
    mysql_query($query) or die(' Fout in update verwijder_spelers');  
 

ob_end_flush();
?> 
