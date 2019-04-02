<?php
# change_password.php
# Aanpassen wachtwoord beheerder ontip vereniging
# Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
#
# 2april2019          1.0.2            E. Hendrikx
# Symptom:   		    None.
# Problem:       	  None
# Fix:              None
# Feature:          PHP7.
# Reference: 
?>
<html>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<Title>OnTip Change password (c) Erik Hendrikx</title>
	<head>
		<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">                    
		<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: Comic sans, sans-serif;background-color:white}
TH {color:black ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif; color:darkgreen;Font-Style:Bold;text-align: left; }
TD {color:blue ; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif ;padding-left: 11px;}
h1 {color:green ; font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h2 {color:yellow ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
a    {text-decoration:none;color:blue;}

.verticaltext1    {font: 11px Arial;position: absolute;right: 5px;bottom: 15px;
                  width: 15px;writing-mode: tb-rl;color:green;}
// --></style>
</head>
<body>
 
<script type="text/javascript">
 var myverticaltext="<div class='verticaltext1'>Copyright by Erik Hendrikx © 2011</div>"
 var bodycache=document.body
 if ("bodycache && bodycache.currentStyle && bodycache.currentStyle.writingMode")
 document.write(myverticaltext)
 </script>
<?php

include 'mysqli.php'; 

?>
<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='240'></td>
<td STYLE ='font-size: 36pt; background-color:white;color:green ;'>Toernooi inschrijving <?php echo $vereniging ?></TD>
</tr>
</TABLE>
</div>
<hr color='red'/>

<span style='text-align:right;'><a href='index.php'>Terug naar Hoofdmenu</a></td></span>

<br>

<?php


if (isset ($_GET['naam'])){
$naam    = $_GET['naam'];
}
else { $naam = '';
}


$ip        = $_SERVER['REMOTE_ADDR'];
$sql      = mysqli_query($con,"SELECT Naam,Beheerder , Toernooi FROM namen WHERE  IP_adres = '".$ip."' and  Vereniging_id = ".$vereniging_id." and Aangelogd ='J'  ") or die(' Fout in select aantal');  
$result   = mysqli_fetch_array( $sql );
$naam     = $result['Naam'];
?>


<center>
	<h3 style='padding:10pt;font-size=20pt;color:green;'>Wijzigen wachtwoord</h3>
	
	<FORM action='send_chgpassword_link.php' method='post'>

<input type="hidden" name="Vereniging_id"  value="<?php echo $vereniging_id; ?>" /> 
<input type="hidden" name="Vereniging"     value="<?php echo $vereniging; ?>" /> 
<input type="hidden" name="naam"           value="<?php echo $naam; ?>" /> 



<table width=60% border=0>
 <tr>
 	<tr>
	<td  STYLE ='font-size: 11pt; background-color:white;color:blue ;'>Toegangscode </td>
 <td  style= 'border:1 pt solid black;'><?php echo $naam;?></td>
</tr>
  
<tr>
  <td class='varname'>Bestaand wachtwoord</td>
  <td class='content' ><input name= 'wachtwoord_bron' type='password' size='50'  value =''/></td>
 </tr>

<tr>
  <td class='varname'>Nieuw wachtwoord </td>
  <td class='content' ><input name= 'wachtwoord_new1' type='password' size='50'  value =''/></td>
</tr>

<tr>
  <td class='varname'>Nieuw wachtwoord nogmaals</td>
  <td class='content' ><input name= 'wachtwoord_new2' type='password' size='50'  value =''/></td>
 
</tr>

 <tr>
  <td colspan =2 style='text-align:center;'><br><INPUT type='submit' value='Verzenden'>
</td>
</tr>
  	
</table>

<table width=90%>

<tr>
	<td colspan =3 STYLE ='font-size: 10pt; background-color:white;color:black;'><br>Nadat op Verzenden gedrukt is, 
		wordt een mail met het wachtwoord gestuurd naar het email adres dat bij de toegangscode hoort. Via deze mail moet de wijziging geaccepteerd worden. <br><br>
			</td>
</tr>
</table>
</form>
</div>
</center>
</body>
</html>