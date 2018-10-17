<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/Basis.dwt" codeOutsideHTMLIsLocked="false" -->
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	</head>
	<?php 
// Database gegevens. 
include('mysql.php');


setlocale(LC_ALL, 'nl_NL');

$sql        = mysql_query("SELECT Licentie, Naam, Vereniging from speler_licenties where Licentie= '41418' ");
while($row = mysql_fetch_array( $sql )) {

$licentie   =   $row['Licentie'];
$naam       =   $row['Naam'];
$vereniging =   $row['Vereniging'];


// Diacrieten omzetten in vereniging en naam

// update 

// Als er nog geen conversie is geweest, dan uitvoeren

if (strpos($naam, '&#') == 0 and strpos($vereniging, '&#') == 0){
	echo $vereniging. "<br>";
	
	
$update = "update  speler_licenties set Naam       = '".htmlentities($naam,ENT_QUOTES, 'UTF-8')."',
                                        Vereniging = '".htmlentities($vereniging,ENT_QUOTES, 'UTF-8') ."',
                                        Laatst     = NOW()
                                  where Licentie   = '".$licentie."' ";
                                  

echo $update. "<br>";
mysql_query($update) or die ('fout in update');; 
} // end if strpos

}// end while record

echo 'Alle '.$count.' records zijn verwerkt. ';


?> 