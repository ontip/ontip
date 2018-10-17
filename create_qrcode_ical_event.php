<html>
<head>
<title>Aanmaak QR Code iCal event tbv Agenda</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">
<script src="../ontip/js/utility.js"></script>
<script src="../ontip/js/popup.js"></script>

<style type=text/css>
body {font-size: 10pt; font-family: Comic sans, sans-serif, Verdana; }
a    {text-decoration:none;color:blue;font-size: 8pt;}
</style>

<?php
// Database gegevens. 
include('mysql.php');
/* Set locale to Dutch */
setlocale(LC_ALL, 'nl_NL');

/// Als eerste kontrole op laatste aanlog. Indien langer dan half uur geleden opnieuw aanloggen
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

if (isset($_GET['toernooi'])){
	$toernooi = $_GET['toernooi'];
}



/// QRC software lib
include "../ontip/phpqrcode/qrlib.php"; 

////////////////////////////////////////////////////////////////////////////////////////////
//  Create_qrcode_ical_event.php

// Dit programma maakt een tekst QRCode tbv een ICal entry in de kalender van de Mobile phone
//
////////////////////////////////////////////////////////////////////////////////////////////
// Gelijk aan een normaal Outlook event zonder de Begin - en end tag
// See http://code.google.com/p/zxing/wiki/BarcodeContents
////////////////////////////////////////////////////////////////////////////////////////////



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees configuratie tabel tbv toernooi gegevens


//echo $toernooi;

// Querie

$qry  = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' ")     or die(' Fout in select');  

// Definieeer variabelen en vul ze met waarde uit tabel

while($row = mysql_fetch_array( $qry )) {
	
	 $var = $row['Variabele'];
	 $$var = $row['Waarde'];
	}
	
	//   0123456789
//// 2013-08-07

$jaar  = substr($datum,0,4);
$maand = substr($datum,5,2);
$dag   = substr($datum,8,2);



?>
<body >
<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='240'></td>
<td STYLE ='font-size: 28pt; background-color:white;color:darkgreen ;'>Toernooi inschrijving <?php echo $vereniging ?></TD>
</tr>
<tr><td STYLE ='font-size: 24pt; color:red'><?php echo $toernooi_voluit ?><br>
	<?php   	echo strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )  ?> 
	
	</TD></tr>
</TABLE>
</div>
<hr color='red'/>
 
 <table width=100% border =0>
 <tr>
 	 <td style='text-align:left;border-style:none;' width=74%><a href='index.php' style='font-size:9pt;'>Terug naar Hoofdmenu</a></td> 
<td style='text-align:right;border-style:none;'><a href='' onclick="window.history.go(-1); return false;"' style='font-size:9pt;'  target='_blank'>Pagina terug</a></td>
</tr>
</table>


<h3 style='padding:1pt;font-size:20pt;color:green;'>QR Code voor Agenda Mobile phone <img src = '../ontip/images/icon_ical.png' border =0 width = 40></h3>

<?php

if ($vereniging =='Boulamis'){
	  $url_redirect = 'http://www.ontip.nl/boulamis/';
	 // $url_redirect ='';
}	  

// woordje uur ervan af
$meld_tijd = explode(" ", $meld_tijd);
$meld_tijd = str_replace('.',':', $meld_tijd[0]);


$tijd = explode(":", $meld_tijd);
$uur = $tijd[0];
$minuut = $tijd[1];

if (strlen($uur) == 1 )    { $uur = '0'.$uur; };
if (strlen($minuut) == 1 ) { $minuut = '0'.$minuut; };


/// let op geen Z aan het einde. dat is UTC
//echo "DTSTART:20120908T003000Z" . "<br>";
$dtstart = $jaar.$maand.$dag.'T'.$uur.$minuut.'00';
$dtend   = $jaar.$maand.$dag.'T235900';

if (empty($adres)){
$adres = $vereniging;
}

$locatie = explode(";",$adres);
$adres = $locatie[0]." ".$locatie[1]." ".$locatie[2]." ".$locatie[3]." ".$locatie[4].".";

switch($soort_inschrijving){
    case 'single' :   $soort = 'melee';     break;
    case 'doublet' :  $soort = 'doubletten'; break;
    case 'triplet' :  $soort = 'tripletten'; break;
    case 'kwintet' :  $soort = 'kwintetten'; break;
    case 'sextet' :   $soort = 'sextetten';  break;
 }

