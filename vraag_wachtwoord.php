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
/// Zet vreemde tekens om in codering 

include 'mysqli.php'; 
//include 'convert_text_string.php'; 
$ip        = $_SERVER['REMOTE_ADDR'];
$sql      = mysqli_query($con,"SELECT Naam,Beheerder , Toernooi FROM namen WHERE  IP_adres = '".$ip."' and  Vereniging_id = ".$vereniging_id." and Aangelogd ='J'  ") or die(' Fout in select aantal');  
$result   = mysqli_fetch_array( $sql );
$naam     = $result['Naam'];


?>
<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = 'images/ontip_logo.png' width='240'></td>
<td STYLE ='font-size:36pt; background-color:white;color:green ;'>Toernooi inschrijving <?php echo $vereniging ?></TD>
</tr>
</TABLE>
</div>
<hr color='red'/>
<?php
echo "<span style='text-align:right;'><a href='index.php'>Terug naar Hoofdmenu</a></td></span>";
?>

<br><BR>
<center>
	<br>
<div style='border: blue inset solid 1px; width:1200px; left:140px;text-align: center;'>
<FORM action='send_wachtwoord.php' method='post'>

<input type='hidden' name ='vereniging' value = "<?php echo $vereniging; ?>"/> 
<input type="hidden" name="naam"           value="<?php echo $naam; ?>" /> 

<h3 style='padding:10pt;font-size:20pt;color:green;text-align:center;'>Opvragen wachtwoord</h3>

<table width=70%>
 <tr>
  <th style='color:blue;' width=40% >Gebruikersnaam </th> <td  style= 'border:1 pt solid black;'><?php echo $naam;?></td></tr>
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
<INPUT type='submit' value='Vraag wachtwoord'>
<br>
<div STYLE ='font size: 11pt;background-color:white;color:black;'><br>Nadat de naam gevonden is, wordt een mail met het wachtwoord gestuurd naar het mail adres dat bij de gebruikersnaam hoort. 
	</div>
</form>
</div>
</center>
</body>
</html>