<?php
////  insert_leden_NJBB.php  (c) Erik Hendrikx 2012 ev   CLASSIFIED !!!!! CLASSIFIED !!!!! CLASSIFIED !!!!! CLASSIFIED !!!!!
////
////  Programma voor het vullen van de tabel speler_licenties met de gegevens van alle NJBB leden. Input hiervoor is het bestand NJBBLedenS.txt afkomstig van Welp.
////  Deze bevat de gegevens van alle NJBB leden op een zeer eenvoudig versleutelde manier.
////
////  Dit programma leest het versleutelde bestand regel voor regel, veld voor veld, decrypt de gegevens van een veld via module versleutel_licentie.php en vult de tabel speler_licenties.
////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/Basis.dwt" codeOutsideHTMLIsLocked="false" -->
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	</head>
	<?php 
// Database gegevens. 
include('mysql.php');
include('versleutel_licentie.php'); 

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
 echo "test";
 
 
// echo "rechten : ". $rechten;
$line_c =0;

if ($rechten != "A"  and $rechten != "C"){
 echo '<script type="text/javascript">';
 echo 'window.location = "rechten.php"';
 echo '</script>'; 
}

setlocale(LC_ALL, 'nl_NL');

// NJBBLedenS.txt
$myFile = 'C:\Welp\NJBBLedenS.txt';

$myFile = 'NJBBLedenS.txt';


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees bestand met Leden

$fh       = fopen($myFile, 'r');
$line     = fgets($fh);



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
while ($i  < 7 ){  // kolommen
$decrypt_veld = '';
$decrypt_veld = versleutel_licentie($encrypt_veld[$i], 'decrypt',10);	

switch ($i) {
	  case 0: $lic_klare_waarde   = $decrypt_veld;break;
	  case 1: $naam               = $decrypt_veld;break;
	  case 3: $soort              = $decrypt_veld;break;
	  case 4: $vereniging_nr      = $decrypt_veld;break;
	  case 5: $vereniging         = $decrypt_veld;break;
	  case 6: break;
	} // end switch
	
$i++;            /// volgende veld
} // end while veld

// Diacrieten omzetten in vereniging en naam
$naam       =  preg_replace('/[^a-z0-9\\040\\.\\-\\_\\\\]/i',         '*' , $naam);
$vereniging =  preg_replace('/[^a-z0-9\\040\\"\\.\\-\\_\\\\]/i',  '*' , $vereniging);


if ($vereniging_nr == '09060')
{
//echo "aaa". $naam."<br>";

}

// Schonen tabel voor aanvang ivm mogelijke wijzigingen in ledenbestand
// Als er nog geen conversie is geweest, dan uitvoeren

$delete = "delete from speler_licenties where Licentie = '".$lic_klare_waarde."' ";
mysql_query($delete) or die ('fout in delete');  
$insert = "insert into speler_licenties (Licentie, Naam, Vereniging,Vereniging_nr,Soort, Laatst) VALUES (
                                        '".$lic_klare_waarde."', 
                                        '".htmlentities($naam,ENT_QUOTES, 'UTF-8')."',
                                        '".htmlentities($vereniging,ENT_QUOTES, 'UTF-8') ."',
                                        '".$vereniging_nr."','".$soort."',
                                        NOW())";
mysql_query($insert) or die ('fout in insert speler licenties');; 
//echo $insert."<br>";


$line_c ++;
$line = fgets($fh); /// Volgende regel
}// end while line
fclose($fh);

// Omzetten bekende verenigingen

$update   = "UPDATE speler_licenties set Vereniging = 'PV Le Chateau'           where Vereniging_nr = '05020'";
mysql_query($update) or die ('fout in update');

$update  = "UPDATE speler_licenties set Vereniging = 'Jeu de Boules Coevorden'  where Vereniging_nr = '02257'";
mysql_query($update) or die ('fout in update');

$update  = "UPDATE speler_licenties set Vereniging = 'Jeu de Boules vereniging O.S.B'  where Vereniging_nr = '09094'";
mysql_query($update) or die ('fout in update');


$date = date('Y-m-d:H:i:s');
echo 'Alle '.$line_c.' records zijn verwerkt op '.$date.'.';
?> 