/// Eerste positie extra_koptekst geeft aan dat het op een nieuwe regel moet
/// m = met  , z = zonder
$len      = strlen($extra_koptekst);

if (substr($extra_koptekst,0,1) =='%'){
$extra_koptekst = substr($extra_koptekst,1,$len);
}

// laatste 2 posities geven aan met of zonder lichtkrant

if (substr($extra_koptekst,-2) =='#m' or substr($extra_koptekst,-2) == '#z'){
 $extra_koptekst = substr($extra_koptekst,0,strlen($extra_koptekst)-2);
}

//echo $extra_koptekst . "<br>";


///////////////////////////////////////////////////////////////////////////////////////////////////////////
// Diacrieten omzetten in vereniging en toernooi_voluit



//echo $toernooi_voluit. "<br>";
//echo substr($extra_koptekst,0,strlen($extra_koptekst)-2);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Aanmaak event + alarm (24 uur ervoor)

$codeContents  = "BEGIN:VEVENT\n"; 
$codeContents .=  "CLASS:PUBLIC\n"; 
$codeContents .=  "CREATED:20091109T101015Z\n"; 
$codeContents .=  "DESCRIPTION:Dit is een ".$soort." toernooi. ".$extra_koptekst." \n"; 
$codeContents .=  "DTEND:".$dtend."\n"; 
//$codeContents .=  "DTSTAMP:20120908T003000Z"; 
//$codeContents .=  "DTSTART:20120918T123000"; 
$codeContents .=  "DTSTART:".$dtstart."\n"; 
$codeContents .=  "LAST-MODIFIED:20091109T101015Z\n"; 
$codeContents .=  "LOCATION:".$adres ."\n"; 
$codeContents .=  "PRIORITY:5\n"; 
$codeContents .=  "SEQUENCE:0\n"; 
$codeContents .=  "SUMMARY;LANGUAGE=en-us:".$vereniging. " - Toernooi ". $toernooi_voluit."\n"; 
$codeContents .=  "TRANSP:OPAQUE\n"; 
$codeContents .=  "UID:040000008200E00074C5B7101A82E008000000008062306C6261CA01000000000000000\n"; 
$codeContents .=  "END:VEVENT\n"; 

// link naar QRC PNG

$url       = substr($prog_url,3);
$jaar  = substr($datum,0,4);
$maand = substr($datum,5,2);
$dag   = substr($datum,8,2);


$qrc_file  = "images/qrc/qrc_ical_".$toernooi."-".$jaar.$maand.$dag.".png";
$qrc_link  = "images/qrc/qrc_ical_".$toernooi."-".$jaar.$maand.$dag.".png";


// generating QRcode 
 QRcode::png($codeContents, "".$qrc_file."", "L", 4, 4); 

// Plaats OnTip logo rechtsonder in QRC

 
$logo_file = 'http://www.ontip.nl/ontip/images/OnTip_banner_qrc_ical.png'; 
$image_file = $qrc_file;
$targetfile = $qrc_link;

$photo = imagecreatefrompng($image_file); 
$fotoW = imagesx($photo); 
$fotoH = imagesy($photo); 
$logoImage = imagecreatefrompng($logo_file); 
$logoW = imagesx($logoImage); 
$logoH = imagesy($logoImage); 


$photoFrame = imagecreatetruecolor($fotoW,$fotoH); 

$dest_x = $fotoW - $logoW; 
$dest_y = $fotoH - $logoH; 

// verplaats logo

//$dest_x = $dest_x-5;
$dest_y = $dest_y-4;

// creer nieuw bestand

imagecopyresampled($photoFrame, $photo, 0, 0, 0, 0, $fotoW, $fotoH, $fotoW, $fotoH); 
imagecopy($photoFrame, $logoImage, $dest_x, $dest_y, 0, 0, $logoW, $logoH); 
imagejpeg($photoFrame, $targetfile);  

echo "<center><img src = ".$targetfile." border  = 0 width = 250></center>";

echo "<br><br>Deze QRC code is op de host opgeslagen en wordt ingekopieerd in de bevestigingsmail.</h2><br>";


?> 
<span style='font-size:10pt;color:black;padding:15pt;'>Door deze code met uw smartphone of tablet te scannen *(via QR Code lezer App) wordt er een afspraak in uw agenda gemaakt zodat u het toernooi niet hoeft te vergeten.  De code afbeelding kunt u via de rechtermuisknop (Afbeelding opslaan als..) kopieren om deze vervolgens op website of flyer te gebruiken.

