<html>
	<Title>OnTip Change password (c) Erik Hendrikx</title>
	<head>
		<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">                    
		<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: Calibri, sans-serif;background-color:white}
TH {color:black ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif; color:darkgreen;Font-Style:Bold;text-align: left; }
TD {color:blue ; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif ;padding-left: 11px;}
h1 {color:green ; font-size: 16.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h2 {color:yellow ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
a    {text-decoration:none;color:blue;}

// --></style>
</head>
<body>
<?php
ob_start();

// Database gegevens. 
include('mysql.php');
include 'versleutel.php'; 

?>
<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = 'images/ontip_logo.png' width='240'></td>
<td STYLE ='font-size: 36pt; background-color:white;color:green ;'>Toernooi inschrijving <?php echo $vereniging ?></TD>
</tr>
</TABLE>
</div>
<hr color='red'/>

<span style='text-align:right;'><a href='index.php'>Terug naar Hoofdmenu</a></td></span>

<h1>Wijziging wachtwoord</h1>


<?php

$id         = $_GET['id'];
$key_long   = $_GET['key'];

$key       = substr($key_long,0,14);
$userid    = trim(substr($key_long,14,80));

//echo $userid;

//echo $beheerder;
//                    jjjjmmddhhmmss
// uiteenrafelen key  01234567890123

$jaar    = substr($key,0,4);
$maand   = substr($key,4,2);
$dag     = substr($key,6,2);
$uur     = substr($key,8,2);
$minuut  = substr($key,10,2);
$seconde = substr($key,12,2);

// als key minder dan half uur geleden dan mag er gewijzigd worden

$tijdstip = mktime ($uur, $minuut+30, $seconde, $maand, $dag, $jaar);

$grens_waarde = date ("YmdHis",$tijdstip)   ; 

$nu = date("YmdHis");
$sql           = mysql_query("SELECT * FROM config WHERE Id='".$id."'  and Regel = 9998  and Variabele = 'password_key' and ".$nu."  between  ".$key." and  ".$grens_waarde."") or die(' Fout in select');  
$result        = mysql_fetch_array( $sql );
$encrypt       = $result['Parameters'];
$naam          = $result['Toernooi'];
$vereniging_id = $result['Vereniging_id'];


// Mysql_num_row is counting table row
$count=mysql_num_rows($sql);
// If result matched $myusername and $mypassword, table row must be 1 row

if ($count == 1){
// echo "<br><br>Wachtwoord aanpassing gevonden.<br>";
 //echo "Userid ".$userid.".<br>";
// Wijzig wachtwoord

$sql2      = mysql_query("SELECT * FROM namen WHERE Vereniging_id = '".$vereniging_id."' and Naam ='".$naam."' ") or die(' Fout in select namen');  
$result2   = mysql_fetch_array( $sql2 );
$id_naam   = $result2['Id'];


mysql_query("Update namen set Wachtwoord = '".$encrypt."', Laatst= now()  where Id = ".$id_naam." ")  or die(' Fout in update');    
mysql_query("DELETE from config where Id = '".$id ."' ")   or die(' Fout in delete');  

?>
<script language="javascript">
        alert("Het wachtwoord van  <?php echo $naam; ?> is gewijzigd.")
    </script>
  <script type="text/javascript">
       window.close(); 
		</script>
<?php 
}
 else {?>
 	
<script language="javascript">
        alert("Het wachtwoord van  <?php echo $naam; ?> kon niet gewijzgd worden of de tijdslimiet is verstreken.")
    </script>
  <script type="text/javascript">
       window.close(); 
		</script>
<?php 
 
 
}

ob_end_flush();
?> 