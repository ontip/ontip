<?php 
# voorspelling_kwalificatie.php
# Scherm om de voorspelling voor een kwalificatie in te voeren
# Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
# 24mei2019         -            E. Hendrikx 
# Symptom:   		    None.
# Problem:     	    None
# Fix:              None
# Feature:          Verkleinen input veld voor bestandsnaam
# Reference: 
?>
<html
<head>
<title>Upload inschrijvingen</title>
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">

<style type="text/css">
	body {color:black;font-size: 10pt; font-family: Comic sans, sans-serif, Verdana;  }
th {color:brown;font-size: 8pt;background-color:white;}

a    {text-decoration:none ;color:blue;}

td.menuon { border-color: red;border-width:2px; border-style:solid outset;font-size:14pt;}
td.menuoff { border-color: #FFFFFF;border-width:2px;font-size:14pt;  }

td.menuon2 { border-color: blue;border-width:2px; border-style:solid outset;font-size:14pt;}
td.menuoff { border-color: #FFFFFF;border-width:2px;font-size:14pt;  }
input:focus, input.sffocus  { background: lightblue;cursor:underline; }

</style>
</head>
<body>
	

<?php

// Database gegevens. 
include('mysqli.php');
$pageName = basename($_SERVER['SCRIPT_NAME']);
include('page_stats.php');
ob_start();

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

if (isset($_GET['toernooi'])){
	$toernooi = $_GET['toernooi'];
}



//// Check op rechten
$rechten  = $result['Beheerder'];

if ($rechten != "A"  and $rechten != "I"){
 echo '<script type="text/javascript">';
 echo 'window.location = "rechten.php"';
 echo '</script>'; 
}
if ($rechten != "A"  and $rechten != "C"){
 echo '<script type="text/javascript">';
 echo 'window.location = "rechten.php"';
 echo '</script>'; 
}


// Ophalen toernooi gegevens
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



<div style='background-color:white;'>
<table >
<tr><td rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='240'></td>
<td STYLE ='font-size: 36pt; color:green ;'>Toernooi inschrijving <?php echo $_vereniging; ?></TD></tr>
<td STYLE ='font-size: 32pt; color:blue ;'> <?php echo $toernooi_voluit; ?></TD>
</tr>
</TABLE>
</div>
<hr color='red'/>


<span style='text-align:right;'><a href='index.php'>Terug naar Hoofdmenu</a></span>

<script language="javascript">
 document.title = "OnTip Import inschrijvingen <?php echo $toernooi;?> ";
</script> 

<div style='padding:10pt;font-size:20pt;color:green;'><br>Import inschrijvingen via Excel xlsx bestand <img src="../ontip/images/import_ext.png" width=65 border =0 ></div>

<?php

$qry            = mysqli_query($con,"SELECT * From vereniging where Vereniging = '".$vereniging ."'  ")     ;
$row            = mysqli_fetch_array( $qry );
$prog_url       = $row['Prog_url'];

// set max file size for upload (500 kb)
$max_file_size = 500000;

	
?>
<form action="import_inschrijvingen_xlsx_stap2.php" method="POST" enctype="multipart/form-data">
<input type="hidden" name="server" value="81.26.219.37">
<input type="hidden" name="max_file_size" value="<?php echo $max_file_size;?>">
<input type="hidden" name="toernooi" value="<?php echo $toernooi;?>" />


<div style='text-align:left;color:black;font-size:10pt;font-family:arial;'>
	<blockquote>Met behulp van dit programma kunnen inschrijvingen vanuit een Excel bestand rechtstreeks in het OnTip systeem worden geimporteerd. <br>
   Hieronder (zie stap 1) staat een link naar een template (= voorbeeld) bestand. Klik op deze link en sla dit bestand op op uw PC (xlsx formaat).<br> 
  <b>Omdat de structuur van dit bestand van wezenlijk belang is voor het importeren, dient u alleen gebruik te maken van dit voorbeeld bestand voor de import.</b><br>
	Vul m.b.v Excel de gegevens van de deelnemers in en sla het gewijzigde bestand onder een andere naam op in csv formaat. Verwijder geen kolommen !!
	<br>
	Indien het een toernooi betreft waarvoor het hebben van een licentie verplicht is, dan hoeft in het bestand alleen het licentie nr (zie voetnoot op deze pagina) van de speler te worden opgegeven. Naam+vereniging worden uit het systeem gehaald.
  <br><br>
	Stap 2. Upload dit bestand vervolgens door op deze pagina het bestand te selecteren. Voordat de inschrijvingen worden geimporteerd zullen de gegevens eerst worden gekontroleerd en wordt om een bevestiging gevraagd.<br>
	Er worden geen bevestigingen naar de deelnemers gestuurd, wel een bevestiging van het importeren naar het email adres van de organisatie (<?php echo $email_organisatie; ?>) .
	</blockquote>
	<br>
		<br><br>
	
	<fieldset style='border:1px solid red>;width:75%;padding:15pt;'>
	
	<legend style='left-padding:5pt;color:darkgreen;font-size:14px;font-family:Arial;'>Stap 1. xlsx template tbv inschrijvingen</legend>
	
	<table width=95% border = 0 >
	<tr>
<td width=55%  style='text-align:left;color:blue;font-size:10pt;font-family:arial;'>
<img src='../ontip/images/icon_excel.jpg' border = 0 width =22  >	<a href = '../ontip/xlsx/template_inschrijven.xlsx' > Klik hier om het template bestand op te halen.</a></td>

</tr>
</table>
		
</fieldset>
	
 </div> 		
<br>
<br>

<fieldset style='border:1px solid red>;width:75%;padding:15pt;'>
	<legend style='left-padding:5pt;color:darkgreen;font-size:14px;font-family:Arial;'>Stap 2. Upload bestand met inschrijvingen</legend>
	
	
<table width=95% border = 0 >
	<tr>
<td width=55%  style='text-align:left;color:blue;font-size:10pt;font-family:arial;'><img src='../ontip/images/icon_excel.jpg' border = 0 width =22  >Selecteer een Excel bestand met inschrijvingen voor importeren :  </td>
<td style='text-align:center;vertical-align:text-top;'><input style='text-align:left;vertical-align:text-top;background-color:lightblue; '  name="userfile" type="file" size="50">
	<input type="submit" name="submit" value="Upload bestand" />
	
	</td>
</tr>
</table>
</fieldset>
<br>
<i>* De licentie gegevens van de deelnemers in het systeem kunnen verouderd zijn. Het kan dus voorkomen dat u na de import sommige inschrijvingen handmatig moet corrigeren</i>

</form>
<br>
</html>
