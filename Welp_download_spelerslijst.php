<html>
	<Title>OnTip inschrijvingen (c) Erik Hendrikx</title>
	<head>
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">                    
<style type='text/css'>
BODY {color:black ;font-size: 9pt ; font-family: Comic sans, sans-serif;background-color:white}
TH {color:black ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif; color:darkgreen;Font-Style:Bold;text-align: left; }
TD {color:blue ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif ;padding-left: 11px;}
h1 {color:green ; font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h2 {color:blue ;font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h3 {color:green ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}

a:link    {color: red;font-size:12pt;text-decoration:none;}
a:hover   {color: blue;font-size:14pt;text-decoration:none;}
a:visited {color: green;font-size:12pt;text-decoration:none;}
</style>

<script type="text/JavaScript">
<!--
function timedRefresh(timeoutPeriod) {
	setTimeout("location.reload(true);",timeoutPeriod);
}
//   -->
</script>
</head>

<?php
$toernooi            = $_GET['toernooi'];

if (isset($toernooi)) {
	
/// Als eerste kontrole op laatste aanlog. Indien langer dan half uur geleden opnieuw aanloggen

if(!isset($_COOKIE['aangelogd'])){ 
echo '<script type="text/javascript">';
echo 'window.location = "aanlog.php?key=WS&toernooi='.$toernooi.'"';
echo '</script>';
}

include 'mysql.php'; 

//// Check op rechten
$sql      = mysql_query("SELECT Beheerder FROM namen WHERE Vereniging_id = ".$vereniging_id." and Naam='".$_COOKIE['user']."' ") or die(' Fout in select');  
$result   = mysql_fetch_array( $sql );
$rechten  = $result['Beheerder'];

if ($rechten != "A"  and $rechten != "C"){
 echo '<script type="text/javascript">';
 echo 'window.location = "rechten.php"';
 echo '</script>'; 
}
}// end isset

?>
<body onload="JavaScript:timedRefresh(4000);">
<!--body-->
	
<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='240'></td>
<td STYLE ='font-size: 36pt; background-color:white;color:green ;'>Toernooi inschrijving <?php echo $vereniging; ?></TD></tr>
<td STYLE ='font-size: 32pt; background-color:white;color:blue ;'> <?php echo $toernooi_voluit; ?></TD>
</tr>
</TABLE>
</div>
<hr color='red'/>

<span style='text-align:right;vertical-align:text-top;font-size:8pt;'><a href='index.php'>Terug naar Hoofdmenu</a></span><br>

<h3 style='padding:1pt;font-size:20pt;color:darkgreen;'>Aanmaak + download Welp spelerslijst bestand</h3>

<?php if ($_COOKIE['aangemaakt']) {
	echo "<br><h2>Bestand is aangemaakt en gedownload als <span style='color:red;font-size:14pt;'>'<b>".$_COOKIE['aangemaakt']."'.</b></span></h2>";
} else { 
	?>

<a  href ='welp_export_spelerslijst.php?toernooi=<?php echo $toernooi; ?> target='_blank'>Klik hier voor aanmaak <img src = '../ontip/images/download.jpg' width =50 border =0></a>
<br>
<h4>Na klikken op bovenstaande link wordt de aanmmaak+download in de achtergrond gestart. Na ca. 10 seconden krijgt u de melding dat het bestand aangemaakt en gedownload is.</h4>
<!--a style= color:red;' href ='PTB_download.php?toernooi=<?php echo $toernooi;?>&datum=<?php echo $datum;?>&id=<?php echo $vereniging_id;?>'>Klik hier voor scherm verversen.</a-->

<?php } ?>
<br>

<H3>Vervolgstappen <img src='../ontip/images/welp_logo.png' width=45 border =0></H3>

<span style= 'color:black;font-size:11pt;'>
<ul>
	<li> Als u dit nog niet gedaan heeft, moet u nu het toernooi aanmaken in Welp. 
	<li> Kopieer het aangemaakte bestand naar de folder c:\Welp\Spelerslijsten.
	<li> Klik in Welp op de Tab inschrijvingen
	<li> Bij Wilt u gebruik maken van een spelerslijst ?  Vink Ja en klik op Specificeer.
	<li> Selecteer het aangemaakte bestand.
	<li> Je kan nu in Welp beheer verder gaan met de inschrijving.
</ul>
</span>
<br>
	<h3>Als stripverhaal.....</h3>
	<br><br>
	<table
		<tr>
			<td></td>
			<td></td>
	</tr>
</table>		
<hr/>
<span style= 'color:black;font-size:7pt;'>Deze interface is grondig getest en wanneer de hierboven beschreven stappen gevolgd worden, zou het geen negatief effect mogen hebben op het functioneren van Welp. Het blijft de verantwoordelijkheid van de gebruiker om deze functie te gebruiken.</span>
</html>
