<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/Basis.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Lijst SMS service meldingen</title>
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

$th_style   = 'border: 1px solid black;padding:3pt;background-color:white;color:black;font-size:10pt;font-family:verdana;font-weight:bold;';
$td_style   = 'border: 1px solid black;padding:2pt;color:black;font-size:10pt;font-family:verdana';
$td_style_w = 'border: 1px solid black;padding:2pt;background-color:white;color:black;font-size:10pt;font-family:verdana';



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees configuratie tabel tbv toernooi gegevens


$sql  = mysql_query("SELECT * From config where Vereniging = '".$vereniging."' and Toernooi = '".$toernooi."' ")     or die(' Fout in select');  
while($row = mysql_fetch_array( $sql )) {
	
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}
	
?>

<body bgcolor="white">
<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
?>

<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='240'></td>
<td STYLE ='font-size: 36pt; background-color:white;color:green ;'>Toernooi inschrijving<br><?php echo $vereniging; ?></TD>
</tr>
</TABLE>
</div>
<hr color='red'/>
<table width=100%>
	<tr>
 <td style='text-align:left;'><a href='index.php'>Terug naar Hoofdmenu</a></td>
 </tr></table>


<h3 style='padding:10pt;font-size:14pt;color:green;'>Lijst SMS service berichten voor <?php echo $vereniging; ?> <img src = '../ontip/images/sms_bundel.jpg' width='60'></h3>


<?php
//// SQL Queries

$qry          = mysql_query("SELECT * From sms_confirmations  where Vereniging = '".$vereniging ."' and Toernooi = '' order by Laatst  ") ;  
$result       = mysql_fetch_array( $qry);

//  Koptekst

echo "<table  id='myTable1' style='border:2px solid #000000;box-shadow: 10px 10px 5px #888888;' cellpadding=0 cellspacing=0 ><tr>";
echo "<th style='". $th_style.";' width=30>Nr</th>";
echo "<th style='". $th_style.";'>Naam</th>";
echo "<th style='". $th_style.";'>Telefoon</th>";
echo "<th style='". $th_style.";'>Kenmerk</th>";
echo "<th style='". $th_style.";'>Omschrijving</th>";
echo "<th style='". $th_style.";'>Tijdstip</th>";
echo "</tr>";

/// Detail regels

$i=1;

while($row = mysql_fetch_array( $qry )) {

		echo "<tr>";
    echo "<td style='". $td_style_w.";' >". $i  . " </td>" ;
    echo "<td style='". $td_style_w.";'>". $row['Naam'] .  "</td>" ;
    echo "<td style='". $td_style_w.";'>". $row['Telefoon'] .  "</td>" ;
    echo "<td style='". $td_style_w.";'>". $row['Kenmerk'] .  "</td>" ;
    echo "<td style='". $td_style_w.";'>". $row['Vereniging_speler'] .  "</td>" ;
    echo "<td style='". $td_style_w.";'>". $row['Laatst'] .  "</td>" ;

echo "</tr>"; 

$i++;
}; //// end while
echo "</table><br><br>";
?>

<!--  Knoppen voor verwerking   ------->
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
</body>
</html>
