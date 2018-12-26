<html>
<head>
<title>Jeu de Boules Hussel (C) 2009  Erik Hendrikx</title>
<style type=text/css>
body {color:blue;font-size: 8pt; font-family: Comic sans, sans-serif, Verdana;background-color:white;  }
th {color:blue;font-size: 8pt;}
td {color:blue;font-size: 10pt;}
a {text-decoration:none;color:blue;padding-left:2px;padding-right:2pt;font-size:12pt;}


#tot   {background-color:lightblue;font-weight:bold;} 
#tegen {color:red;font-weight:bold;}
#leeg  {color:white;}
#naam  {Font-weight:bold;font-size:12pt;padding-left:5pt;}
#alert {right;padding:2pt; background-color:red;}
#norm  {text-align: right;padding:2pt; color:blue;}
#score {text-align: right;padding:2pt; color:black;font-weight:bold;}
#onderschrift     {font-size:8pt;color:blue;text-align:center;padding:0pt;}

</style>
</head>
<body>

<?php
ob_start();
include 'mysql.php'; 


$dag   = 	substr ($datum , 8,2); 
$maand = 	substr ($datum , 5,2); 
$jaar  = 	substr ($datum , 0,4); 


echo "<table width=80%>";
echo "<tr>";
echo "<td><img src = 'http://www.boulamis.nl/boulamis_toernooi/hussel/images/OnTip_hussel.png' width='200'><br><span style='margin-left:15pt;font-size:12pt;font-weight:bold;color:darkgreen;'>".$vereniging."</span></td>";
echo "<td width=70%><h1 style='color:blue;font-weight:bold;font-size:32pt; text-shadow: 3px 3px darkgrey;'>Hussel ". strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )."</h1></td>";
echo "</tr>";
echo "</table>";
echo "<hr style='border:1 pt  solid red;'/>";
?>

<table width=60%>
<tr><td valign='center'  >
<a href = 'index.php'><img src='images/home.jpg' border=0 width='45' ></a>
</td>
<td style='text-align:center;'>
	<h2>Aanpassen instellingen</h2>
	</td></tr>
</table>

<?php 
echo "<tr>";

	$qry  = mysql_query("SELECT * From hussel_config where Vereniging_id = ".$vereniging_id ." and Variabele ='datum_lock' ")     or die(' Fout in select');  
	$result     = mysql_fetch_array( $qry );
	$datum_lock =  $result['Waarde']; 

if ($datum_lock == 'On'){	
	$datum   = $result['Parameters'];
} else {
   $datum = date ('Y')."-".date('m')."-".date('d');
}
$vandaag = date ('Y')."-".date('m')."-".date('d');

?>
<table width=80%    border = 1 cellspacing = 0 cellpadding=0>
	<?php
echo "<tr Style='color:blue;padding-left:2px;padding-right:2pt;'></tr><tr><br><td Style='text-align:center;color:blue;padding-left:2px;padding-right:2pt;border-top:1pt;font-size:9pt;'>";
if ($aantal_rondes == 3){
echo "<img src='images/3rondes.png' height=40><br>rondes";
} else {
echo "<img src='images/5rondes.png' height=40><br>rondes";
}
echo "</td>";
echo "<td  style='text-align:bottom;'><form action='muteer_rondes.php' method='post'><span style='color:black;font-weight:bold;'>Hiermee kan het aantal spelrondes aangepast worden. Zet een vinkje bij de gewenste keuze klik op de knop.</span><br><br>";


if ($aantal_rondes  == 3) {
	 echo "<input type='radio'  name='aantal_rondes' value='3'  checked /> Aantal rondes : 3";
	echo "<br><input type='radio'          name='aantal_rondes' value='5'           /> Aantal rondes : 5";
 
	echo "<br><br><INPUT type='submit' value='Aanpassen'>";
}
else {
  echo "<br><input type='radio'  name='aantal_rondes' value='3'          /> Aantal rondes : 3";
 	echo "<br><input type='radio'          name='aantal_ronde2' value='5'  checked /> Aantal rondes : 5";
 
	echo "<br><br><INPUT type='submit' value='Aanpassen'>";
}
echo "</form>";
echo "</td>";
echo "</tr>";

?>

<?php
echo "<tr Style='color:blue;padding-left:2px;padding-right:2pt;'>";
echo "<td Style='text-align:center;color:blue;padding-left:2px;padding-right:2pt;font-size:9pt;'><img src='images/datum.png' height=40><br>Datum vastzetten</td>";
echo "<td  style='text-align:bottom;'><form action='muteer_datum.php' method='post'><span style='color:black;font-weight:bold;'>Hiermee kan de datum van de hussel aangepast worden (standaard gelijk aan vandaag)<br> Zet een vinkje bij de gewenste keuze, vul evt een afwijkende datum in en klik op de knop.</span><br><br>";


if ($datum_lock == 'On') {
	echo "<input type='radio'  name='lock' value='0'   /> Gelijk aan ".$vandaag." (vandaag, vervolgens automatisch aangepast) .";
  echo "<br><br><input type='radio'  name='lock' value='1'  checked /> Gelijk aan .";
	echo "<input name='datum' type='text' size=10 value='".$datum."' > ";
  echo "<br><br><INPUT type='submit' value='De-activeren'>";
}
else {
  	echo "<input type='radio'  name='lock' value='0' checked  /> Gelijk aan ".$vandaag." (vandaag, vervolgens automatisch aangepast) .";
    echo "<br><br><input type='radio'  name='lock' value='1' /> ";
  	echo "Vaste waarde :  <input name='datum' type='text' size=10 value='".$datum."' > (formaat :  jjjj-mm-dd bijv 2015-09-17)";
    echo "<br><br><INPUT type='submit' value='Aanpassen en activeren'> ";
}
echo "</form>";
echo "</td>";
echo "</tr>";
?>

