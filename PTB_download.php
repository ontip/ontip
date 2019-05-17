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
$datum               = $_GET['datum'];
$vereniging_id       = $_GET['id'];


include 'mysqli.php'; 
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

// Ophalen toernooi gegevens
$var              = 'toernooi_voluit';
$qry2             = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  ")     or die(' Fout in select2');  

while($row = mysqli_fetch_array( $qry2 )) {
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}
	
// uit vereniging tabel	
	
$qry          = mysqli_query($con,"SELECT * From vereniging where Vereniging = '".$vereniging ."'   ")     or die(' Fout in select');  
$row          = mysqli_fetch_array( $qry );
$url_logo     = $row['Url_logo'];
$url_website  = $row['Url_website'];
$vereniging_output_naam = $row['Vereniging_output_naam'];


if ($vereniging_output_naam !=''){ 
    $_vereniging = $row['Vereniging_output_naam'];
} else { 
    $_vereniging = $row['Vereniging'];
}



?>
<body onload="JavaScript:timedRefresh(4000);">
<!--body-->
	
<div style='background-color:white;'>
<table >
<tr><td rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='240'></td>
<td STYLE ='font-size: 36pt; color:green ;'>Toernooi inschrijving <?php echo $_vereniging; ?></TD></tr>
<td STYLE ='font-size: 32pt; color:blue ;'> <?php echo $toernooi_voluit; ?></TD>
</tr>
</TABLE>
</div>
<hr color='red'/>
<a href='index.php' style='font-size:9pt;color:blue;'>Terug naar Hoofdmenu</a>

<h3 style='padding:1pt;font-size:20pt;color:darkgreen;'>Aanmaak + download Petanque Beheer Toernooi deelnemers bestand</h3>

<?php if ($_COOKIE['aangemaakt']) {
	echo "<br><h2>Bestand is aangemaakt en gedownload als <span style='color:red;font-size:14pt;'>'<b>".$_COOKIE['aangemaakt']."'.</b></span></h2>";
} else { 
	?>

<a  href ='PTB_export_toernooi_fill.php?toernooi=<?php echo $toernooi;?>&datum=<?php echo $datum;?>&id=<?php echo $vereniging_id;?>' target='_blank'>Klik hier voor aanmaak <img src = '../ontip/images/download.jpg' width =50 border =0></a>
<br>
<h4>Na klikken op bovenstaande link wordt de aanmmaak+download in de achtergrond gestart. Na ca. 10 seconden krijgt u de melding dat het bestand aangemaakt en gedownload is.</h4>
<!--a style= color:red;' href ='PTB_download.php?toernooi=<?php echo $toernooi;?>&datum=<?php echo $datum;?>&id=<?php echo $vereniging_id;?>'>Klik hier voor scherm verversen.</a-->

<?php } ?>
<br>

<H3>Vervolgstappen <img src='../ontip/images/logo_ptb.png' width=45 border =0></H3>

<span style= 'color:black;font-size:11pt;'>
<ul>
	<li> Als u dit nog niet gedaan heeft ,moet u nu het toernooi aanmaken in Petanque Toernooi beheer. Gebruik als naam <b><?php echo $toernooi ?></b>.
	<li> Let bij de aanmaak van het toernooi op Tete-a-Tete/Doublet/Triplet, de datum en Vaste teams.
	<li> Als u Windows7 of hoger heeft, staat het <b>OnTip</b> deelnemers bestand na upload in de Download folder. In de andere gevallen heeft u zelf kunnen aangeven waar het bestand geplaatst moest worden.
	<li> Open het bestand in Kladblok door er met de rechtermuisknop op te klikken en te kiezen voor Openen of Bewerken. 
	<li> Als er vreemde tekens in de naam van de vereniging of deelnemer staan, worden de volgende kolommen opgeschoven. Kontroleer of alle kolommen netjes onder elkaar staan en pas dit evt aan.
	<li> Navigeer in het geopende bestands venster naar de folder <b>Mijn documenten/Petanque Toernooi Beheer/Data </b>
	<li> Zet de cursor op het door Petanque beheer aangemaakte bestand met dezelfde datum en naam '<?php echo $toernooi ?> deelnemers.txt' en selecteer deze door erop te klikken.
	<li> Klik op Opslaan en Klik op ja als u gevraagd wordt het bestand te vervangen.
	<li> Je kan nu in Petanque Toernooi beheer de loting starten.
</ul>
</span>
<br>
	<h3>Als stripverhaal.....</h3>
	<br><br>
	<table
		<tr>
			<td><img src = '../ontip/images/ptb_save_as_stap1.png'   width=180 ></td>
			<td><img src = '../ontip/images/ptb_save_as_stap2.png'   width=520 ></td>
			<td><img src = '../ontip/images/ptb_save_as_stap3.png'   width=520 ></td>
			<td><img src = '../ontip/images/ptb_save_as_stap4.png'   width=250 ></td>
	</tr>
</table>		
<hr/>
<span style= 'color:black;font-size:7pt;'>Deze interface is grondig getest en wanneer de hierboven beschreven stappen gevolgd worden, zou het geen negatief effect mogen hebben op het functioneren van PT Toernooi Beheer. Het blijft de verantwoordelijkheid van de gebruiker om deze functie te gebruiken.</span>
</html>
