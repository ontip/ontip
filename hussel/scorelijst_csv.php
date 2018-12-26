<?php
$datum = $_GET['datum'];
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"uitslag_".$datum.".csv\"");

// Database gegevens. 
include('mysql.php');

echo "Uitslag ".$datum."\r\n"; 

$score     = mysql_query("SELECT * From hussel_score WHERE Datum = '".$datum."'  and Vereniging_id = ".$vereniging_id."              ORDER BY Winst DESC , Saldo DESC" )       or die('Fout in select');  


	// kop regels
	
	
	if ($voorgeloot == 'On') {
	echo  "Nr;Lot;Naam;Winst;Saldo"."\r\n"; 
    } else {
	echo  "Nr;Naam;Winst;Saldo"."\r\n"; 
}
$i = 1;
// keeps getting the next row until there are no more to get
while($row = mysql_fetch_array( $score )) {
	
	 if ($voorgeloot == 'On') {
    	echo  $i.";".$row['Lot_nummer'].";".$row['Naam'].";".$row['Winst'].";".$row['Saldo']."\r\n"; 
	  } else {
	  	echo  $i.";".$row['Naam'].";".$row['Winst'].";".$row['Saldo']."\r\n"; 
  	}

 $i++;
} // end while
echo "Einde lijst"."\r\n"; 
?>
