<?php
////  lijst_licensies_export.php.  (c) Erik Hendrikx 2012 ev
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

switch ($ext) { 
      case "csv": $ctype="csv/vnd.ms-excel"; break; 
      case "xls": $ctype="csv/vnd.ms-excel"; break; 
} 
/// headers voor aanmaak csv
header("Pragma: public"); // required 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("Cache-Control: private",false); // required for certain browsers 
header("Content-Type:".$ctype.""); 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"licensies_vereniging.csv\"");

// Database gegevens. 
include('mysqli.php');
$pageName = basename($_SERVER['SCRIPT_NAME']);
include('page_stats.php');

/// Als eerste kontrole op laatste aanlog. Indien langer dan 2uur geleden opnieuw aanloggen

$aangelogd = 'N';

include('aanlog_checki.php');	

if ($aangelogd !='J'){
?>	
<script language="javascript">
		window.location.replace("aanloggen.php");
</script>
<?php
exit;
}

if ($rechten != "A"  and $rechten != "C"){
 echo '<script type="text/javascript">';
 echo 'window.location = "rechten.php"';
 echo '</script>'; 
}


//// Via vereniging_nr uit namen linken met speler_licenties

$qry  = mysqli_query($con,"SELECT * From speler_licenties where Vereniging_nr = '".$vereniging_nr ."' order by Naam asc ")     or die(' Fout in select');  

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
include('conv_diakrieten.php');
$i=1;
//// Koptekst
echo  "Licenties vereniging ".$vereniging.";";
echo "\r\n"; 

echo "Nr. ;";
echo "Licentie ;";
echo "Naam;";
echo "Soort;";
echo "Email;";
echo "Telefoon;";
echo "\r\n"; 

// detail regels
while($row = mysqli_fetch_array( $qry )) {
	
	 echo  $i  . ";";
   echo  $row['Licentie']. ";";
   echo  $row['Naam']. ";";
   echo  $row['Soort']. ";";
   echo  $row['Email']. ";";
	 echo  ";";

   echo "\r\n"; 

$i++;
}//  end while

echo "\r\n"; 
echo "Deze lijst kan uitgebreid cq aangepast worden om vervolgens te dienen als selectielijst leden eigen vereniging"; 
?>