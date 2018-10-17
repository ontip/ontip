<html>
<title>Email PHP Toernooi Inschrijvingen </title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<head>
	<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">                    
<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: Comic sans, sans-serif;background-color:white}
TH {color:black ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif; color:darkgreen;Font-Style:Bold;text-align: left; }
TD {color:blue ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif ;padding-left: 11px;}
a    {text-decoration:none;color:blue;}
h1 {color:orange ; font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h2 {color:blue ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
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
}
</script>
<script type="text/javascript">
function CopyToClipboard()
{
   CopiedTxt = document.selection.createRange();
   CopiedTxt.execCommand("Copy");
}
</script>

</head>
<body>
<?php
ob_start();
include 'mysql.php'; 
include ('../ontip/versleutel_string.php'); // tbv telnr en email


if (isset($_GET['toernooi'])){
 	  $toernooi = $_GET['toernooi'];
    //setcookie ("toernooi", $_GET['toernooi'] , time() +14400);
}
else { 
  	 if(isset($_COOKIE['toernooi'])){ 
        $toernooi        = $_COOKIE['toernooi'];   
       } 
} // end get
 

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


if ($rechten != "A"  and $rechten != "C"){
 echo '<script type="text/javascript">';
 echo 'window.location = "rechten.php"';
 echo '</script>'; 
}


// Ophalen toernooi gegevens
$qry2             = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  ")     or die(' Fout in select2');  

while($row = mysql_fetch_array( $qry2 )) {
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}

// uit vereniging tabel	
	
$qry          = mysql_query("SELECT * From vereniging where Vereniging = '".$vereniging ."'   ")     or die(' Fout in select');  
$row          = mysql_fetch_array( $qry );
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
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='240'></td>
<td STYLE ='font-size: 36pt; background-color:white;color:green ;'>Toernooi inschrijving <?php echo $_vereniging; ?></TD></tr>
<td STYLE ='font-size: 32pt; background-color:white;color:blue ;'> <?php echo $toernooi_voluit; ?></TD>
</tr>
</TABLE>
</div>
<hr color='red'/>

<span style='text-align:right;'><a href='index.php'>Terug naar Hoofdmenu</a></td></span>
<h3 style='padding:10pt;font-size:20pt;color:green;'>Email adressen van toernooi "<?php echo $toernooi_voluit; ?>" </h3>

<br><br>
<center>
<font color ="red">Klik op de Select knop.
Alle email adressen worden geselecteerd. Druk op CTRL+C en plak daarna de gekopieerde tekst met CTRL-V in het <b>BCC</b> veld van Outlook.</i><br></center></font>
<center>
	<br>
<div id="myTable1" style="border: red solid 1px;padding:10pt;padding-left:20pt;width:800pt;" width=70%>  

<?php

$inschrijf = mysql_query("SELECT * FROM inschrijf WHERE Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Email <> '' ") or die(mysql_error());  
echo "<table>";
echo "<tr><td height='100ptx' Style='background-color:white;'>";
$i =1;

// keeps getting the next row until there are no more to get
while($row = mysql_fetch_array( $inschrijf )) {
	// Print out the contents of each row into a table
	
	if ($row['Email'] =='[versleuteld]'){ 
$Email           = versleutel_string($row['Email_encrypt'] );    
}
else { 
	$Email = $row['Email'] ;
}
	
	
	echo $Email;
	// Zet er steeds een punt-komma tussen
	echo "&#59  "; 
  $i++;
  if ( $i > 6)
   { echo "<br/>";
     $i =1;
    };

} 
echo "</td></tr>";
echo "</table></div>";
?>
</div>
</center>
<!--  Knoppen voor verwerking   ----->
<center>
<TABLE>
	<tr><td valign="top" style='background-color:background-color:white;'> 
<form name="test2">
<input type="button" onClick="CopyToClipboard(SelectRange('myTable1'))" value="Select to clipboard" />
</form>
</td>
</tr>
</table>
</center>

</body>
</html>

