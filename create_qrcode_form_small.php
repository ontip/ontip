<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
?>
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

$toernooi= $_GET['toernooi'];

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
//  Create_qrcode_form.php

// Dit programma maakt een tekst QRCode voor het openen van het inschrijformulier
//
////////////////////////////////////////////////////////////////////////////////////////////


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

$qry  = mysql_query("SELECT * From vereniging where Vereniging = '".$vereniging ."'  ")     or die(' Fout in select');  
$row = mysql_fetch_array( $qry );
$url_redirect = $row['Url_redirect'];

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


<h3 style='padding:1pt;font-size:20pt;color:green;'>QRC Inschrijfformulier t.b.v smartphone (smalle weergave) '<?php echo $toernooi_voluit; ?>' 

<?php

if ($vereniging =='Boulamis'){
	  $url_redirect = 'https://www.ontip.nl/boulamis/';
	 // $url_redirect ='';
}	  


if ($toernooi !=''){

$url = substr($prog_url,3);
 
 // de ontip link 
$form_link = $url_redirect."inschrijf_form_smal.html?toernooi=".$toernooi;
$form_link = str_replace('https:','http:', $form_link);


$qrc_link  = $prog_url."/images/qrc/qrcf_".$toernooi.".png";
$qrc_file  = "images/qrc/qrcf_".$toernooi.".png";

//echo "Gegevens voor toernooi ". $toernooi . "  : <br>";


QRcode::png("".$form_link."", "".$qrc_link."", "L", 4, 4); 

//QRcode::png("http://www.sitepoint.com", "test.png", "L", 4, 4); 

}

echo "<br>";

// Plaats OnTip logo rechtsonder in QRC
 
$logo_file = 'https://www.ontip.nl/ontip/images/OnTip_banner_qrc.png'; 
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

$dest_x = $dest_x-5;
$dest_y = $dest_y-5;

// creer nieuw bestand

imagecopyresampled($photoFrame, $photo, 0, 0, 0, 0, $fotoW, $fotoH, $fotoW, $fotoH); 
imagecopy($photoFrame, $logoImage, $dest_x, $dest_y, 0, 0, $logoW, $logoH); 
imagejpeg($photoFrame, $targetfile);  

echo "<center><img src = ".$targetfile." border  = 0 width = 300></center>";

?>
<span style='font-size:10pt;color:black;padding:15pt;'>Door deze code met uw smartphone of tablet te scannen *(via QR Code lezer App) kunt u het inschrijfformulier het toernooi direct openen. De code afbeelding kunt u via de rechtermuisknop (Afbeelding opslaan als..) kopieren om deze vervolgens op website of flyer te gebruiken.



