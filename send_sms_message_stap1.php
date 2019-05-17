<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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

if (isset($_GET['sel'])){
	$check    = $_GET['sel'];   
}
else {
	$check = 'N';
}	


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



//// Check op rechten

if ($rechten != "A"  and $rechten != "I"){
 echo '<script type="text/javascript">';
 echo 'window.location = "rechten.php"';
 echo '</script>'; 
}
 
ini_set('display_errors', 'On');
error_reporting(E_ALL);


if (!isset($sms_bevestigen_zichtbaar_jn)){
	$sms_bevestigen_zichtbaar_jn = 'N';
}

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
	 
};

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


//// SQL Queries
$spelers      = mysqli_query($con,"SELECT * from inschrijf Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' and (Status in ( 'BED','BEE','BEF' 'IM2', 'RE4', 'RE5', 'IN1', 'IN0') or Telefoon <> '')   order by Inschrijving ")    or die(mysql_error());  

$th_style   = 'border: 1px solid black;padding:3pt;background-color:white;color:black;font-size:10pt;font-family:verdana;font-weight:bold;';
$td_style   = 'border: 1px solid black;padding:2pt;color:black;font-size:10pt;font-family:verdana;font-weight:normal;';
$td_style_w = 'border: 1px solid black;padding:2pt;background-color:white;color:black;font-size:10pt;font-family:verdana';
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
      echo "<blockquote><table style='border-collapse: collapse;border : 2pt solid green;box-shadow: 5px 5px 2px #888888;' >
      <tr><td style='background-color: green;color:white;font-size:6pt;padding:8pt;text-align:center;'>SMS tegoed<br> in OnTip bundel</td>
      <td style='background-color: white;color:black;font-size:11pt;width:25pt;text-align:center;padding:4pt;font-weight:bold;'> ".$sms_tegoed."</td></tr>
      <tr><td style='text-align:center;font-size:9pt;color:red;border-top: 1pt solid green;' colspan =2><a style='font-size:9pt;color:red;' href='aanvraag_sms.php'  >Aanvullen SMS bundel</a></td></tr>     
      </table></blockquote><br>";
  }
?>

<blockquote>
	Met behulp van dit programma kan je een SMS bericht versturen naar alle spelers voor het toernooi, die hebben aangegeven een SMS bevestiging te willen ontvangen of waarbij een telefoon nummer is ingevuld bij inschrijving. In dit bericht kan je aangeven dat het toernooi niet doorgaat of er iets anders belangrijks verandert.
	<b>Denk eraan dat je voldoende SMS berichten over hebt in je OnTip SMS bundel</b>. Een standaard SMS bericht telt maximaal 160 tekens. Stuur je langere berichten dan worden hier extra berichten voor afgerekend.  In onderstaande tabel kan je aangeven wie een SMS dient te ontvangen door in de tweede kolom (Sel) de bewuste inschrijving te selecteren.  <br>
	Als je op het woord <b>'Sel'</b>  klikt bovenaan de tweede kolom, wordt alles aan - of juist uitgezet.Doe dit voordat je een SMS tekst invoert ! Als je een SMS tekst hebt ingevoerd, dien je op Verzenden te drukken.  In een vervolgscherm dien je dit nog een keer te bevestigen.

<FORM action="send_sms_message_stap2.php" method="post" name= "myForm">
	<input type='hidden' name ='toernooi'  value ='<?php echo $toernooi; ?>' >

<br>
<table>
	<tr><td width=200 style='vertical-align:top;'>SMS Tekst</label></td>

<td><textarea name='smstekst' id='vullen' rows='5' cols='85' onclick="make_blank_tekst();" onKeyUp="Teller()"  >Typ hier de SMS tekst.</textarea><br>
	<span class="Opmerk-g">Lengte bericht : <span id="telveld" class="Opmerk-g">0</span>&nbsp;karakters. Er worden maximaal 160 karakters verstuurd !!</span> </td>
 </tr>
 </table>
