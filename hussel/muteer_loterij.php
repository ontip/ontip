<?php 
header("Location: ".$_SERVER['HTTP_REFERER']);
ob_start();

//// Database gegevens. 

include ('mysqli.php');

$voorgeloot  = $_POST['voorgeloot'];



/// Deactiveer
if ($voorgeloot == 0) {     
		
	 
   $query   = "UPDATE hussel_config SET Waarde = 'Off'   where  Vereniging_id = ".$vereniging_id." and Variabele = 'voorgeloot'";   
   //echo $query;
   
    mysqli_query($con,$query) or die(' Fout in deactiveren controle 13');  
}

else {
	
	 $query="UPDATE hussel_config SET Waarde = 'On'   where  Vereniging_id = ".$vereniging_id." and Variabele = 'voorgeloot'";   
	 // echo $query;
    mysqli_query($con,$query) or die(' Fout in activeren voorgeloot');  
 	
};//

ob_end_flush();
?> 