<?php
echo "<tr Style='color:blue;padding-left:2px;padding-right:2pt;'><td Style='text-align:center;color:blue;padding-left:2px;padding-right:2pt;border-top:1pt;font-size:9pt;'>";
if ($controle_13=='Auto'){
echo "<img src='images/max13aan.jpg' height=50><br>Controle 13";
} else {
echo "<img src='images/max13uit.jpg' height=50><br>Controle 13";
}

echo "</td>";


echo "<td  style='text-align:bottom;'><form action='muteer_check13.php' method='post'><span style='color:black;font-weight:bold;'>Hiermee kan het automatisch invullen van de waarde 13 in de hussel aan of uit gezet worden.Zet een vinkje bij de gewenste keuze klik op de knop.</span><br><br>";


if ($controle_13 == 'Auto') {
	echo "<input type='radio'          name='controle_13' value='0'           /> Automatisch invullen niet actief";
  echo "<br><br><input type='radio'  name='controle_13' value='1'  checked /> Automatisch invullen  actief";
	echo "<br><br><INPUT type='submit' value='Uitschakelen'>";
}
else {
 	echo "<input type='radio'          name='controle_13' value='0'  checked /> Automatisch invullen niet actief";
  echo "<br><br><input type='radio'  name='controle_13' value='1'          /> Automatisch invullen  actief";
	echo "<br><br><INPUT type='submit' value='Inschakelen'>";
}
echo "</form>";
echo "</td>";
echo "</tr>";

?>

<?php
echo "<tr Style='color:blue;padding-left:2px;padding-right:2pt;'>";
echo "<td Style='text-align:center;color:blue;padding-left:2px;padding-right:2pt;font-size:9pt;'><img src='images/lottery.jpg' height=60><br>Voorgeloot</td>";
echo "<td  style='text-align:bottom;'><form action='muteer_loterij.php' method='post'><span style='color:black;font-weight:bold;'>Indien dit programma gebruikt wordt voor de administratie van voorgelote partijen, kan in het hussel scherm een kolom worden toegevoegd voor de uitgegeven lotnummers.<br> Zet een vinkje bij de gewenste keuze en klik op de knop.</span><br><br>";



if ($lotnummers == 'On') {
	echo "<input type='radio'          name='lotnummers' value='0'           /> Lotnummers niet actief";
  echo "<br><br><input type='radio'  name='lotnummers' value='1'  checked /> Lotnummers actief";
	echo "<br><br><INPUT type='submit' value='Uitschakelen'>";
}
else {
 	echo "<input type='radio'          name='lotnummers' value='0'  checked /> Lotnummers niet actief";
  echo "<br><br><input type='radio'  name='lotnummers' value='1'          /> Lotnummers actief";
	echo "<br><br><INPUT type='submit' value='Inschakelen'>";
}
echo "</form>";
echo "</td>";
echo "</tr>";

?>

<tr Style='color:blue;padding-left:2px;padding-right:2pt;height:50pt;'>
	  <td Style='text-align:center;color:blue;padding-left:8px;padding-right:2pt;border-top:1pt;font-size:9pt;'><img src='images/hussel_serie.png' height=40><br>Hussel serie</td>
    <td><a style='padding-left:8px;color:black;font-weight:bold;font-size:10pt;' href='beheer_datums_hussel_serie_stap1.php'>Klik hier voor Muteren of Verwijderen datums voor Hussel serie.</a>
</td>
</tr>

<tr Style='color:blue;padding-left:2px;padding-right:2pt;height:50pt;'>
	  <td Style='text-align:center;color:blue;padding-left:8px;padding-right:2pt;border-top:1pt;font-size:9pt;'><img src='images/people.png' height=40><br>Aanpassen spelers</td>
    <td><a style='padding-left:8px;color:black;font-weight:bold;font-size:10pt;' href='beheer_spelers.php'>Klik hier voor Muteren of verwijderen Spelers in Tabel Spelers.</a>
</td>
</tr>

<tr Style='color:blue;padding-left:2px;padding-right:2pt;height:50pt;'>
	  <td Style='text-align:center;color:blue;padding-left:8px;padding-right:2pt;border-top:1pt;font-size:9pt;'><img src='images/icon_import.png' height=40><br>Importeren spelers</td>
    <td><a style='padding-left:8px;color:black;font-weight:bold;font-size:10pt;' href='import_spelers_stap1.php'>Klik hier voor Importeren namen in Tabel Spelers vanuit csv file.</a>
</td>
</tr>

<tr Style='color:blue;padding-left:2px;padding-right:2pt;height:50pt;'>
	  <td Style='text-align:center;color:blue;padding-left:8px;padding-right:2pt;border-top:1pt;font-size:9pt;'><img src='images/upload_ontip.png' height=40><br>Importeren spelers</td>
    <td><a style='padding-left:8px;color:black;font-weight:bold;font-size:10pt;' href='import_spelers_ontip_stap1.php'>Klik hier voor Importeren namen in Tabel Spelers vanuit OnTip toernooi.</a>
</td>
</tr>
<tr>
<td colspan =2><img src='images/dbase.jpg' width='50'><a href='delete_hussel.php'>Verwijder hussels ouder dan 1 jaar.</a>
</td>
</tr>
</tr>
</table>

</table>

</body>
</html>

