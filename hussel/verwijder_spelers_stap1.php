<html>
<head>
<title>Jeu de Boules Hussel (C) 2009  Erik Hendrikx</title>
<style type=text/css>
body {color:blue;font-size: 8pt; font-family: Comic sans, sans-serif, Verdana;background-color:white;  }
th {color:blue;font-size: 8pt;}
td {color:blue;font-size: 11pt;padding:3pt;}
h2 {color:blue;font-size: 12pt;padding:3pt;}
a {text-decoration:none;color:blue;padding-left:2px;padding-right:2pt;font-size:9pt;}


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
<a href = 'index.php'><img src='images/home.jpg' border=0 width='45' ><br>Terug naar score</a>
</td>
</tr>
</table>

<br>
	<h2>Verwijderen spelers</h2>
	

<br>
	<br>
	

<div style='text-align:left;color:black;font-size:11pt;font-family: Comic sans, sans-serif, Verdana'>Met behulp van deze functie kan je de deelnemers die aangevinkt zijn in de kolom Del verwijderen uit de Hussel.
	
<br>
<br>

De volgende spelers worden verwijderd als je Akkoord aanvinkt en op verwijderen klikt.
<br>
</div>


<form action='verwijder_spelers_stap2.php' method='post'>
	<blockquote>
<table width=50%  border =1 cellpadding=0 cellspacing =0>
	
	<?php
	$i=1;

$delete  = $_GET['Check'];
echo "<input type ='hidden' name = 'delete'  value = ".$delete."/>";

$deleteid = explode(';', $delete);
$aantal   = count($deleteid);
$aantal--;

$j=1;

for ($i=0;$i<$aantal;$i++){
		
	
		$qry  = mysql_query("SELECT * From hussel_score where Id = ".$deleteid[$i]."  ")     or die(' Fout in select');  
	  $row = mysql_fetch_array( $qry );

		
	?>
	<tr>
		<td><?php echo $j; ?>.</td>
		<td><?php echo $row['Naam']; ?></td>
	</tr>
	<?php
	$j++;
}
?>
	</table><br>
	<div style='font-size:11pt;color:black;'>
	<input type='checkbox'  name='verwijder_spelers' value='On'   />Akkoord om de bovenstaande spelers te verwijderen uit deze hussel. De lotnummers van de overige spelers worden geschoond.
	</div>
	
	<br><br><INPUT type='submit' value='Akkoord voor verwijderen'>
	<a href="index.php" style="text-decoration:none">
   <input type="button" value="Zonder te verwijderen terug naar score"/>
</a>
</blockquote>
</form>
	
	
	
	
	
	
	
	</table>



</body>
</html>

