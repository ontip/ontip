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


</head>

<?php
$toernooi            = $_GET['toernooi'];

if (isset($toernooi)) {
	
/// Als eerste kontrole op laatste aanlog. Indien langer dan half uur geleden opnieuw aanloggen

if(!isset($_COOKIE['aangelogd'])){ 
echo '<script type="text/javascript">';
echo 'window.location = "aanlog.php?key=WI&toernooi='.$toernooi.'"';
echo '</script>';
}

include 'mysqli.php'; 

//// Check op rechten
$sql      = mysqli_query($con,"SELECT Beheerder FROM namen WHERE Vereniging_id = ".$vereniging_id." and Naam='".$_COOKIE['user']."' ") or die(' Fout in select');  
$result   = mysqli_fetch_array( $sql );
$rechten  = $result['Beheerder'];

if ($rechten != "A"  and $rechten != "C"){
 echo '<script type="text/javascript">';
 echo 'window.location = "rechten.php"';
 echo '</script>'; 
}
}// end isset

// statistieken van de pagina bijhouden
$pageName = basename($_SERVER['SCRIPT_NAME']);
include('page_stats.php');

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
<a href='index.php' style='font-size:9pt;color:blue;'>Terug naar Hoofdmenu</a>

<h3 style='padding:1pt;font-size:20pt;color:darkgreen;'>Aanmaak + export Welp inschrijvingen bestand</h3>

<a  href ='Welp_export_inschrijf_stap2.php?toernooi=<?php echo $toernooi; ?>' target='_blank'>Klik hier voor aanmaak <img src = '../ontip/images/download.jpg' width =50 border =0></a>
<br>
<h4>Na klikken op bovenstaande link wordt de aanmmaak+download in de achtergrond gestart. U krijgt een melding als het bestand klaar is.</h4>

<br>

<H3>Vervolgstappen <img src='../ontip/images/welp_logo.png' width=45 border =0></H3>

<span style= 'color:black;font-size:11pt;'>
<ul>
	<li> Als u dit nog niet gedaan heeft, moet u nu het toernooi aanmaken in Welp. 
	<li> Let bij de aanmaak van het toernooi op Doublet/Triplet, de datum en Vaste teams.
	<li> Klik in Welp op de Tab inschrijvingen
	<li> Klik op Importeer inschrijvingen
	<li> Je kan nu in Welp beheer de loting starten.
</ul>
</span>

<hr/>
<span style= 'color:black;font-size:7pt;'>Deze interface is grondig getest en wanneer de hierboven beschreven stappen gevolgd worden, zou het geen negatief effect mogen hebben op het functioneren van Welp. Het blijft de verantwoordelijkheid van de gebruiker om deze functie te gebruiken.</span>
</html>
