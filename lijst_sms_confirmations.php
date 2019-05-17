<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/Basis.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Lijst OnTip SMS verbruik</title>
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">

<style type="text/css"> 
body {color:'.$tekstkleur.';font-family: Calibri, Verdana;font-size:14pt;}

table {border-collapse: collapse;}

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
include('mysqli.php');
$pageName = basename($_SERVER['SCRIPT_NAME']);
include('page_stats.php');

ob_start();
/* Set locale to Dutch */
setlocale(LC_ALL, 'nl_NL');

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

$th_style   = 'border: 1px solid black;padding:3pt;background-color:white;color:black;font-size:10pt;font-family:verdana;font-weight:bold;';
$td_style   = 'border: 1px solid black;padding:2pt;color:black;font-size:10pt;font-family:verdana';
$td_style_w = 'border: 1px solid black;padding:2pt;background-color:white;color:black;font-size:10pt;font-family:verdana';

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<body bgcolor="white">
<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
?>

<table border =0 width=90%>
<tr><td ><img src = '../ontip/images/ontip_logo.png' width='240'>
</td><td style='background-color:white;'><h1 style='color:black;font-family:verdana;text-align:left;padding-left:15pt;'>OnTip SMS verbruik</h1>
</td></tr>
</table>
<hr color ='darkgreen'>
<br>
<h3 style='color:darkgreen;font-family:verdana;text-align:left;padding-left:15pt;'>Overzicht OnTip SMS berichten per vereniging</h3>

<blockquote>

<?php
//  Koptekst

echo "<table  id='myTable1' style='border:2px solid #000000;box-shadow: 10px 10px 5px #888888;' cellpadding=0 cellspacing=0 ><tr>";
echo "<th style='". $th_style.";' width=30>Nr</th>";
echo "<th style='". $th_style.";'>Vereniging</th>";
echo "<th style='". $th_style.";'>Verzender</th>";
echo "<th style='". $th_style.";'>Grootte<br>SMS bundel</th>";
echo "<th style='". $th_style.";'>SMS gebruikt</th>";
echo "<th style='". $th_style.";'>SMS tegoed</th>";
echo "<th style='". $th_style.";'>Laatste update SMS bundel</th>";
echo "</tr>";

//// SQL Queries

$qry1          = mysqli_query($con,"SELECT Vereniging From sms_confirmations  group by Verzender order by  Verzender  ") ;  
	/// Detail regels

$i=1;
$totaal_aantal_sms = 0;
$totaal_tegoed_sms = 0;


while($row1 = mysqli_fetch_array( $qry1 )) {
	
	$vereniging        = $row1['Vereniging'];
	
	$qry2                       = mysqli_query($con,"SELECT * From vereniging where Vereniging = '".$vereniging ."' ")     or die(' Fout in select 2');  
  $result2                    = mysqli_fetch_array( $qry2);
	$max_aantal_sms             = $result2['Max_aantal_sms'];
	$datumtijd_sms_saldo_update = $result2['Datumtijd_sms_saldo_update'];
	$verzendadres_sms           = $result2['Verzendadres_SMS'];
	
	// Check op max aantal sms berichten
  include('sms_tegoed.php');

   $aantal_sms = ($max_aantal_sms - $sms_tegoed);

		echo "<tr>";
    echo "<td style='". $td_style_w.";' >". $i  . " </td>" ;
    echo "<td style='". $td_style_w.";'>". $vereniging .  "</td>" ;
    echo "<td style='". $td_style_w.";'>". $verzendadres_sms  .  "</td>" ;
    echo "<td style='". $td_style_w.";text-align:right;'>". $max_aantal_sms .  "</td>" ;
    echo "<td style='". $td_style_w.";text-align:right;'>". $aantal_sms .  "</td>" ;
    echo "<td style='". $td_style_w.";text-align:right;'>". $sms_tegoed.  "</td>" ;
    echo "<td style='". $td_style_w."'>". $datumtijd_sms_saldo_update .  "</td>" ;

echo "</tr>"; 
$totaal_aantal_sms = $totaal_aantal_sms + $aantal_sms;
$totaal_tegoed_sms = $totaal_tegoed_sms + $sms_tegoed;


$i++;
}; //// end while
		echo "<tr>";
    echo "<td style='". $td_style_w.";' colspan = 4>Totaal aantal sms berichten : </td>";
    echo "<td style='". $td_style_w.";text-align:right;font-weight:bold;'>". $totaal_aantal_sms  .  "</td>" ;
    echo "<td style='". $td_style_w.";text-align:right;font-weight:bold;'>". $totaal_tegoed_sms  .  "</td>" ;
    echo "<td></td>";
    echo "</tr>";
echo "</table><br>";

?>
<div style='font-size:10pt;color:black;padding-left:15pt;'>Het totale SMS tegoed zou overeen moeten komen met het saldo van <a href='https://www.messagebird.com/nl/user/index' target= '_blank'>Dashboard Messagebird&nbsp <img src = '../ontip/images/messagebird-logo.png' width ='50'></a></div>

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
