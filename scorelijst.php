<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css" media="print">
body {color:blue;font-size: 9pt; font-family: Comic sans, sans-serif, Verdana;background-color:white;  }
th {color:brown;font-size: 10pt;vertical-align:bottom;}
td {color:brown;font-size: 10pt;}
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
$datum = $_GET['datum'];

//// 2015-05-19
//// 01234567890

$jaar =  substr($datum, 0,4);
$maand =  substr($datum, 5,2);
$dag =  substr($datum, 8,2);



echo "<div style='border: red solid 1px;padding-left:5px;height:100;valign:middle;'>";  
echo"<h1>Eindstand Hussel ";
echo strftime("%A %d %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) );
echo "</h1>"; 
echo "</div>";

// Sorteer eerst op winst en dan op saldo
$score     = mysqli_query($con,"SELECT * From hussel_score WHERE Datum = '".$datum."'
                            ORDER BY Winst DESC , Saldo DESC" )       or die(mysql_error());  
?>
<table class='noprint'>
<tr>
	<td class='noprint' onclick="window.print()"><img src='images/printer.jpg' border =0 width = 50 alt= 'Print pagina'></td> 		
<td valign='center' >
<a class='noprint'  href ='index.php'><img src='images/home.jpg' id='home' onmouseover='img_uitzetten(1)' onmouseout='img_aanzetten(1)' class='noprint' width=35 border='0' alt='Terug naar begin'></a>
</td></tr><tr>
<td class='noprint' Style='font-size:8pt;color:blue;text-align:center;padding:1pt;'>Print<br>deze pagina</td>
<td class='noprint' Style='font-size:8pt;color:blue;text-align:center;padding:1pt;'>Terug<br>naar hussel</td>
</tr>
</table>

<br>
<br>

<table border='1' font='Arial' fontcolor='Red'>
<tr> <th width='10'>Nr</th>
      <th width='200'>Naam</th>
      <th width='150'>Winst</th>
      <th width='150'>Saldo</th>
      </tr>
      
<?php

$i = 1;


// keeps getting the next row until there are no more to get
while($row = mysqli_fetch_array( $score )) {
	// Print out the contents of each row into a table
	echo "<tr><td>$i</td><td>"; 
	echo $row['Naam'];
	echo "</td><td Style= 'text-align: right;padding 5pt;'>"; 
	echo $row['Winst'];
	echo "</td><td Style= 'text-align: right;padding 5pt;'>"; 
	echo $row['Saldo'];
	echo "</td></tr>"; 
 $i++;
} 

echo "</table>";

?>

</body>
</html>
