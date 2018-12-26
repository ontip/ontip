<html>
<head>
<title>Jeu de Boules Hussel (C) 2009  Erik Hendrikx</title>
<style type=text/css>
body {color:blue;font-size: 8pt; font-family: Comic sans, sans-serif, Verdana;background-color:white;  }
th {color:blue;font-size: 11pt;}
td {color:black;font-size: 11pt;padding:3pt;}
h2 {color:blue;font-size: 12pt;padding:3pt;}
a {text-decoration:none;color:blue;padding-left:2px;padding-right:2pt;font-size:9pt;}
</style>
</head>
<body>

<?php
ob_start();
include 'mysql.php'; 


$dag   = 	substr ($datum , 8,2); 
$maand = 	substr ($datum , 5,2); 
$jaar  = 	substr ($datum , 0,4); 


if ($jaar <> date('Y') ){
	$datum_string = strftime("%a %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) );
} else {
	$datum_string = strftime("%A %e %B ", mktime(0, 0, 0, $maand , $dag, $jaar) );
}	
	
	
echo "<table width=80%>";
echo "<tr>";
echo "<td>";

echo "<a href = 'index.php'><img src = 'http://www.boulamis.nl/boulamis_toernooi/hussel/images/OnTip_hussel.png' width='200'></a>";

echo"<br><span style='margin-left:15pt;font-size:12pt;font-weight:bold;color:darkgreen;'>".$vereniging."</span></td>";
echo "<td width=70%><h1 style='color:blue;font-weight:bold;font-size:32pt; text-shadow: 3px 3px darkgrey;'>";

if ($voorgeloot == 'On') {
	
$qry                 = mysql_query("SELECT * From hussel_config  where Vereniging_id = '".$vereniging_id ."' and Variabele = 'voorgeloot'  ") ;  
$result              = mysql_fetch_array( $qry);
$toernooi            = $result['Parameters'];	

echo $toernooi . " ". $datum_string."</h1></td>";
} else {
echo "Hussel ". $datum_string."</h1></td>";
}
echo "</tr>";
echo "</table>";
echo "<hr style='border:1 pt  solid red;'/>";
?>

<table width=60%>
<tr><td valign='center'  >
<a style= 'font-size:8pt;color:blue;' href = 'index.php'><img src='images/home.jpg' border=0 width='45' ><br>Terug naar score</a>
</td>
</tr>
</table>

<br>
	<h2>Printen oude hussels</h2>
<br>
	

<div style='text-align:left;color:black;font-size:11pt;font-family: Comic sans, sans-serif, Verdana'>Met behulp van deze functie kan je oude hussel scores printen uit de Hussel. 
	<br>
<br>

Klik op de datum om de uitslag van die hussel te tonen
<br>
</div>


	<blockquote>
<table width=50%  border =1 cellpadding=0 cellspacing =0>
	<tr>
		<th>Nr</th>
	 	<th>Datum</th>
	  <th>Aantal deelnemers</th>
	  <th>Gebruikt in </th>
  </tr>
  
  
	<?php
	$i=1;
	
	$qry  = mysql_query("SELECT Datum, count(*) as Aantal From hussel_score where Vereniging_id = ".$vereniging_id ." group by Datum order by Datum  ")     or die(' Fout in select');  
	while($row = mysql_fetch_array( $qry )) {
		
	  $aantal       = $row['Aantal'];
		$naam_serie   = '';
	
		$sql_datums   = mysql_query("SELECT * FROM hussel_serie WHERE  Vereniging_id = ".$vereniging_id." and Datum = '".$row['Datum']."'  ") or die(' Fout in select datums'); 
    $result       = mysql_fetch_array( $sql_datums );
    $naam_serie   = $result['Naam_serie'];
    
	?>
	<tr>
		<td style='text-align:right;'><?php echo $i; ?>.</td>
		<td style='text-align:center;color:blue;font-weight:bold;'><a href = 'scorelijst.php?datum=<?php echo $row['Datum']; ?>'  target='_top'><?php echo $row['Datum']; ?></a></td>
   	<td style='text-align:right;padding-right:5pt;'><?php echo $aantal; ?></td>
	 	<td><?php echo $naam_serie; ?></td>
		
	</tr>
	<?php
	$i++;
}
?>
	</table><br>
	
	
	
</blockquote>

	
	
</body>
</html>

