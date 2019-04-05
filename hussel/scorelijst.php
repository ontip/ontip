<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css" media="print">
body {color:blue;font-size: 9pt; font-family:Verdana;background-color:white;  }
th {color:black;font-size: 14t;vertical-align:bottom;padding:5pt;}
td {color:black;font-size: 11pt;padding:4pt;}
h1 {color:blue ; font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h2 {color:blue ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h3 {color:orange ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
.noprint {display:none;}     

.onderschrift     {font-size:8pt;color:blue;text-align:center;padding:1pt;}

</style>
</head>
<!---/// Mouse over voor aan/uit zetten images--->

<script type="text/javascript">
function img_uitzetten(i){
	      i = parseInt(i);
        switch (i)
        {
        case 1:
           document.getElementById('home').src="images/homeoff.jpg";break;
        case 2:
           document.getElementById('print').src="images/printer.jpg";break;
        case 3:
           document.getElementById('save').src="images/diskette1.jpg";break;
        }
}

</script>

<script type="text/javascript">
function img_aanzetten(i){
        i = parseInt(i);
        switch (i)
        {
        case 1:
           document.getElementById('home').src="images/home.jpg";break;    
        case 2:
           document.getElementById('print').src="images/printerleeg.jpg";break;  
        case 3:
           document.getElementById('save').src="images/diskette2.jpg";break;

         }
}

</script>
<body>
	

<?php

//// Database gegevens. 

include ('mysqli.php');
ini_set('default_charset','UTF-8');
setlocale(LC_ALL, 'nl_NL');

$datum= $_GET['datum'];


//// 2015-05-19
//// 01234567890

$jaar =  substr($datum, 0,4);
$maand =  substr($datum, 5,2);
$dag =  substr($datum, 8,2);


echo "<table width=80%>";
echo "<tr>";
echo "<td><img src = 'images/OnTip_hussel.png' width='80'><br><span style='margin-left:15pt;font-size:10pt;font-weight:bold;color:darkgreen;'>".$vereniging."</span></td>";
echo "<td width=70%><h1 style='color:blue;font-weight:bold;font-size:26pt; text-shadow: 2px 2px darkgrey;text-align:center;'>Eindstand Hussel<br>
     <span style='color:darkgreen;font-weight:bold;font-size:18pt; text-shadow: 2px 2px darkgrey;'>". strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )."</span></h1>";
echo "</table>";


// Sorteer eerst op winst en dan op saldo
$score     = mysqli_query($con,"SELECT * From hussel_score WHERE Datum = '".$datum."' and Vereniging_id = ".$vereniging_id."                            ORDER BY Winst DESC , Saldo DESC" )       or die(mysql_error());  
?>
<table class='noprint'>
<tr>
	<td class='noprint' onclick="window.print()"><img src='images/printer.jpg' border =0 width = 50 alt= 'Print pagina'></td> 		
	<td class='noprint' onclick="window.location.href='scorelijst_csv.php?datum=<?php echo $datum;?>'"><img src='images/icon_excel.png' border =0 width = 50 alt= 'Export naar Excel'></td> 		
<td valign='center' >
<a class='noprint'  href ='index.php'><img src='images/home.jpg' id='home' onmouseover='img_uitzetten(1)' onmouseout='img_aanzetten(1)' class='noprint' width=35 border='0' alt='Terug naar begin'></a>
</td></tr><tr>
<td class='noprint' Style='font-size:9pt;color:blue;text-align:center;padding:1pt;'>Print<br>deze pagina</td>
<td class='noprint' Style='font-size:9pt;color:blue;text-align:center;padding:1pt;'>Lijst naar<br>Excel</td>
<td class='noprint' Style='font-size:9pt;color:blue;text-align:center;padding:1pt;'>Terug<br>naar scores</td>
</tr>
</table>


<br>
<br>

<blockquote><table border = 1 Style='empty-cells: show;background-color:white;border:1px solid #000000;' cellpadding=0 cellspacing=0'  width=90%>
	
<tr> <th width='10'>Nr</th>
	
	<?php
	if ($voorgeloot == 'On') {
echo " 	  <th Style='width=4;'>Lot</th>"; 
}
?>
      <th width='200'>Naam</th>
      <th width='150'>Winst</th>
      <th width='150'>Saldo</th>
      </tr>
      
<?php

$i = 1;


// keeps getting the next row until there are no more to get
while($row = mysqli_fetch_array( $score )) {
	// Print out the contents of each row into a table
	echo "<tr><td Style='width:25pt;text-align:right;'>".$i.".</td>";
	
	
	
	  if ($voorgeloot == 'On') {
     echo "<td Style='width:25pt;text-align:right;'>";  
      echo $row['Lot_nummer'];
      echo ".</td>";  
  }
  
  
	
	
	echo "<td>".$row['Naam'];
	echo "</td><td Style= 'text-align: right;padding 5pt;'>"; 
	echo $row['Winst'];
	echo "</td><td Style= 'text-align: right;padding 5pt;'>"; 
	echo $row['Saldo'];
	echo "</td></tr>"; 
 $i++;
} 

echo "</table>";

?>
<br><br>
<div style='text-align:right;margin-right:35pt;'>
<em style='font-size:5pt;color:darkgrey;'>OnTip hussel is een programma gemaakt door Erik Hendrikx (c) <?php echo date('Y'); ?></em>
</div>
</blockquote>

</body>
</html>
