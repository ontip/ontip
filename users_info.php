<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/Basis.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Windows-1252" />

<title>User info</title>
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">

<style type="text/css"> 
body {color:black;font-family: Calibri, Verdana;font-size:14pt;}
h1   {color:red;}
h2   {color:red;}
th   {color:blue;font-size:9pt;font-family: sans-serif;font-weight:bold;;background-color:white;border-color:black;}
td   {color:black;font-size:9pt;font-family: sans-serif;background-color:white;border-color:black;padding:2pt;}
.verticaltext1    {font: 11px Arial;position: absolute;right: 5px;bottom: 35px;
                  width: 15px;writing-mode: tb-rl;color:black;}
</style>
</head>

 
<?php 
// Database gegevens. 
include('mysqli.php');
include('versleutel.php'); 
ob_start();
/* Set locale to Dutch */
setlocale(LC_ALL, 'nl_NL');

/// Als eerste kontrole op laatste aanlog. Indien langer dan half uur geleden opnieuw aanloggen

if(!isset($_COOKIE['aangelogd'])){ 
echo '<script type="text/javascript">';
echo 'window.location = "aanlog.php?key=UI"';
echo '</script>';
}

	
// Definieeer variabelen en vul ze met waarde uit tabel

$achtergrond_kleur = 'white';
$today = date('Y-m-d');

?>
<body bgcolor=<?php echo($achtergrond_kleur);?>>
<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);

echo "<table border =0 width=90%>"; 
echo "<tr><td style='background-color:".$achtergrond_kleur.";'><img src='".$url_logo."' width='".$grootte_logo.">";
echo "</td><td style='background-color:".$achtergrond_kleur.";'>";
echo "</td></tr></table>";

?>
<h2>Gebruikers </h2>
<?php
$totaal =0;
?>

<table id= 'MyTable3' border =1>
	<tr>
		<th>Nr</th>
		<th>Vereniging</th>
		<th>User</th>
		<th>Wachtwoord</th>
			<th>Email</th>
		<th>Laatste</th>
	</tr>
	
	
	
	<?php
	 	$sql        = mysqli_query($con,"SELECT * FROM namen   Order by Vereniging ");
	

$i=1;
while($row = mysqli_fetch_array( $sql )) {
 ?>
 <?php
 $wachtwoord = $row['Wachtwoord'];
 $decrypt = versleutel($wachtwoord);
 //echo versleutel($wachtwoord)."<br>";
 ?>
	 <tr>
	 	<td style='text-align:right;'><?php echo $i;?>.</td>
	 	<td><?php echo $row['Vereniging'];?></td>
	 	<td><?php echo $row['Naam'];?></td>
	  <td><?php echo $decrypt;?></td>
	  <td><?php echo $row['Email'];?></td>
	 	 <td><?php echo $row['Laatst'];?></td>
	 	
     
	</tr>
 
<?php	 
	$i++; 
};
?>

</table>
</body>
</html>