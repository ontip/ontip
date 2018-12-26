<?php 
header("Location: ".$_SERVER['HTTP_REFERER']);
ob_start();

//// Database gegevens. 

include ('mysql.php');

$voorgeloot  = $_POST['voorgeloot'];
$toernooi    = $_POST['toernooi'];


/// Deactiveer
if ($voorgeloot == 0) {     
		
	 
   $query   = "UPDATE hussel_config SET Waarde = 'Off'   where  Vereniging_id = ".$vereniging_id." and Variabele = 'voorgeloot'";   
   //echo $query;
   
    mysql_query($query) or die(' Fout in deactiveren vooorgeloot');  
}

else {
	
	 $query="UPDATE hussel_config SET Waarde = 'On'  , Parameters = '".$toernooi."'  where  Vereniging_id = ".$vereniging_id." and Variabele = 'voorgeloot'";   
	 // echo $query;
    mysql_query($query) or die(' Fout in activeren voorgeloot');  
 	
};//

ob_end_flush();
?> 
