<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/Basis.dwt" codeOutsideHTMLIsLocked="false" -->
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
				<style type=text/css>
body {font-size: 8pt; font-family: Comic sans, sans-serif, Verdana; }
th {color:blue;font-size: 8pt;background-color:blue;color:white;font-weight:bold;}
td {color:black;font-size: 8pt;background-color:white;}
a    {text-decoration:none;color:blue;font-size: 8pt}
</style>

	</head>
	<?php 
// Database gegevens. 
include('mysql.php');
include('versleutel_licentie.php'); 

/// Als eerste kontrole op laatste aanlog. Indien langer dan half uur geleden opnieuw aanloggen

if(!isset($_COOKIE['aangelogd'])){ 
echo '<script type="text/javascript">';
echo 'window.location = "aanlog.php?key=DJ"';
echo '</script>';
}

//// Check op rechten

$sql      = mysql_query("SELECT Beheerder FROM namen WHERE Vereniging = '".$vereniging."' and Naam='".$_COOKIE['user']."' ") or die(' Fout in select');  
$result   = mysql_fetch_array( $sql );
$rechten  = $result['Beheerder'];

// echo "rechten : ". $rechten;

if ($rechten != "A"  and $rechten != "C"){
 echo '<script type="text/javascript">';
 echo 'window.location = "rechten.php"';
 echo '</script>'; 
}

setlocale(LC_ALL, 'nl_NL');

// NJBBLedenS.txt
$myFile = 'NJBBLedenS.txt';


mysql_query('delete from hulp_licenties') ;

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees bestand met Leden

$j=1;

$fh       = fopen($myFile, 'r');
$line     = fgets($fh);

echo "<table border =1>";
echo "<tr>";
echo "<th>Nr</th>";
echo "<th>Licentie</th>";
echo "<th>Naam</th>";
echo "<th>Tel</th>";
echo "<th>Soort</th>";
echo "<th>Afd+ver</th>";
echo "<th>Vereniging</th>";
echo "<th>M-V</th>";
echo "<th>Command</th>";
echo "</tr>";

while ( $line <> ''){

/// records zijn encrypted. Van de ASCII waarde is 10 afgetrokken. Hierdoor is E nu het scheidingsteken (ascii 49) ipv ; (ascii 59)
/// record bestaat uit :
/// 0 Licentie nr
/// 1 Naam
/// 2 Telefoon nr
/// 3 Soort Licentie
/// 4 Afdeling+vereniging nr
/// 5 Vereniging
/// 6 Geslacht
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$encrypt_veld = explode ("E", $line); ////    Velden

$i=0;
while ($i  < 7 ){
$decrypt_veld = '';
$decrypt_veld = versleutel_licentie($encrypt_veld[$i], 'decrypt',10);	

echo $decrypt_veld;

switch ($i) {
	  case 0: $licentie_klaar   = $decrypt_veld;
	          $licentie_encrypt = $encrypt_veld[$i];
	          break;
	  case 1: $naam             = $decrypt_veld;break;
	  case 2: $telefoon         = $decrypt_veld;break;
	  case 3: $soort            = $decrypt_veld;break;
	  case 4: $afdeling         = $decrypt_veld;break;
	  case 5: $vereniging       = $decrypt_veld;break;
	  case 6: $mv               = $decrypt_veld;break;

	} // end switch
	
$i++;            /// volgende veld
} // end while veld

// Diacrieten omzetten in vereniging en naam

/*
$vereniging        = str_replace(  "â", "&#226", $vereniging);
$vereniging        = str_replace(  'ä',  '&#228', $vereniging);
$vereniging        = str_replace(  "è", "&#232", $vereniging);
$vereniging        = str_replace(  "é", "&#233", $vereniging);
$vereniging        = str_replace(  "ê", "&#234", $vereniging);
$vereniging        = str_replace(  "ë", "&#235", $vereniging);
$vereniging        = str_replace(  "ö", "&#246", $vereniging);
$vereniging        = str_replace(  "ï", "&#239", $vereniging);
$vereniging        = str_replace(  "Î",  "&#206", $vereniging);
$vereniging        = str_replace(  '"',  '&#148', $vereniging);
*/
$vereniging        = str_replace(  "'", "&#39",  $vereniging);

//$naam        = str_replace( "â", "&#226", $naam);
//$naam        = str_replace( "ä", "&#228", $naam);
//$naam        = str_replace(  "è", "&#232", $naam);
//$naam        = str_replace( "é", "&#233", $naam);
//$naam        = str_replace( "ê", "&#234", $naam);
//$naam        = str_replace( "ë", "&#235", $naam);
//$naam        = str_replace( "ï", "&#239", $naam);
//$naam        = str_replace( "'", "&#39" ,  $naam);
//$naam        = str_replace( "Î",  "&#206", $naam);
//$naam        = str_replace(  "ö", "&#246", $naam);

//echo  $licentie_klaar . "(". $licentie_encrypt . " )-  ". $naam  . " - ". $vereniging . "<br>";
//echo  $licentie_klaar . "-  ". $naam  . " - ". $vereniging . "<br>";

echo "<tr><td style='text-align:right;'>".$j.".</td>";
echo "<td >".$licentie_klaar."</td>";
echo "<td >".$naam."</td>";
echo "<td >".$telefoon."</td>";
echo "<td >".$soort."</td>";
echo "<td >".$afdeling."</td>";
echo "<td >".$vereniging."</td>";
echo "<td >".$mv."</td>";
echo "<td >update speler_licenties set Naam = '".$naam."', Vereniging = '".$vereniging."' , Soort = '".$soort."' where Licentie = '".$licentie_klaar."';</td></tr>";

$insert =  "insert into hulp_licenties (Licentie,Naam,Vereniging,Soort) values ('".$licentie_klaar."','".$naam."',  '".$vereniging."','".$soort."')";   
mysql_query($insert)  ; 

$j++;

$line = fgets($fh); /// Volgende regel
}// end while line
echo "</table>";


fclose($fh);
echo 'Alle records zijn verwerkt. ';


?> 