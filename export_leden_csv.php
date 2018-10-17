<?php
////  export_leden_csv.php.  (c) Erik Hendrikx 2012 ev
////
////  Programma voor het aanmaken van een csv bestand met de gegevens van de eigen leden. 
////
////  Het inschrijfformulier kan gestart worden met de optie user_select=Yes. Dan komt er een optie op het formulier waarmee de leden van de eigen vereniging
////  kunnen worden geselecteerd uit een popup window om te worden ingevuld in het formulier.
//// 
////  Dit programma maakt een csv bestand aan gevuld m.b.v een selectie uit de tabel speler_licenties. Deze tabel is aangemaakt door programma
////  insert_leden_NJBB.php. Dit programma leest het bestand NJBBLedenS.txt afkomstig van Welp. Deze bevat de gegevens van alle NJBB leden op een
////  zeer eenvoudig versleutelde manier.
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$ext='csv';


/// headers voor aanmaak csv
/*
header("Pragma: public"); // required 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("Cache-Control: private",false); // required for certain browsers 
header("Content-Type:".$ctype.""); 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"licensies_vereniging.csv\"");
*/


// Database gegevens. 
include('mysql.php');
$pageName = basename($_SERVER['SCRIPT_NAME']);
include('page_stats.php');


/// Als eerste kontrole op laatste aanlog. Indien langer dan 2uur geleden opnieuw aanloggen

$aangelogd = 'N';

include('aanlog_check.php');	

if ($aangelogd !='J'){
?>	
<script language="javascript">
		window.location.replace("aanloggen.php");
</script>
<?php
exit;
}
echo"<h2>Licentie bestand ". $vereniging."</h2>";

$csv_file ="csv/licensies_vereniging.csv";
unlink($csv_file);

$fp = fopen($csv_file, "w");
fclose($fp);
$fp = fopen($csv_file, "a");
fwrite($fp, "Licenties vereniging;; ".$vereniging.";"."\r\n");
fwrite($fp, "Nr.;Licentie;Naam;Soort;Email;"."\r\n");

//// Via vereniging_nr uit namen linken met speler_licenties

$qry  = mysql_query("SELECT * From speler_licenties where Vereniging_nr = '".$vereniging_nr ."' order by Naam asc ")     or die(' Fout in select');  

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$i=1;
//// Koptekst
/*
echo  "Licenties vereniging ".$vereniging.";";
echo "\r\n"; 

echo "Nr. ;";
echo "Licentie ;";
echo "Naam;";
echo "Soort;";
echo "Email;";
echo "Telefoon;";
echo "\r\n"; 
*/

// detail regels
while($row = mysql_fetch_array( $qry )) {
	
	// aan het einde van de naam zit soms een Tab (ascii 13)
	
		
	if (ord(substr($row['Naam'],-2,1)) == 13 ){
  	$row['Naam'] = substr($row['Naam'],0,-2);
	}
	
	$line = $i  . ";".$row['Licentie'].";".$row['Naam'].";".$row['Soort'].";";
	
	fwrite($fp,$line."\r\n" );
  echo $row['Naam'].":  ".$row['Licentie']. "<br>"; 

$i++;
}//  end while

fwrite($fp,"\r\n");
fwrite($fp,"Deze lijst kan uitgebreid cq aangepast worden om vervolgens te dienen als selectielijst leden eigen vereniging");
fclose($fp);

echo "<a href = '".$csv_file."' target ='_blank'>".$csv_file."</a>";
  
?>