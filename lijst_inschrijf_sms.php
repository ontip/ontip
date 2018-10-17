<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/Basis.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Lijst inschrijvingen</title>
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">
<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: Comic sans, sans-serif;background-color:white}
TH {color:black ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif; color:darkgreen;Font-Style:Bold;text-align: left; }
TD {color:blue ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif ;padding-left: 5px;}
h1 {color:orange ; font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h2 {color:blue ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
table {border-collapse: collapse;}
a    {text-decoration:none;color:blue;font-size: 8.0pt }
 input:focus, input.sffocus  { background: lightblue;cursor:underline; }
// --></style>


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
//This line will copy the formatted text to the clipboard
            controlRange.execCommand('Copy');         

            alert('Your HTML has been copied\n\r\n\rGo to Word and press Ctrl+V');
}
</script>
<script type="text/javascript">
function CopyToClipboard()
{
   CopiedTxt = document.selection.createRange();
   CopiedTxt.execCommand("Copy");
}
</script>

<script type="text/javascript">
function CopyHTMLToClipboard(element_id) {    
        if (document.body.createControlRange) {
            var htmlContent = document.getElementById(element_id);
            var controlRange;

            var range = document.body.createTextRange();
            range.moveToElementText(htmlContent);

            //Uncomment the next line if you don't want the text in the div to be selected
            range.select();

            controlRange = document.body.createControlRange();
            controlRange.addElement(htmlContent);

            //This line will copy the formatted text to the clipboard
            controlRange.execCommand('Copy');         

            alert('Your HTML has been copied\n\r\n\rGo to Word and press Ctrl+V');
        }
    }    
    
    function xcopyToClipboard( text )
{
  var input = document.getElementById( 'myTable1' );
  input.value = text;
  input.focus();
  input.select();
  document.execCommand( 'Copy' );
}
    
    
</script>
</head>


<?php 
// Database gegevens. 
include('mysql.php');
$pageName = basename($_SERVER['SCRIPT_NAME']);
include('page_stats.php');

ob_start();
/* Set locale to Dutch */
setlocale(LC_ALL, 'nl_NL');

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



//// Check op rechten
$rechten  = $result['Beheerder'];

if ($rechten != "A"  and $rechten != "I"){
 echo '<script type="text/javascript">';
 echo 'window.location = "rechten.php"';
 echo '</script>'; 
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees configuratie tabel tbv toernooi gegevens

$toernooi = $_GET['toernooi'];


if (isset($toernooi)) {
	
//	echo $vereniging;
//  echo $toernooi;
	
	$qry  = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' ")     or die(' Fout in select');  

// Definieeer variabelen en vul ze met waarde uit tabel

while($row = mysql_fetch_array( $qry )) {
	
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}
	 
}
else {
		echo " Geen toernooi bekend :";
	 
};

if (!isset($link_lijst_zichtbaar_jn)){
	$link_lijst_zichtbaar_jn == 'J';
}


if ($link_lijst_zichtbaar_jn == 'N' and !isset($_GET['lijst_zichtbaar']) ){
    ?>
   <script language="javascript">
        alert("De wedstrijd commissie heeft de toegang tot de deelnemerslijst voor dit toernooi dichtgezet.")
    </script>
  <script type="text/javascript">
		history.back()
	</script>
<?php
 } // lijst niet zichtbaar


	if (!isset($begin_inschrijving)){
		echo " <div style='text-align:center;padding:5pt;background-color:white;color:red;font-size:11pt;' >"; 
		die( " Er is geen toernooi bekend in het systeem onder de naam '".$toernooi."'.");
		echo "</div>";
	};


$sql  = mysql_query("SELECT * From config where Vereniging = '".$vereniging."' and Toernooi = '".$toernooi."' ")     or die(' Fout in select');  
while($row = mysql_fetch_array( $sql )) {
	
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}
	
/// Ophalen tekst kleur

$qry  = mysql_query("SELECT * From kleuren where Kleurcode = '".$achtergrond_kleur."' ")     or die(' Fout in select');  
$row        = mysql_fetch_array( $qry );

$tekstkleur = $row['Tekstkleur'];
$koptekst   = $row['Koptekst'];
$invulkop   = $row['Invulkop'];
$link       = $row['Link'];

/// als achtergrondkleur niet gevonden in tabel, zet dan default waarden
if ($tekstkleur ==''){ $tekstkleur = 'black';};
if ($koptekst   ==''){ $koptekst   = 'red';};
if ($invulkop   ==''){ $invulkop   = 'blue';};
if ($link       ==''){ $link       = 'blue';};

/// Afwijkende font voor koptekst

if (!isset($font_koptekst)){
 	$font_koptekst='';
}

if (!isset($min_splrs)){
 	$min_splrs = '0';
}

 $qry1                   = mysql_query("SELECT * From vereniging where Id = ".$vereniging_id ." ")     or die(' Fout in select');  
 $result1                = mysql_fetch_array( $qry1);
 $sortering_korte_lijst  = $result1['Lijst_sortering'];
 
//  alle inschrijvingen
$spelers      = mysql_query("SELECT * from inschrijf Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' order by Inschrijving ".$sortering_korte_lijst. " " )    or die(mysql_error());  



 // Inschrijven als individu of vast team

$qry        = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'soort_inschrijving'  ") ;  
$result     = mysql_fetch_array( $qry);
$inschrijf_methode   = $result['Parameters'];

if  ($inschrijf_methode == ''){
	   $inschrijf_methode = 'vast';
}

/// Bepalen aantal spelers voor dit toernooi
$aant_splrs_q = mysql_query("SELECT Count(*) from inschrijf WHERE Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' ")        or die(mysql_error()); 

$th_style   = 'border: 1px solid black;padding:3pt;background-color:white;color:black;font-size:10pt;font-family:verdana;font-weight:bold;';
$td_style   = 'border: 1px solid black;padding:2pt;color:black;font-size:10pt;font-family:verdana';
$td_style_w = 'border: 1px solid black;padding:2pt;background-color:white;color:black;font-size:10pt;font-family:verdana';

$aant_splrs =  mysql_result($aant_splrs_q ,0); 

$dag   = 	substr ($datum , 8,2); 
$maand = 	substr ($datum , 5,2); 
$jaar  = 	substr ($datum , 0,4); 

//// Change Title //////
?>
<script language="javascript">
 document.title = "OnTip SMS bevestigingen - <?php echo  $toernooi_voluit; ?>";
</script> 
<body bgcolor="white">
	
	<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='240'></td>
<td STYLE ='font-size: 36pt; background-color:white;color:green ;'>Toernooi inschrijving<br><?php echo $_vereniging; ?></TD>
</tr>
</TABLE>
</div>
<hr color='red'/>
<table width=100%>
	<tr>
 <td style='text-align:left;'><a href='index.php'>Terug naar Hoofdmenu</a></td>
 </tr></table>


<h3 style='padding:10pt;font-size:14pt;color:green;'>Lijst SMS bevestigingen voor <?php echo $toernooi_voluit; ?> <img src = '../ontip/images/sms_bundel.jpg' width='60'></h3>
  
  
<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

// Check op max aantal sms berichten
include('sms_tegoed.php');

?>

  
<blockquote>
<table border =0 width=99%>
  <tr><td style='background-color:white;color:blue;padding:15pt;font-size:11pt;' >  Laatste SMS bundel update : <?php echo $datum_sms_saldo_update;?></td>
  </tr>
</table>

<?php
//// SQL Queries

$qry          = mysql_query("SELECT * From sms_confirmations  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' order by Laatst  ") ;  
//  Koptekst

echo "<table  id='myTable1' style='border:2px solid #000000;box-shadow: 10px 10px 5px #888888;' cellpadding=0 cellspacing=0 ><tr>";
echo "<th style='". $th_style.";' width=30>Nr</th>";
echo "<th style='". $th_style.";'>Naam</th>";
echo "<th style='". $th_style.";'>Vereniging</th>";
echo "<th style='". $th_style.";'>Telefoon</th>";
echo "<th style='". $th_style.";'>Kenmerk</th>";
echo "<th style='". $th_style.";'>Soort bericht</th>";
echo "<th style='". $th_style.";'>Lengte</th>";
echo "<th style='". $th_style.";'># berichten</th>";
echo "<th style='". $th_style.";'>Tijdstip</th>";
echo "</tr>";

/// Detail regels

$i=1;
$totaal_aantal_sms = 0;

while($row = mysql_fetch_array( $qry )) {

if ($row['Lengte_bericht'] < 160){
	$aantal_sms = 1;
}
	
if ($row['Lengte_bericht'] > 159 and $row['Lengte_bericht'] < 320){
	$aantal_sms = 2;
}

if ($row['Lengte_bericht'] > 319 and $row['Lengte_bericht'] < 480){
	$aantal_sms = 3;
}

if ($row['Lengte_bericht'] > 480 and $row['Lengte_bericht'] < 640){
	$aantal_sms = 4;
}

$soort_bericht = "Bevestiging inschrijving deelnemer.";

if (substr($row['Kenmerk'], 0,4) == 'BULK') {
  $soort_bericht = "Algemeen bericht naar (selectie van) deelnemers.";
}	

if (substr($row['Kenmerk'], 0,7) == 'LAATSTE') {
  $soort_bericht = "Melding naar wedstrijd comm voor laatste inschrijvingen.";
}	

if (substr($row['Kenmerk'], 0,6) == 'BVST:J') {
  $soort_bericht = "Bevestiging van voorlopige inschrijving.";
}	

if (substr($row['Kenmerk'], 0,6) == 'BVST:N') {
  $soort_bericht = "Afwijziging van voorlopige inschrijving.";
}	

if (substr($row['Kenmerk'], 0,6) == 'RESV:J') {
  $soort_bericht = "Bevestiging van reserve inschrijving.";
}	

if (substr($row['Kenmerk'], 0,6) == 'RESV:N') {
  $soort_bericht = "Afwijziging van reserve inschrijving.";
}	


		echo "<tr>";
    echo "<td style='". $td_style_w.";' >". $i  . " </td>" ;
    echo "<td style='". $td_style_w.";'>". $row['Naam'] .  "</td>" ;
    echo "<td style='". $td_style_w.";'>". $row['Vereniging_speler'] .  "</td>" ;
    echo "<td style='". $td_style_w.";'>". $row['Telefoon'] .  "</td>" ;
    echo "<td style='". $td_style_w.";'>". $row['Kenmerk'] .  "</td>" ;
    echo "<td style='". $td_style_w.";'>". $soort_bericht.  "</td>" ;
    echo "<td style='". $td_style_w.";text-align:right;'>". $row['Lengte_bericht'] .  "</td>" ;
    echo "<td style='". $td_style_w.";text-align:right;'>". $aantal_sms  .  "</td>" ;
    echo "<td style='". $td_style_w.";'>". $row['Laatst'] .  "</td>" ;

echo "</tr>"; 
$totaal_aantal_sms = $totaal_aantal_sms + $aantal_sms;


$i++;
}; //// end while
		echo "<tr>";
    echo "<td style='". $td_style_w.";' colspan = 7>Totaal aantal sms berichten : </td>";
    echo "<td style='". $td_style_w.";text-align:right;font-weight:bold;'>". $totaal_aantal_sms  .  "</td>" ;
    echo "</tr>";
    

echo "</table><br>";

?>
<span style = 'font-size:10pt;'>Een standaard SMS bericht is maximaal 160 karakters lang.  Voor langere berichten worden extra SMS berichten verrekend (1 per 160 karakters extra)<br>Indien gewenst kan een specificatie van berichten gevraagd worden aan OnTip beheer.Let op: er is ook nog een lijst van SMS servioce berichten.</span>
<br>
	<!--  Knoppen voor verwerking   ----->
<TABLE>
	<tr><td valign="top" > 
<form name="test2">
<input type="button" onClick="CopyToClipboard(SelectRange('myTable1'))" value="Select gegevens" /-->
<br><em style='font-size:9pt;color:<?php echo $tekstkleur;?>;'>Druk na Select op CTRL-C en dan om te plakken CTRL-V</em>


</form>
</td><td valign="top" > 
<INPUT type= 'button' alt='Print deze pagina' value = 'Print'  onClick='window.print()'>
</td>
</tr>
</table>
<div style='font-size:9pt;color:<?php echo $tekstkleur;?>;'>&#169 OnTip - Erik Hendrikx, Bunschoten 2011-<?php echo date('Y');?></div>
</blockquote>
</body>
</html>
