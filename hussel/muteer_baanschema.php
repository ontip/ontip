<?php 
header("Location: ".$_SERVER['HTTP_REFERER']);
ob_start();

//// Database gegevens. 

include ('mysql.php');

$min_aantal    = $_POST['min_aantal'];
$baan_schema   = $_POST['baan_schema'];

/// Deactiveer
if ($baan_schema == 0) {     
	
	 
   $query   = "UPDATE hussel_config SET Waarde = 'Off' , Parameters ='".$min_aantal."'   where  Vereniging_id = ".$vereniging_id." and Variabele = 'baan_schemas'";   
//   echo $query;
   
    mysql_query($query) or die(' Fout in deactiveren baanschemas');  
}

else {
	
	 $query="UPDATE hussel_config SET Waarde = 'On' , Parameters ='".$min_aantal."'    where  Vereniging_id = ".$vereniging_id." and Variabele = 'baan_schemas'";   
//	  echo $query;
    mysql_query($query) or die(' Fout in activeren baanschemas ');  
 	
}



ob_end_flush();
?> 
