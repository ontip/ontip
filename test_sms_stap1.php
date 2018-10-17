<html>
	<Title>OnTip Inschrijvingen (c) Erik Hendrikx</title>
	<head>
		<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">                    
		<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: Comic sans, sans-serif;background-color:white}
TH {color:blue ;background-color:white; font-size: 10pt ; font-family:Arial, Helvetica, sans-serif;Font-Style:Bold;text-align: left; }
TD {color:black ;background-color:white; font-size:10pt ; font-family:Arial, Helvetica, sans-serif ;padding-left: 11px;}
a    {text-decoration:none;color:blue;}

// --></style>
</head>
<body>
 
<?php
include 'mysql.php'; 
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



?>
<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = 'images/ontip_logo.png' width='240'></td>
<td STYLE ='font-size:36pt; background-color:white;color:green ;'>Toernooi inschrijving <?php echo $vereniging ?></TD>
</tr>
</TABLE>
</div>
<hr color='red'/>
<span style='text-align:right;'><a href='index.php'>Terug naar Hoofdmenu</a></td></span>

<br><BR>
<center>
	<br>
<div style='border: blue inset solid 1px; width:1200px; left:140px;text-align: center;'>

<h3 style='padding:10pt;font-size:20pt;color:green;text-align:center;'>Test SMS bericht</h3>


<?php
$qry    = mysql_query("SELECT * from vereniging where Vereniging = '".$vereniging."' ")           or die(' Fout in select 1');  
$result  = mysql_fetch_array( $qry);
$url_website    = $result['Url_website'];
$verzendadres_sms       = $row['Verzendadres_SMS'];
?>

<?php if ($verzendadres_sms !=''){?>

<FORM action='test_sms_stap2.php' method='post'>

<table width=70%>
 <tr>
  <th style='color:blue;' width=40% >Mobiel nummer voor ontvangst test bericht</th> 
        <td  style= 'border:1 pt solid black;'><input TYPE="TEXT" NAME="Tel_nummer" SIZE="10" > </td></tr>
  	
  	
  	
<th Style='font-family:arial;font-size:9pt;color:blue;'><br>Anti Spam</th>
        <td colspan = 2 Style='font-family:arial;font-size:10pt;color:green;'><input TYPE="TEXT" NAME="respons" SIZE="5" >  <- Neem onderstaande code uit grijze vlak over 
        	
	<?php
	///////////   Anti spam routine ////////////////////////////////////////////////////////////////////////////////////////
	$length = 4; 
	  if( !isset($string )) { $string = '' ; }
	  
//    $characters = "23456789abcdefhijkmnprstuvwxyABCDEFG-+";
    $characters = "12345678901234567890";
    
    
    while ( strlen($string) < $length) { 
        $string .= $characters[mt_rand(1, strlen($characters))];
    }
    
    
   echo "<div style= 'font-size:14pt; color:black;background-color:lightgrey;width:55pt;text-align:center;font-family:courier;'>". $string."</div>";
   echo "<input type='hidden' name='challenge'    value='". $string. "' /> "; 
   
   $string = "";    
?>
</td></tr></table>
<br>
<INPUT type='submit' value='Stuur test bericht'>
<br>
</form>

<?php } else { ?>

<div style= 'font-size:14pt; color:red;background-color:white;text-align:center;font-family:courier;'>De SMS dienst is niet actief voor <?php echo $vereniging ?> </div>

<?php } ?>
</center>
</body>
</html>