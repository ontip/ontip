<?php
$toernooi  = $_GET['toernooi'];
$datum     = date ('Ymd');

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"ideal_transacties_".$toernooi."_".$datum.".csv\"");?>

<?php 
// Database gegevens. 
include('mysql.php');
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees ideal transacties
$sql     = mysql_query("SELECT * from ideal_transacties Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' order by Laatst" )    or die('Fout in select1');  
//echo "SELECT * from ideal_transacties Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' order by Laatst<br>";

// kop 
echo ";Ideal transacties ;". $vereniging.";".$toernooi.";".$datum;
echo "\r\n"; 

echo "Nr;";
echo "Naam speler 1;";
echo "Email;";
echo "Rekening houder;";
echo "Rekening nr;";
echo "Plaats;";
echo "Rekening afschrift;";
echo "Bedrag afschrift;";
echo "Kenmerk inschrijving;";
echo "Datum tijd inschrijving;";
echo "Datum tijd betaald;";
echo "Test Mode;";
echo "Status betaal opdracht;";
echo "Status inschrijving";
echo "\r\n"; 

// detail regels

$i=1;
while($row = mysql_fetch_array( $sql )) {
	
	 $qry_inschrijving     = mysql_query("SELECT * from inschrijf Where Toernooi = '".$toernooi."' and  Id = ".$row['Inschrijf_id']." " ) or  die ('Fout in select2')   ;
 	 $result               = mysql_fetch_array( $qry_inschrijving );


echo $i.";";
echo $result['Naam1'].";";
echo $result['Email'].";";
echo $row['consumerName'].";";
echo $row['consumerAccount'].";";
echo $row['consumerCity'].";";
echo $row['Description'].";";
echo number_format($row['paidAmount']/100, 2, ',', ' ').";";
echo $row['Kenmerk'].";";
echo $result['Inschrijving'].";";
echo $result['Betaal_datum'].";";
echo $row['TestMode'].";";
echo $row['Status'].";";

switch($result['Status']){
  	
  	case "BE0": 	echo "Voorlopige inschrijving via Email gemeld.;";break;
  	case "BE1": 	echo "Voorlopige inschrijving, Geen Email bekend.;";break;
  	case "BE2": 	echo "Betaald maar nog niet bevestigd.;";break;
  	case "BE3": 	echo "Nog niet betaald.Geen Email bekend.;";break;
  	case "BE4": 	echo "Betaald en bevestigd.;";break;
  	case "BE5": 	echo "Geannuleerd maar nog niet gemeld.;";break;
  	case "BE6": 	echo "Geannuleerd en gemeld.;";break;
  	case "BE7": 	echo "Geannuleerd. Geen Email bekend.;";break;
  	case "BE8": 	echo "Nog niet bevestigd. ;";break;
  	case "BE9": 	echo "Nog niet bevestigd.Geen Email bekend. ;";break;
  	case "BEA": 	echo "Bevestigd. Email bekend.;";break;
  	case "BEB": 	echo "Bevestigd. Geen Email bekend.;";break;
  	case "BEC": 	echo "Bevestigd maar nog niet betaald.;";break;
  	case "BED": 	echo "Voorlopige inschrijving via SMS gemeld.;";break;
  	case "BEE": 	echo "Bevestigd via SMS.;";break;
  	case "BEF": 	echo "Geannuleerd en gemeld via SMS.;";break;
    case "DE0": 	echo "Deelnemer heeft verzocht inschrijving te verwijderen via mail.;";break;
    case "DE1": 	echo "Deelnemer heeft verzocht inschrijving te verwijderen (geen mail bekend).;";break;
    case "DE2": 	echo "Deelnemer heeft verzocht inschrijving te verwijderen (geen mail bekend, wel SMS).;";break;
  	case "ID0": 	echo "Betaald via IDEAL.;";break;
  	case "ID1": 	echo "Betaling via IDEAL mislukt of afgebroken.;";break;
  	case "IM0": 	echo "Inschrijving geimporteerd. Niet bevestigd.;";break;
  	case "IM1": 	echo "Inschrijving geimporteerd. Bevestigd via Mail.;";break;
  	case "IM2": 	echo "Inschrijving geimporteerd. Niet bevestigd.;";break;
  	case "IN0": 	echo "Ingeschreven en bevestigd via Email.;";break;
  	case "IN1": 	echo "Ingeschreven. Geen Email bekend.;";break;
  	case "IN2": 	echo "Ingeschreven en bevestigd via SMS.;";break;
  	case "RE0": 	echo "Reservering aangemaakt en bevestigd via Email.;";break;
   	case "RE1": 	echo "Reservering aangemaakt. Geen Email bekend.;";break;
   	case "RE2": 	echo "Reservering geannuleerd via Email.;";break;
   	case "RE3": 	echo "Reservering geannuleerd. Geen Email bekend.;";break;
  	case "RE4": 	echo "Reservering aangemaakt. Bevestigd via SMS.;";break;
  	case "RE5": 	echo "Reservering geannuleerd en gemeld via SMS.;";break;
   	default : echo "Onbekend.;";break; 
  }


echo "\r\n"; 

$i++;
};
?>