<br>
</blockquote>

<?php
 if ($verzendadres_sms  == ''){
       echo "<div style='background-color: white;color:red;font-size:12pt;padding:15pt;'>**  Voor ".$vereniging." is de SMS dienst nog niet geactiveerd. </div><br>";
 }
 else {
 	?>
 	    



<blockquote>
<?php
ob_start();

$count=mysqli_num_rows($spelers);
if ($count < 1) { 
	echo "Geen inschrijvingen gevonden die via SMS bevestigd zijn.";
}
else {	

echo "<table  id='myTable1' style='border:2px solid #000000;box-shadow: 10px 10px 5px #888888;' cellpadding=0 cellspacing=0>";
	
//  Koptekst 

if ($check =='J') {
	$new_sel = 'N';
}
else {
	$new_sel = 'J';
}


echo "<tr>";
echo "<th style='". $th_style.";' width=30>Nr</th>";
echo "<th style='". $th_style.";' width=30><a href= 'send_sms_message_stap1.php?toernooi=".$toernooi."&sel=".$new_sel."' target ='_self'>Sel</a></th>";
echo "<th style='". $th_style.";'         >Naam</th>";
echo "<th style='". $th_style.";'         >Vereniging</th>";
echo "<th style='". $th_style.";'>Tel.nr</th>";
echo "<th style='". $th_style.";'>E-mail</th>";
echo "<th style='". $th_style.";' >Status</th>";
echo "<th style='". $th_style.";' >Inschrijving</th>";
echo "</tr>";

/// Detail regels

$i=1;

while($row = mysqli_fetch_array( $spelers )) {

echo "<td style='". $td_style.";'>".$i."</td>";

echo "<td style='". $td_style.";'><input type='checkbox' name='Bevestigen[]' value ='";
echo $row['Id'];
if ($check =='J') {
   echo "'   checked> "; 
} else { 
   echo "'   unchecked> "; 

}	

echo "</td>";
echo "<td style='". $td_style.";'>".$row['Naam1']."</td>";
echo "<td style='". $td_style.";'>".$row['Vereniging1']."</td>";

$tel_nummer      = $row['Telefoon'];
$email_sender    = $row['Email'];
$email_encrypt   = $row['Email_encrypt'];
$telnr_encrypt   = $row['Telefoon_encrypt'];


//  9 aug aanpassing encrypt telnummer+  email in database
if ($email_sender    =='[versleuteld]'){ 
    $email_sender    = versleutel_string($email_encrypt);    
}

if ($tel_nummer    =='[versleuteld]'){ 
    $tel_nummer    = versleutel_string($telnr_encrypt);    
}


echo "<td style='". $td_style.";'>". $tel_nummer."</td>";
echo "<td style='". $td_style.";'>".$email_sender."</td>";

   
  switch($row['Status']){
  	
  	case "BE0": 	echo "<td style='". $td_style.";'>Voorlopige inschrijving via Email gemeld.</td>";break;
  	case "BE1": 	echo "<td style='". $td_style.";'>Voorlopige inschrijving, Geen Email bekend.</td>";break;
  	case "BE2": 	echo "<td style='". $td_style.";'>Betaald maar nog niet bevestigd.</td>";break;
  	case "BE3": 	echo "<td style='". $td_style.";'>Nog niet betaald.Geen Email bekend.</td>";break;
  	case "BE4": 	echo "<td style='". $td_style.";'>Betaald en bevestigd.</td>";break;
  	case "BE5": 	echo "<td style='". $td_style.";'>Geannuleerd maar nog niet gemeld.</td>";break;
  	case "BE6": 	echo "<td style='". $td_style.";'>Geannuleerd en gemeld.</td>";break;
  	case "BE7": 	echo "<td style='". $td_style.";'>Geannuleerd. Geen Email bekend.</td>";break;
  	case "BE8": 	echo "<td style='". $td_style.";'>Nog niet bevestigd. </td>";break;
  	case "BE9": 	echo "<td style='". $td_style.";'>Nog niet bevestigd.Geen Email bekend. </td>";break;
  	case "BEA": 	echo "<td style='". $td_style.";'>Bevestigd. Email bekend.</td>";break;
  	case "BEB": 	echo "<td style='". $td_style.";'>Bevestigd. Geen Email bekend.</td>";break;
  	case "BEC": 	echo "<td style='". $td_style.";'>Bevestigd maar nog niet betaald.</td>";break;
  	case "BED": 	echo "<td style='". $td_style.";'>Voorlopige inschrijving via SMS gemeld.</td>";break;
  	case "BEE": 	echo "<td style='". $td_style.";'>Bevestigd via SMS.</td>";break;
  	case "BEF": 	echo "<td style='". $td_style.";'>Geannuleerd en gemeld via SMS.</td>";break;
    case "DEL": 	echo "<td style='". $td_style.";'>Deelnemer heeft verzocht inschrijving te verwijderen.</td>";break;
  	case "ID0": 	echo "<td style='". $td_style.";'>Betaald via IDEAL.</td>";break;
  	case "ID1": 	echo "<td style='". $td_style.";'>Betaling via IDEAL mislukt of afgebroken.</td>";break;
  	case "IM0": 	echo "<td style='". $td_style.";'>Inschrijving geimporteerd. Niet bevestigd.</td>";break;
  	case "IM1": 	echo "<td style='". $td_style.";'>Inschrijving geimporteerd. Bevestigd via Mail.</td>";break;
  	case "IM2": 	echo "<td style='". $td_style.";'>Inschrijving geimporteerd. Bevestigd via SMS.</td>";break;
  	case "IN0": 	echo "<td style='". $td_style.";'>Ingeschreven en bevestigd via Email.</td>";break;
  	case "IN1": 	echo "<td style='". $td_style.";'>Ingeschreven. Geen Email bekend.</td>";break;
  	case "IN2": 	echo "<td style='". $td_style.";'>Inschrijving geimporteerd. Niet bevestigd.</td>";break;
  	case "RE0": 	echo "<td style='". $td_style.";'>Reservering aangemaakt en bevestigd via Email.</td>";break;
   	case "RE1": 	echo "<td style='". $td_style.";'>Reservering aangemaakt. Geen Email bekend.</td>";break;
   	case "RE2": 	echo "<td style='". $td_style.";'>Reservering geannuleerd via Email.</td>";break;
   	case "RE3": 	echo "<td style='". $td_style.";'>Reservering geannuleerd. Geen Email bekend.</td>";break;
  	case "RE4": 	echo "<td style='". $td_style.";'>Reservering aangemaakt. Bevestigd via SMS.</td>";break;
  	case "RE5": 	echo "<td style='". $td_style.";'>Reservering geannuleerd en gemeld via SMS.</td>";break;
   	default : echo "<td style='". $td_style.";'>Onbekend.</td>";break; 
  }// end switch
   
   
   echo "<td style='". $td_style.";'> ". $row['Inschrijving']  . "</td>" ;
   echo "</tr>";
  

$i++;
}; // end while
echo "</table><br>";

$i--;

?>
<input type='hidden' name ='aantal'  value ='<?php echo $i; ?>' >
<!--  Knoppen voor verwerking   ----->
</blockquote>

<center>
<TABLE>
	<tr>
		<td valign="top" > <INPUT type='submit' value='Verzenden' >
		</td>
		<td valign="top" > <input type = 'button' value ='Annuleren' onclick= "location.replace('send_sms_message_stap1.php?toernooi=<?php echo $toernooi; ?>')">
</td>
</tr>
</table>
</center>
</blockquote>
<?php
}  // geen sms dienst

?>


</FORM>



<?php
} // count < 1
?>

</body>
</html>
