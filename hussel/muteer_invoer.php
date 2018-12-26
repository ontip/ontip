<?php 
header("Location: ".$_SERVER['HTTP_REFERER']);
ob_start();

//// Database gegevens. 

include ('mysql.php');

//echo "SELECT count(*)as Aantal From hussel_score  where Vereniging_id = ".$vereniging_id." and Voor1 > 0 and Tegen1 > 0 and  Datum = '".$datum."'  ";


$sql_score      = mysql_query("SELECT count(*) as Aantal From hussel_score  where Vereniging_id = ".$vereniging_id." and Voor1 > 0 and Tegen1 > 0 and  Datum = '".$datum."'  ")     or die(' Fout in select aantal');  
$result = mysql_fetch_array( $sql_score );
$aantal = $result['Aantal'];

if ($aantal > 0  ){
	
	// invoer via icoon	als schakelaar
	if (isset($_GET['blokkeer_invoer'])){
  
  
  if ($blokkeer_invoer =='On') {
  	 $blokkeer_invoer = 'Off';
  	} else {
  		$blokkeer_invoer = 'On';
  	}
   
} else { 
   $blokkeer_invoer  = $_POST['blokkeer_invoer'];
}   
   
 
 
 
   
  
  if ($blokkeer_invoer =='On') {     
    $query   = "UPDATE hussel_config SET Waarde = 'On'   where  Vereniging_id = ".$vereniging_id." and Variabele = 'blokkeer_invoer'";   
   //echo $query;
   
    mysql_query($query) or die(' Fout in deactiveren invoer');  
}

else {
    $query   = "UPDATE hussel_config SET Waarde = 'Off'   where  Vereniging_id = ".$vereniging_id." and Variabele = 'blokkeer_invoer'";   
  //echo $query;
   
    mysql_query($query) or die(' Fout in activeren invoer');  
  
}

} // aantal 0
ob_end_flush();
?> 
