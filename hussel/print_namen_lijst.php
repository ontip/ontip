<html>
<head>
<title>Jeu de Boules Hussel (C) 2009  Erik Hendrikx</title>
<style type="text/css" media="print">
body {color:blue;font-size: 12pt; font-family: Comic sans, sans-serif, Verdana;background-color:white;  }
th {color:black;font-size: 10pt;vertical-align:bottom;}
td {color:black;font-size: 12pt;}
.noprint {display:none;}     

#leeg          {color:white;padding-top:9pt;padding-bottom:9pt;}
#onderschrift     {font-size:8pt;color:blue;text-align:center;padding:0pt;}

</style>


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
         }
}

</script>
</head>
</body>

	
<?php
/// Deze php haalt de gegevens van een vorige hussel op
//// Database gegevens. 

//// Database gegevens. 

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
echo "<td><img src = 'images/OnTip_hussel.png' width='80'><br><span style='margin-left:15pt;font-size:10pt;font-weight:bold;color:darkgreen;'>".$vereniging."</span></td>";
echo "<td width=70%><h1 style='color:blue;font-weight:bold;font-size:10pt; text-shadow: 2px 2px darkgrey;text-align:center;'>NAMEN LIJST HUSSEL<br>". strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )."</h1>";
echo "</table>";


?>
<table class='noprint'>
<tr>
	<td class='noprint' onclick="window.print()"><img src='images/printer.jpg' border =0 width = 55 alt= 'Print pagina'></td> 		
<td valign='center' >
<a class='noprint'  href ='index.php'><img src='images/home.jpg'width = 55  id='home' onmouseover='img_uitzetten(1)' onmouseout='img_aanzetten(1)' class='noprint' width=35 border='0' alt='Terug naar begin'></a>
</td></tr><tr>
<td class='noprint' Style='font-size:8pt;color:blue;text-align:center;padding:1pt;'>Print<br>deze pagina</td>
<td class='noprint' Style='font-size:8pt;color:blue;text-align:center;padding:1pt;'>Terug<br>naar scores</td>
</tr>
</table>



<?php


echo "<blockquote><table border = 1 Style='empty-cells: show;background-color:white;' width=80%>";


echo "		<tr>"; 


if ($voorgeloot == 'On') {
echo " 	  <th Style='width=4pt;'>Lot</th>"; 
}
else {
echo " 	  <th Style='width=40pt;'>Nr</th>"; 
}

echo "		<th Style='width=400;'>Naam</th>"; 





echo "  </tr>";

//<!---- Standaard regel ---->
$i=1;
echo "  <tr>";
  while($row = mysql_fetch_array( $score )) {
	
	 
      
    if ($voorgeloot == 'On') {
     echo "<td>";  
      echo $row['Lot_nummer'];
      echo "</td>";  
  }
  else {
  	 echo "<td style ='text-align: right;padding:2pt;'>";  
    echo $i;
    echo "</td>";  
  }
  
      	
    echo "<td>";  
    echo $row['Naam'];
    echo "</td>";   
       
	

  	


  
    
   echo "</tr>"; 
$i++;
} ;


   
echo "</table>"; 
echo "</blockquote>"; 

?>
</body>

</html>
