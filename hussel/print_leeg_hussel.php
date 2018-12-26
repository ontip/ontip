<html>
<head>
<title>Jeu de Boules Hussel (C) 2009  Erik Hendrikx</title>
<style type="text/css" media="print">
body {color:blue;font-size: 12pt; font-family: Comic sans, sans-serif, Verdana;background-color:white;  }
th {color:black;font-size: 10pt;vertical-align:bottom;}
td {color:black;font-size: 12pt;}
.noprint {display:none;}     

#leeg            {color:white;padding-top:2pt;padding-bottom:2pt;}
#onderschrift    {font-size:8pt;color:blue;text-align:center;padding:0pt;}

</style>



</head>
<body>


<?php
ob_start();

if (isset($_POST['Aantal_rows'])){   
$aant_rows = $_POST['Aantal_rows'];            ///// aantal regels in tabel 
}
else {
$aant_rows =0;
}

if (isset($_POST['Aantal_cols'])){   
$aant_cols = $_POST['Aantal_cols'];            ///// aantal kolommen in tabel 
}
else {
$aant_cols =0;
}
include ('mysql.php');

//// 2015-05-19
//// 01234567890

$jaar =  substr($datum, 0,4);
$maand =  substr($datum, 5,2);
$dag =  substr($datum, 8,2);

if ($voorgeloot == 'On') {
$score     = mysql_query("SELECT * From hussel_score WHERE Vereniging_id = ".$vereniging_id." and Datum = '".$datum."' and Naam <> ''  ORDER BY Lot_nummer " )     or die(mysql_error());  
} else { 
$score     = mysql_query("SELECT * From hussel_score WHERE Vereniging_id = ".$vereniging_id." and Datum = '".$datum."'  and Naam <> '' ORDER BY Naam " )     or die(mysql_error());  
}



echo "<table width=80%>";
echo "<tr>";
echo "<td><img src = 'http://www.boulamis.nl/boulamis_toernooi/hussel/images/OnTip_hussel.png' width='80'><br><span style='margin-left:15pt;font-size:10pt;font-weight:bold;color:darkgreen;'>".$vereniging."</span></td>";
echo "<td width=70%><h1 style='color:blue;font-weight:bold;font-size:10pt; text-shadow: 2px 2px darkgrey;text-align:center;'>INVUL LIJST UITSLAGEN<br>". strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )."</h1>";
echo "</table>";


?>
<table class='noprint'>
<tr>
	<td class='noprint' onclick="window.print()"><img src='images/printer.jpg' border =0 width = 50 alt= 'Print pagina'></td> 		
<td valign='center' >
<a class='noprint'  href ='index.php'><img src='images/home.jpg' id='home' onmouseover='img_uitzetten(1)' onmouseout='img_aanzetten(1)' class='noprint' width=35 border='0' alt='Terug naar begin'></a>
</td></tr><tr>
<td class='noprint' Style='font-size:8pt;color:blue;text-align:center;padding:1pt;'>Print<br>deze pagina</td>
<td class='noprint' Style='font-size:8pt;color:blue;text-align:center;padding:1pt;'>Terug<br>naar scores</td>
</tr>
</table>

<?php



echo "<table border=2>";

////// Kop van de tabel (2 regels)

echo "<tr>";
echo "<th colspan = 2></th>";

for ($i=1; $i<=$aant_cols;$i++){
echo "<th  colspan =3>Ronde ". $i . "</th>";
}
echo "<th colspan = 2>Totaal</th>";
echo "</tr>";

echo "<tr>";

echo "<th width=40>Nr</th>";
echo "<th width=340>Naam</th>";

for ($i=1; $i<=$aant_cols;$i++){
echo "<th width=40>V</th>";
echo "<th width=40>T</th>";
echo "<th width=40>Score</th>";
}

echo "<th width=40>Winst</th>";
echo "<th width=40>Saldo</th>";
echo "</tr>";

/// detail regels

for ($j=1; $j<=$aant_rows;$j++){

 echo "<tr>";
 echo "<td>" . $j . "</td>";                        /// automatische nummering 
 echo "<td width=40 id='leeg'>.</td>";                         /// tbv naam

 for ($i=1; $i<=$aant_cols;$i++){ 
    echo "<td width=40 id='leeg'>.</td>";                              /// kolom V
    echo "<td width=40 id='leeg'>.</td>";                              /// kolom T
    echo "<td width=40 id='leeg'>.</td>";                              /// kolom Score
 }
echo "<td width=40 id='leeg'> .</td>";                              /// kolom winst
echo "<td width=40 id='leeg'> .</td>";                              /// kolom saldo
echo  "</tr>";

}
echo "</table>";

ob_end_flush();
?>
</body>

</html>
