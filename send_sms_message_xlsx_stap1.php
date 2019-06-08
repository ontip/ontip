<?php 
# send_sms_message_xlsx_stap1.php
# Upload xslx bestand met deelnemers die een SMS krijgen. 
# 
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
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/Basis.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Send SMS bericht tbv inschrijvingen</title>
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">
<style type="text/css"> 
body {color:black;font-family: Calibri, Verdana;font-size:11pt;}
a    {text-decoration:none;color:blue;}
 textarea:focus { background: lightblue;cursor:underline; }
 
#normaal  {background-color: white;color:black;}
#reserve  {background-color: yellow;color:black;}

</style>

<script type="text/javascript">
function SelectRange (element_id) {
var d=document;
if(d.getElementById ) {
var elem = d.getElementById(element_id);
if(elem) {
if(d.createRange) {
var rng = d.createRange();
if(rng.selectNodeContents) {
rng.selectNodeContents(elem);
if(window.getSelection) {
var sel=window.getSelection();
if(sel.removeAllRanges) sel.removeAllRanges();
if(sel.addRange) sel.addRange(rng);
}
}
} else if(d.body && d.body.createTextRange) {
var rng = d.body.createTextRange();
rng.moveToElementText(elem);
rng.select();
}
}
}
}
</script>
<script type="text/javascript">
function CopyToClipboard()

{

   CopiedTxt = document.selection.createRange();

   CopiedTxt.execCommand("Copy");

}

function make_blank_tekst()
{
	document.myForm.smstekst.value="";
}

function Teller() {
	
 	var lengte = document.getElementById("vullen").value.length;
	var Tel = document.getElementById('telveld');
  Tel.innerHTML = lengte;
	
  
}



</script>
</head>
<body>


<?php 
// Database gegevens. 

include('mysqli.php');


/// Als eerste kontrole op laatste aanlog. Indien langer dan half uur geleden opnieuw aanloggen

$toernooi = $_GET['toernooi'];   



/// Als eerste kontrole op laatste aanlog. Indien langer dan 2uur geleden opnieuw aanloggen

$aangelogd = 'N';

include('aanlog_checki.php');	
include ('../ontip/versleutel_string.php'); // tbv telnr en email

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


 
ini_set('display_errors', 'On');
error_reporting(E_ALL);



// Haal sms parameters op ook ivm bevestigen laatste inschrijvingen

   $qry        = mysqli_query($con,"SELECT * From vereniging  where Vereniging = '".$vereniging ."'  ") ;  
   $result     = mysqli_fetch_array( $qry);
   $sms_max    = $result['Max_aantal_sms'];
   $verzendadres_sms = $result['Verzendadres_SMS'];

//// Change Title //////
?>
<script language="javascript">
 document.title = "OnTip Send SMS message - <?php echo  $toernooi_voluit; ?>";
</script>
<?php

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees configuratie tabel tbv toernooi gegevens


if (isset($toernooi)) {
	
//	echo $vereniging;
//  echo $toernooi;
	
	$qry  = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' ")     or die(' Fout in select');  

// Definieeer variabelen en vul ze met waarde uit tabel

while($row = mysqli_fetch_array( $qry )) {
	
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}
	
	 
}
else {
		echo " Geen toernooi bekend :";
	 exit;
};
// set max file size for upload (500 kb)
$max_file_size = 500000;

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

<span style='text-align:right;'><a href='index.php'>Terug naar Hoofdmenu</a></td></span>

<h3 style='padding:10pt;font-size:20pt;color:green;'>Versturen SMS bericht t.b.v "<?php echo $toernooi_voluit; ?>"&nbsp<img src = '../ontip/images/sms_bundel.jpg' width=45 border =0 ></h3>

<?php
 if ($sms_bevestigen_zichtbaar_jn == 'J'){
      // Check sms_tegoed    
      include('sms_tegoed.php');
      echo "<table><tr><td><blockquote><table style='border-collapse: collapse;border : 2pt solid green;box-shadow: 5px 5px 2px #888888;' >
      <tr><td style='background-color: green;color:white;font-size:6pt;padding:8pt;text-align:center;'>SMS tegoed<br> in OnTip bundel</td>
      <td style='background-color: white;color:black;font-size:11pt;width:25pt;text-align:center;padding:4pt;font-weight:bold;'> ".$sms_tegoed."</td></tr>
      <tr><td style='text-align:center;font-size:9pt;color:red;border-top: 1pt solid green;' colspan =2><a style='font-size:9pt;color:red;' href='aanvraag_sms.php'  >Aanvullen SMS bundel</a></td></tr>     
      </table></td><td style='vertical-align:top;'><img src='../ontip/images/icon_excel.png' width=100></td></tr></table></blockquote><br>";
  }
?>

<blockquote>
	Met behulp van dit programma kan je een SMS bericht versturen naar de spelers voor het toernooi. De namen en telefoon nummers zijn opgenomen in een Exel bestand, die je via de onderstaande link kan aanmaken.<br>
	Na aanmaak van het bestand kan je deze eventueel nog corrigeren of aanvullen. Dit bestand bevat 4 kolommen.1 Volgnummer, 2. Naam, 3.Vereniging, 4. Telefoon nummer.<br>
	Selekteer het bestand en voer een SMS tekst in. Hierna dien je op Verzenden te drukken.  In een vervolgscherm kan je nog een selectie uitvoeren of wie wel of geen SMS bericht krijgt.
	<b>Denk eraan dat je voldoende SMS berichten over hebt in je OnTip SMS bundel</b>.
<br><br>
 <a href = 'export_inschrijf_xlsx_SMS.php?toernooi=<?php echo $toernooi;?> ' target = '_blank'>Aanmaak Excel bestand vanuit inschrijvingen</a>
 <br>
<FORM action="send_sms_message_xlsx_stap2.php" method="post" name= "myForm" enctype="multipart/form-data">

<input type="hidden" name="server" value="ftp.ontip.nl">
<input type="hidden" name="max_file_size" value="<?php echo $max_file_size;?>">
<input type="hidden" name="toernooi" value="<?php echo $toernooi;?>" />



<br>
<table>
	<tr><td width=200 style='vertical-align:top;'>SMS Tekst</label></td>

<td><textarea name='smstekst' id='vullen' rows='5' cols='85' onclick="make_blank_tekst();" onKeyUp="Teller()"  >Typ hier de SMS tekst.</textarea><br>
	<span class="Opmerk-g">Lengte bericht : <span id="telveld" class="Opmerk-g">0</span>&nbsp;karakters. Er worden maximaal 160 karakters verstuurd !!</span> </td>
 </tr>
 	<tr><td width=200 style='vertical-align:top;'>Naam bestand : </label></td>

<td><input style='text-align:left;vertical-align:text-top;background-color:lightblue; '  name="userfile" type="file" size="50"><input type="submit" name="submit" value="Upload bestand" /></td>
 </tr>
 </table>
<br>
</blockquote>



</FORM>


</body>
</html>
