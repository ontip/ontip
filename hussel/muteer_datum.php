<?php 
header("Location: ".$_SERVER['HTTP_REFERER']);
ob_start();

//// Database gegevens. 

include ('mysql.php');

$lock_datum  = $_POST['lock'];
$datum_nieuw = $_POST['datum'];
//echo $lock_datum;
// echo $datum;


/// Deactiveer
if ($lock_datum == 0) {     
		
	 $vandaag = date ('Y')."-".date('m')."-".date('d');
   $query   = "UPDATE hussel_config SET Waarde = 'Off', Parameters = '".$vandaag. "'   where  Vereniging_id = ".$vereniging_id." and Variabele = 'datum_lock'";   
   //echo $query;
   
    mysql_query($query) or die(' Fout in deactiveren datum');  
}

else {
	
	 $query="UPDATE hussel_config SET Waarde = 'On', Parameters = '".$datum_nieuw. "'   where  Vereniging_id = ".$vereniging_id." and Variabele = 'datum_lock'";   
	  echo $query;
    mysql_query($query) or die(' Fout in activeren datum');  
 	
};//

ob_end_flush();
?> 
