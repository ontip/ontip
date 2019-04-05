<?php 
header("Location: ".$_SERVER['HTTP_REFERER']);
ob_start();

//// Database gegevens. 

include ('mysqli.php');

if (isset($_GET['controle_13'])){ 
		
	$sql_config     = mysqli_query($con,"SELECT Waarde  From hussel_config where Vereniging_id = ".$vereniging_id." and Variabele ='controle_13' ")     or die(' Fout in select config');  
  $result         = mysqli_fetch_array( $sql_config );
  $controle_13    = $result['Waarde'];

if ($controle_13 == 'Auto') {
	//  auto = Aan en automatische kontrole
	$_controle_13 = 'On' ;
}

if ($controle_13 == 'On') {
	//  On = Alleen kontrole op 13
	$_controle_13 = 'Off' ;
}

if ($controle_13 == 'Off') {
	//  Off = mag ook afwijkend van 13 zijn
$_controle_13 = 'Auto' ;
}
  
  
  
  
} else { 	
  $_controle_13  = $_POST['controle_13'];
}

 
   $query   = "UPDATE hussel_config SET Waarde = '".$_controle_13."'  where  Vereniging_id = ".$vereniging_id." and Variabele = 'controle_13'";   
   mysqli_query($con,$query) or die ('Fout in update hussel_config vooor controle 13 ');   	 		

ob_end_flush();
?> 
